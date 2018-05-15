<?php
$this->breadcrumbs=array(
	'Proveedor'=>array('/proveedor/admin'),
	'Contacto Proveedor'=>array('admin', 'id_proveedor' => $model->nit),
	$model->id,
);

$this->menu=array(
  array('label'=>'Crear','url'=>array('create', 'id_proveedor' => $model->nit), 'icon'=>'plus-sign'),
  array('label'=>'Actualizar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
);

?>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		'apellido',
		'telefono',
		'celular',
		'email',
		'ciudad',
		'departamento',
		'direccion',
	),
)); ?>
