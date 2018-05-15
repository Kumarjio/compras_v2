<?php
$this->breadcrumbs=array(
	'Cargos',
);

$this->menu=array(
	array('label'=>'Create Cargos','url'=>array('create')),
	array('label'=>'Manage Cargos','url'=>array('admin')),
);
?>

<h1>Cargos</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
