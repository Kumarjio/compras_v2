<?php
$this->breadcrumbs=array(
	'Producto',
);

$this->menu=array(
	array('label'=>'Create Producto','url'=>array('create')),
	array('label'=>'Manage Producto','url'=>array('admin')),
);
?>

<h1>Producto</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
