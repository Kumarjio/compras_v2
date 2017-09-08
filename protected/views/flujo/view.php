<?php
$this->breadcrumbs=array(
	'Flujos'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Flujo','url'=>array('index')),
array('label'=>'Create Flujo','url'=>array('create')),
array('label'=>'Update Flujo','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Flujo','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Flujo','url'=>array('admin')),
);
?>

<h1>View Flujo #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'actividad',
		'sucesion',
		'tipologia',
),
)); ?>
