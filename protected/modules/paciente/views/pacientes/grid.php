<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'pacientes-grid',
			'dataProvider'=>$model->search(),
			'enableSorting' => false,
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