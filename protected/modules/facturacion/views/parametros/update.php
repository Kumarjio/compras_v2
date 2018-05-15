<?php
$this->breadcrumbs=array(
	'Parametros'=>array('admin'),
	$model->id_parametro=>array('view','id'=>$model->id_parametro),
	'Actualizar',
);


$this->menu=array(
  array('label'=>'Actualizar','url'=>array('update','id'=>$model->id_parametro),'icon'=>'edit'),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>