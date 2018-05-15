<?php
$this->breadcrumbs=array(
	'Cartases'=>array('admin'),
	'Administrar',
);
$this->setPageTitle('Administración de Cartas');
?>
<div class="col-lr-12">
    <p><a href="<?php echo $this->createUrl('Cartas/create')?>" class="btn-u btn-u-md btn-u-default"><i class="icon-cloud-download"></i> Crear nuevo Cartas</a></p>
</div>

<div class="panel panel-blue margin-bottom-40">
	<div class="panel-heading">
	    <h3 class="panel-title"><i class="icon-tasks"></i> Lista de Cartas</h3>
	</div>
	<div class="panel-body"> 
		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'cartas-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				'id',
		'na',
		'id_trazabilidad',
		'id_plantilla',
		'mensaje',
		'carta',
		/*
		'nombre_destinatario',
		'id_tipo_entrega',
		'id_proveedor',
		'punteo',
		'impreso',
		'principal',
		'id_firma',
		'direccion',
		'id_ciudad',
		'correo',
		'telefono',
		'fecha_respuesta',
		'usuario_respuesta',
		*/
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>
