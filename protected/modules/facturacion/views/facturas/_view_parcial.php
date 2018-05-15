<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
                array(
                    'name'=>'paso_wf',
                    'value'=>$model->labelEstado($model->paso_wf)
                ),
		'nit_proveedor',
		'id_factura',
		'fecha_recibido',
		'fecha_factura',
		'fecha_vencimiento',
                array(
                    'name'=>'valor_productos',
                    'type'=>'number',
                ),
                'nro_factura',
//		'nro_pagos',
//		'cuenta_x_pagar',
//		'id_cuenta_contable',
//		'analista_encargado',
//		'path_imagen',
//		'paso_wf',
//		'creacion',
//		'actualizacion',
	),
)); ?>
