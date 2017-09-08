<?php
/* @var $this TrazabilidadController */
/* @var $model Trazabilidad */

$this->breadcrumbs=array(
	'Trazabilidads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Trazabilidad', 'url'=>array('index')),
	array('label'=>'Manage Trazabilidad', 'url'=>array('admin')),
);
?>

<h1>Create Trazabilidad</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>