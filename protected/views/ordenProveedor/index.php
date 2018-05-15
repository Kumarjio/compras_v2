<?php
$this->breadcrumbs=array(
	'Orden Proveedor',
);

$this->menu=array(
	array('label'=>'Create OrdenProveedor','url'=>array('create')),
	array('label'=>'Manage OrdenProveedor','url'=>array('admin')),
);
?>

<h1>Orden Proveedor</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
