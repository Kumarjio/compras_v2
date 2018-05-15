<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'cartas-grid',
			'dataProvider'=>$model->search(),
			'enableSorting' => false,
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