<?php 
  
?>

<div id="content">
<?php 
$this->widget('bootstrap.widgets.BootGridView',array(
  'id'=>'informe-efectividad-grid',
  'dataProvider'=>$dataProvider,
  'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
  'type'=>'striped bordered condensed',
  'columns'=>array(
    'usuario_anterior',
    'usuario_nuevo',
		array(
		    'name'=>'estado_anterior',
            'value'=>'Facturas::model()->labelEstado($data->estado_anterior)'
		),
		array(
		    'name'=>'estado_nuevo',
            'value'=>'Facturas::model()->labelEstado($data->estado_nuevo)'
		),
    
    'fecha'  
  )
)); ?>
</div>