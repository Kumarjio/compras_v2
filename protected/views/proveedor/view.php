<?php
$this->breadcrumbs=array(
	'Proveedor'=>array('admin'),
	$model->nit,
);

$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Editar','url'=>array('update','id'=>$model->nit),'icon'=>'edit'),
  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->nit),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
  array('label'=>'Agregar Contacto','url'=>array('/contactoProveedor/create', 'id_proveedor' => $model->nit),'icon'=>'book'),
);

?>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'nit',
		'razon_social',
	),
)); ?>
