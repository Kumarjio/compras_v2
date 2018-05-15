<?php
$this->breadcrumbs=array(
	'Vinculacion Proveedor Juridico'
);

$this->menu=array(
	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
);

?>

<h2>Proveedores Anteriores: </h2>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'vinculacion-proveedor-juridico-grid',
	'dataProvider'=>$model->search_anteriores(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		//'id',
		'id_orden',
		array('name' => 'paso_wf', 'header' => 'Estado Actual', 'value' => 'VinculacionProveedorJuridico::model()->labelEstado($data->paso_wf)'),
		//'usuario_actual',
		array('header' => 'NIT Proveedor', 'name' => 'id_proveedor', 'value' => '$data->id_proveedor'),
		array('header' => 'Razon Social Proveedor', 'name' => 'razon_social', 'value' => '$data->proveedor->razon_social'),
	),
)); ?>