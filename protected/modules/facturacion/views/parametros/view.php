<?php
$this->breadcrumbs=array(
	'Parametros'=>array('admin'),
	$model->id_parametro,
);

$this->menu=array(
  array('label'=>'Actualizar','url'=>array('update','id'=>$model->id_parametro),'icon'=>'edit'),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id_parametro',
		'id_empl_listas',
		'id_empl_clientes',
	),
)); ?>
