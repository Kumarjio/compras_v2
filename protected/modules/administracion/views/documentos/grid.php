<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'documentos-grid',
			'dataProvider'=>$model->search(),
			'enableSorting' => false,
			'columns'=>array(
				'id_documento',
		'nombre_documento',
		'estado',
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>