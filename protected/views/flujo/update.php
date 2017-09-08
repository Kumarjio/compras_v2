<?php
$this->breadcrumbs=array(
	'Flujos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Flujo','url'=>array('index')),
	array('label'=>'Create Flujo','url'=>array('create')),
	array('label'=>'View Flujo','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Flujo','url'=>array('admin')),
	);
	?>

	<h1>Update Flujo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>