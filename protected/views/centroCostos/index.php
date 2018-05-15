<?php
$this->breadcrumbs=array(
	'Centro Costos',
);

$this->menu=array(
	array('label'=>'Create CentroCostos','url'=>array('create')),
	array('label'=>'Manage CentroCostos','url'=>array('admin')),
);
?>

<h1>Centro Costos</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
