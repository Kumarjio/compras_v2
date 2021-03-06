<?php
$this->breadcrumbs=array(
	'Facturas'=>array('admin'),
	'Listar',
);

$this->menu=array(
	array('label'=>'Listar','url'=>array('admin'), 'icon'=>'home'),
	array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('facturas-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'facturas-grid',
	'dataProvider'=>$model->search_administrativo(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		array(
		      'header' => 'Número de Factura',
		      'name' => 'nro_factura',
		      'type' => 'raw',
		      'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/update", array("id"=>$data->id_factura)))'
		      ),
		'nit_proveedor',
                array(
                    'name'=>'nit_proveedor',
                    'value'=>'$data->nitProveedor->razon_social'
                ),
                array(
                    'name'=>'valor_productos',
                    'type'=>'number'
                ),
                array(
                    'name'=>'paso_wf',
                    'value'=>'$data->labelEstado($data->paso_wf)'
                ),
                array(
                    'name'=>'usuario_actual',
                    'value'=>'$data->usuarioActual->nombre_completo'
                ),
            
		/*
		'rte_fte',
		'valor_rte_fte',
		'rte_iva',
		'valor_rte_iva',
		'rte_ica',
		'valor_rte_ica',
		'rte_timbre',
		'valor_rte_timbre',
		'id_centro_costos',
		'nro_pagos',
		'cuenta_x_pagar',
		'id_cuenta_contable',
		'analista_encargado',
		'fecha_vencimiento',
		'fecha_factura',
		'fecha_recibido',
		'path_imagen',
		'paso_wf',
		'creacion',
		'actualizacion',
		*/
		array(
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        'delete' => array(
                            'visible' => '$data->paso_wf == "swFacturas/indexacion"'
                            )
                        )
		),
	),
)); ?>
