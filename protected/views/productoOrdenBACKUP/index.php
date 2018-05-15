<?php
$this->breadcrumbs=array(
	'Producto Orden',
);

$this->menu=array(
	array('label'=>'Create ProductoOrden','url'=>array('create')),
	array('label'=>'Manage ProductoOrden','url'=>array('admin')),
);
?>

<h1>Producto Orden</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
