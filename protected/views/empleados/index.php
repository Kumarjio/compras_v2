<?php
$this->breadcrumbs=array(
	'Empleados',
);

$this->menu=array(
	array('label'=>'Create Empleados','url'=>array('create')),
	array('label'=>'Manage Empleados','url'=>array('admin')),
);
?>

<h1>Empleados</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
