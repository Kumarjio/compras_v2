<?php
$this->breadcrumbs=array(
	'Preaviso',
);

$this->menu=array(
	array('label'=>'Create Preaviso','url'=>array('create')),
	array('label'=>'Manage Preaviso','url'=>array('admin')),
);
?>

<h1>Preaviso</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
