<?php
$this->breadcrumbs=array(
	'Parametros',
);

$this->menu=array(
	array('label'=>'Create Parametros','url'=>array('create')),
	array('label'=>'Manage Parametros','url'=>array('admin')),
);
?>

<h1>Parametros</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
