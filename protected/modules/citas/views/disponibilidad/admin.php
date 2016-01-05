<?php
$this->breadcrumbs=array(
	'Disponibilidads'=>array('admin'),
	'Administrar',
);
$this->setPageTitle('Administración de Disponibilidad');
?>
<div class="col-lr-12">
    <p><a href="<?php echo $this->createUrl('Disponibilidad/create')?>" class="btn-u btn-u-md btn-u-default"><i class="icon-cloud-download"></i> Crear nuevo Disponibilidad</a></p>
</div>

<div class="panel panel-blue margin-bottom-40">
	<div class="panel-heading">
	    <h3 class="panel-title"><i class="icon-tasks"></i> Lista de Disponibilidad</h3>
	</div>
	<div class="panel-body"> 
		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'disponibilidad-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				'id_disponibilidad',
		'fecha',
		'inicio',
		'fin',
		'id_recurso',
		'estado',
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>
