<?php
$this->breadcrumbs=array(
	'Pacientes'=>array('admin'),
	'Administrar',
);
$this->setPageTitle('Administración de Pacientes');
?>
<div class="col-lr-12">
    <p><a href="<?php echo $this->createUrl('Pacientes/create')?>" class="btn-u btn-u-md btn-u-default"><i class="icon-cloud-download"></i> Crear nuevo Pacientes</a></p>
</div>

<div class="panel panel-blue margin-bottom-40">
	<div class="panel-heading">
	    <h3 class="panel-title"><i class="icon-tasks"></i> Lista de Pacientes</h3>
	</div>
	<div class="panel-body"> 
		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'pacientes-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				'id_paciente',
		'cedula',
		'primer_nombre',
		'segundo_nombre',
		'primer_apellido',
		'segundo_apellido',
		/*
		'sexo',
		'fecha_nacimiento',
		'id_estado_civil',
		'id_ciudad',
		'barrio',
		'direccion',
		'telefono',
		'celular',
		'correo',
		'id_grupo_poblacion',
		'id_clasificacion',
		'id_grupo_etnico',
		'id_categoria',
		'id_tipo_afiliado',
		'id_eps',
		'id_ocupacion',
		'id_nivel_educativo',
		'nombre_acompanante',
		'cc_acompanante',
		'id_ciudad_acompanante',
		'telefono_acompanante',
		'id_parentezco',
		'fecha_ingreso',
		*/
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>
