<?php
$this->breadcrumbs=array(
	'Facturas',
);

$this->menu=array(
	array('label'=>'Create Facturas','url'=>array('create')),
	array('label'=>'Manage Facturas','url'=>array('admin')),
);
?>

<h1>Facturas</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
