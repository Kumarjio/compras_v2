<?php
$this->breadcrumbs=array(
	'Proveedor',
);

$this->menu=array(
	array('label'=>'Create Proveedor','url'=>array('create')),
	array('label'=>'Manage Proveedor','url'=>array('admin')),
);
?>

<h1>Proveedor</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
