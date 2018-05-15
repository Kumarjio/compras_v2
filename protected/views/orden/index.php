<?php
$this->breadcrumbs=array(
	'Orden',
);

$this->menu=array(
	array('label'=>'Create Orden','url'=>array('create')),
	array('label'=>'Manage Orden','url'=>array('admin')),
);
?>

<h1>Orden</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
