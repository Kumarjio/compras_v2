<?php
$this->breadcrumbs=array(
	'Preaviso'=>array('admin'),
	$model->id,
);

$this->menu=array(
  array('label'=>'Actualizar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'anios',
		'meses',
		'dias',
		'total_dias',
	),
)); ?>
