<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'paciente-grid',
			'dataProvider'=>$model->search(),
			'enableSorting' => false,
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