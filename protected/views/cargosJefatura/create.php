<?php
$this->breadcrumbs=array(
	'Cargos Jefatura'=>array('admin'),
	'Crear',
);

$this->menu=array(
  array('label'=>'Home','url'=>array('admin'), 'icon'=>'home'),
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'pencil'),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>