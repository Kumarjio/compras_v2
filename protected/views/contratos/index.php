<?php
$this->breadcrumbs=array(
	'Contratos',
);

$this->menu=array(
	array('label'=>'Create Contratos','url'=>array('create')),
	array('label'=>'Manage Contratos','url'=>array('admin')),
);
?>

<h1>Contratos</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
