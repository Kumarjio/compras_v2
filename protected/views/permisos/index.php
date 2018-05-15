<?php
$this->breadcrumbs=array(
	'Permisos',
);

$this->menu=array(
	array('label'=>'Create Permisos','url'=>array('create')),
	array('label'=>'Manage Permisos','url'=>array('admin')),
);
?>

<h1>Permisos</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
