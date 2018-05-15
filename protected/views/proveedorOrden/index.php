<?php
$this->breadcrumbs=array(
	'Proveedor Orden',
);

$this->menu=array(
	array('label'=>'Create ProveedorOrden','url'=>array('create')),
	array('label'=>'Manage ProveedorOrden','url'=>array('admin')),
);
?>

<h1>Proveedor Orden</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
