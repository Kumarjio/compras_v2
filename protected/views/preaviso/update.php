<?php
$this->breadcrumbs=array(
	'Preaviso'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);


$this->menu=array(
  array('label'=>'Actualizar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>