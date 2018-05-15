<?php
$this->breadcrumbs=array(
	'Poliza Documento'=>array('admin'),
	$model->id_poldoc,
);

$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Actualizar','url'=>array('update','id'=>$model->id_poldoc),'icon'=>'edit'),
  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_poldoc),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id_poldoc',
		'fecha_inicio',
		'fecha_fin',
		'fecha_fin_ind',
		'id_tipo_poliza',
	),
)); ?>
