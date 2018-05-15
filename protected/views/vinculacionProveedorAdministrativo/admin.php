<?php
$this->breadcrumbs=array(
	'Vinculacion Proveedor Administrativo'
);

$this->menu=array(
	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
	array('label'=>'Anteriores','url'=>array('anteriores')),
);

?>

<h2>Proveedores Asignados: </h2>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'vinculacion-proveedor-administrativo-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		//'id',
		'id_orden',
		array('name' => 'paso_wf', 'header' => 'Estado Actual', 'value' => 'VinculacionProveedorAdministrativo::model()->labelEstado($data->paso_wf)'),
		//'usuario_actual',
		array('header' => 'NIT Proveedor', 'name' => 'id_proveedor', 'type' => 'raw', 'value' => 'CHtml::link($data->id_proveedor, Yii::app()->createUrl("VinculacionProveedorAdministrativo/update", array("id"=>$data->id)))'),
		array('header' => 'Razon Social Proveedor', 'name' => 'razon_social', 'type' => 'raw', 'value' => 'CHtml::link($data->proveedor->razon_social, Yii::app()->createUrl("VinculacionProveedorAdministrativo/update", array("id"=>$data->id)))'),
	),
)); ?>
