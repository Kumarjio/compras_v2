<?php
$this->breadcrumbs=array(
  'Facturas'=>array('consulta'),
  'Listar',
);
$this->menu=array(
  array('label'=>'Listar','url'=>array('admin'), 'icon'=>'home'),
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign','visible' => array_intersect(array('CYC403','NORMAL'), Yii::app()->user->permisos)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
  $('.search-form').toggle();
  return false;
});
$('.search-form form').submit(function(){
  $.fn.yiiGridView.update('facturas-grid', {
    data: $(this).serialize()
  });
  return false;
});
");
?>

<h2>Consulta Facturas </h2>
<?php 
    $this->widget('bootstrap.widgets.BootGridView',array(
  'id'=>'facturas-grid-consulta',
  'dataProvider'=>$model->search_consulta(),
  'type'=>'striped bordered condensed',
  'filter'=>$model,
  'columns'=>array(
          array(
                 'header' => 'Número de Factura',
                 'name' => 'nro_factura',
                 'type' => 'raw',
                 'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/view", array("id"=>$data->id_factura)))'
          ),
          'nit_proveedor',
          array(
              'name'=>'razon_social',
              'header'=>'Razón Social',
              'value'=>'$data->nitProveedor->razon_social'
          ),
          array(
            'name'=>'fecha_vencimiento',
            'value'=>'date("Y-m-d",strtotime($data->fecha_vencimiento))'
          ),
          array(
            'name'=>'analista_encargado',
            'value'=>'$data->responsable->nombre_completo'
          ),
          array(
              'name'=>'paso_wf',
              'value'=>'$data->labelEstado($data->paso_wf)'
          ),
          array(
              'name'=>'usuario_actual',
              'value'=>'$data->usuarioActual->nombre_completo'
          ),

            
  ),
)); 
 ?>
