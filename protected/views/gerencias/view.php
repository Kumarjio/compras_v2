<?php
$this->breadcrumbs=array(
	'Gerencias'=>array('admin'),
	$model->id,
);

$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
  //array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		array(
			'name'=>'es_direccion',
			'value'=>($model->es_direccion)? "Si" : "No"
		),
		array(
			'name'=>'id_vice',
			'value'=>$model->idVice->nombre
		),
	),
)); ?>
