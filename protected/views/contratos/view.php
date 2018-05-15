<?php
$this->breadcrumbs=array(
	'Contratos'=>array('admin'),
	$model->id,
);

$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
);

?>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_cargo',
		'salario',
		'id_empleado',
		'id_empleador',
		'fecha_inicio',
		'fecha_fin',
		'id_motivo_ingreso',
		'id_motivo_retiro',
		'creacion',
		'actualizacion',
	),
)); ?>
