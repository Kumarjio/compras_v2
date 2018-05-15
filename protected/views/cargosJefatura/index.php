<?php
$this->breadcrumbs=array(
	'Cargos Jefatura',
);

$this->menu=array(
	array('label'=>'Create CargosJefatura','url'=>array('create')),
	array('label'=>'Manage CargosJefatura','url'=>array('admin')),
);
?>

<h1>Cargos Jefatura</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
