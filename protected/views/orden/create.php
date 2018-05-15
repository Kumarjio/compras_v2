<?php
$this->breadcrumbs=array(
	'Ordenes de Compra'=>array('admin'),
	'Crear',
);

$this->menu=array(
  array('label'=>'Home', 'url'=>array('admin'), 'icon'=>'home'),
  array('label'=>'Crear', 'url'=>array('creates'), 'icon'=>'pencil'),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

