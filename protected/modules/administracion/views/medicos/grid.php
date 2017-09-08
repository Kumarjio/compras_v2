<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'medicos-grid',
			'dataProvider'=>$model->search(),
			'enableSorting' => false,
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