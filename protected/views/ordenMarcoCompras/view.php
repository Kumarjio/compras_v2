<?php
$this->breadcrumbs=array(
	'Orden Marco Comprases'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List OrdenMarcoCompras','url'=>array('index')),
array('label'=>'Create OrdenMarcoCompras','url'=>array('create')),
array('label'=>'Update OrdenMarcoCompras','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete OrdenMarcoCompras','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage OrdenMarcoCompras','url'=>array('admin')),
);
?>

<h1>View OrdenMarcoCompras #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre_compra',
		'resumen_breve',
		'fecha_solicitud',
		'id_usuario',
		'usuario_actual',
		'paso_wf',
		'id_usuario_reemplazado',
),
)); ?>
