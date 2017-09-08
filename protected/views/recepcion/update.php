<?php
/* @var $this RecepcionController */
/* @var $model Recepcion */

$this->breadcrumbs=array(
	'Recepcions'=>array('index'),
	$model->na=>array('view','na'=>$model->na),
	'Update',
);

$this->menu=array(
	array('label'=>'List Recepcion', 'url'=>array('index')),
	array('label'=>'Create Recepcion', 'url'=>array('create')),
	array('label'=>'View Recepcion', 'url'=>array('view', 'na'=>$model->na)),
	array('label'=>'Manage Recepcion', 'url'=>array('admin')),
);
?>

<h1>Update Recepcion <?php echo $model->na; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>