<?php
$this->breadcrumbs=array(
	'Pacientes'=>array('admin'),
	'Administrar',
);
$this->setPageTitle('Administración de Paciente');
?>
<div class="col-lr-12">
    <p><a href="<?php echo $this->createUrl('Paciente/create')?>" class="btn-u btn-u-md btn-u-default"><i class="icon-cloud-download"></i> Crear nuevo Paciente</a></p>
</div>

<div class="panel panel-blue margin-bottom-40">
	<div class="panel-heading">
	    <h3 class="panel-title"><i class="icon-tasks"></i> Lista de Paciente</h3>
	</div>
	<div class="panel-body"> 
		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'paciente-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				'nombre',
		'cedula',
		'celular',
		'telefono',
		'correo',
		'id_paciente',
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>
