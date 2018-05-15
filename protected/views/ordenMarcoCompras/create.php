<?php
$this->breadcrumbs=array(
	'Orden Marco Comprases'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List OrdenMarcoCompras','url'=>array('index')),
array('label'=>'Manage OrdenMarcoCompras','url'=>array('admin')),
);
?>

<h1>Create OrdenMarcoCompras</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>