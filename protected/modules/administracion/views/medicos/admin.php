<?php
$this->breadcrumbs=array(
	'Medicoses'=>array('admin'),
	'Administrar',
);
$this->setPageTitle('Administración de Medicos');
?>
<div class="col-lr-12">
    <p><a href="<?php echo $this->createUrl('Medicos/create')?>" class="btn-u btn-u-md btn-u-default"><i class="icon-cloud-download"></i> Crear nuevo Medicos</a></p>
</div>

<div class="panel panel-blue margin-bottom-40">
	<div class="panel-heading">
	    <h3 class="panel-title"><i class="icon-tasks"></i> Lista de Medicos</h3>
	</div>
	<div class="panel-body"> 
		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'medicos-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				'id_medico',
		'cedula',
		'primer_nombre',
		'segundo_nombre',
		'primer_apellido',
		'segundo_apellido',
		/*
		'direccion',
		'telefono_fijo',
		'ciudad',
		'celular',
		'correo',
		'tarjeta_profesional',
		'nro_cuenta_bancaria',
		'entidad_bancaria',
		'estado',
		*/
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>
