<?php
$this->breadcrumbs=array(
	'Permisos'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);


$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>