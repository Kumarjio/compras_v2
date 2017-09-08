<?php
/* @var $this RecepcionController */
/* @var $model Recepcion */

$this->breadcrumbs=array(
	'Recepcions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Recepcion', 'url'=>array('index')),
	array('label'=>'Manage Recepcion', 'url'=>array('admin')),
);
?>

<h1>Create Recepcion</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>