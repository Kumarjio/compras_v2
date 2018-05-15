<?php
$this->breadcrumbs=array(
	'Facturas'=>array('admin'),
	'Crear',
);

$this->menu=array(
  array('label'=>'Listar','url'=>array('admin'), 'icon'=>'home'),
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'pencil'),
);
?>

<?php echo $this->renderPartial('_form_create', array('model'=>$model)); ?>