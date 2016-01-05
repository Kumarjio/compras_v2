<?php
$this->breadcrumbs=array(
	'Citas'=>array('admin'),
	'Administrar',
);
$this->setPageTitle('Administración de Cita');
?>
<div class="col-lr-12">
    <p><a href="<?php echo $this->createUrl('Cita/create')?>" class="btn-u btn-u-md btn-u-default"><i class="icon-cloud-download"></i> Crear nuevo Cita</a></p>
</div>

<div class="panel panel-blue margin-bottom-40">
	<div class="panel-heading">
	    <h3 class="panel-title"><i class="icon-tasks"></i> Lista de Cita</h3>
	</div>
	<div class="panel-body"> 
		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'cita-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				'id_cita',
		'id_paciente',
		'id_disponibilidad',
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>
