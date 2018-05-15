<?php 
  
?>

<div id="content">
<?php 
$this->widget('booster.widgets.TbGridView',array(
  'id'=>'informe-efectividad-grid',
  'dataProvider'=>$dataProvider,
  'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
  'type'=>'striped bordered condensed',
  'columns'=>array(
    'usuario_anterior',
    'usuario_nuevo',
		array(
		    'name'=>'estado_anterior',
            'value'=>'Orden::model()->labalEstado($data->estado_anterior)'
		),
		array(
		    'name'=>'estado_nuevo',
            'value'=>'Orden::model()->labalEstado($data->estado_nuevo)'
		),
    
    'fecha'  
  )
)); ?>
</div>