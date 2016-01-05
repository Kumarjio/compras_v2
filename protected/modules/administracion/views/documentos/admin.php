<?php
$this->breadcrumbs=array(
	'Documentoses'=>array('admin'),
	'Administrar',
);
$this->setPageTitle('Administración de Documentos');
?>
<div class="col-lr-12">
    <p><a href="<?php echo $this->createUrl('Documentos/create')?>" class="btn-u btn-u-md btn-u-default"><i class="icon-cloud-download"></i> Crear nuevo Documentos</a></p>
</div>

<div class="panel panel-blue margin-bottom-40">
	<div class="panel-heading">
	    <h3 class="panel-title"><i class="icon-tasks"></i> Lista de Documentos</h3>
	</div>
	<div class="panel-body"> 
		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'documentos-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				'id_documento',
                                'nombre_documento',
                                array(
                                    'name'=>'estado',
                                    'value'=>'($data->estado)? "Activo" : "Inactivo"'
                                ),
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>
