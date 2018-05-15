<?php
$this->breadcrumbs=array(
	'Orden'=>array('admin'),
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
		'orden',
		'tipo_compra',
		'nombre_compra',
		'resumen_breve',
		'id_gerencia',
		'id_jefatura',
		'fecha_solicitud',
		'id_gerente',
		'id_jefe',
		'id_usuario',
		'centro_costos',
		'cuenta_contable',
		'estado',
		'valor_presupuestado',
		'mes_presupuestado',
		'detalle',
		'fecha_entrega',
		'direccion_entrega',
		'responsable',
		'requiere_acuerdo_servicios',
		'requiere_polizas_cumplimiento',
		'validacion_usuario',
		'validacion_jefe',
		'validacion_gerente',
		'paso_wf',
	),
)); ?>
