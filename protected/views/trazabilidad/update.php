<?php
/* @var $this TrazabilidadController */
/* @var $model Trazabilidad */

$this->breadcrumbs=array(
	'Trazabilidads'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Trazabilidad', 'url'=>array('index')),
	array('label'=>'Create Trazabilidad', 'url'=>array('create')),
	array('label'=>'View Trazabilidad', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Trazabilidad', 'url'=>array('admin')),
);
?>

<h1>Update Trazabilidad <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>