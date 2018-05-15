<?php
$this->breadcrumbs=array(
	'Jefaturas',
);

$this->menu=array(
	array('label'=>'Create Jefaturas','url'=>array('create')),
	array('label'=>'Manage Jefaturas','url'=>array('admin')),
);
?>

<h1>Jefaturas</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
