<?php
$this->breadcrumbs=array(
	'Estado',
);

$this->menu=array(
	array('label'=>'Create Estado','url'=>array('create')),
	array('label'=>'Manage Estado','url'=>array('admin')),
);
?>

<h1>Estado</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
