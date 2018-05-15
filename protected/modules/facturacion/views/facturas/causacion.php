<?php
$this->breadcrumbs=array(
	'Facturas'=>array('admin'),
	'Listar',
);

$this->menu=array(
	array('label'=>'Listar','url'=>array('admin'), 'icon'=>'home'),
	array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
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


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'facturas-grid',
	'dataProvider'=>$model->search_causacion(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		array(
		      'header' => 'Número de Factura',
		      'name' => 'nro_factura',
		      'type' => 'raw',
		      'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/update", array("id"=>$data->id_factura)))'
		      ),
		'nit_proveedor',
                array(
                    'name'=>'nit_proveedor',
                    'value'=>'$data->nitProveedor->razon_social'
                ),
                array(
                    'name'=>'valor_productos',
                    'type'=>'number'
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
)); ?>
