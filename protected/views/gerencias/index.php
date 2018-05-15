<?php
$this->breadcrumbs=array(
	'Gerencias',
);

$this->menu=array(
	array('label'=>'Create Gerencias','url'=>array('create')),
	array('label'=>'Manage Gerencias','url'=>array('admin')),
);
?>

<h1>Gerencias</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
