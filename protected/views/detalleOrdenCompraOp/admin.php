<?php
$this->breadcrumbs=array(
	'Solicitud de Orden Compra'
);

$this->menu=array(
	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
	array('label'=>'Agregar Productos','url'=>array('/orden/update', 'id' => $id_orden), 'icon'=>'plus-sign'),
);

?>

<div class="panel panel-default">
	 <div class="panel-heading" align="center"><big><strong class="gris"><h2>Revisa tu orden: </h2></strong></big></div>
	 <div class="panel-body">

<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'detalle-orden-compra-grid',
	'dataProvider'=>$model->search($id_orden),
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
		array('value' => '$data->fecha_entrega', 'header' => 'Fecha de Entrega'),
        /*
		'cantidad',
		*/
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template' => '{delete}'
		),
	),
)); ?>


<a href="<?php echo $this->createUrl('orden/crearOrdenCompra', array('id'=>$id_orden)); ?>" class="btn btn-primary">Crear Orden de Compra</a>
	</div>
</div>