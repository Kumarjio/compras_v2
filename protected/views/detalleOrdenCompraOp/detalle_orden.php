<?php
$this->breadcrumbs=array(
	'Orden de Compra'
);

$this->menu=array(
	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
);

?>

<h2>Productos solicitados en la orden de compra: <?php echo $id_orden_compra ?></h2>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'detalle-orden-compra-grid',
	'dataProvider'=>$model->search_2($id_orden_compra),
	'type'=>'striped bordered condensed',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		//'id_orden_compra',
		//'id_producto',
		//'id_proveedor',
		//'id_direccion',
		//'id_orden_solicitud',
		array('value' => '$data->idProducto->nombre', 'header' => 'Producto'),
		array('value' => '$data->idOrden->nombre_compra', 'header' => 'Nombre Solicitud'),
		array('value' => '$data->idOrdenProducto->direccion_entrega', 'header' => 'Direccion'),
		array('value' => '$data->idProveedor->razon_social', 'header' => 'Proveedor'),
		array('value' => '$data->cantidad', 'header' => 'Cantidad'),
		/*
		'cantidad',
		*/
	),
)); ?>

