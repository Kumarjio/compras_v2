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
<div class="tab-v1">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#xpagar" data-toggle="tab">Facturas por Pagar</a></li>
          <li><a href="#pagadas" data-toggle="tab">Facturas Pagadas</a></li>
        </ul>   
        <div class="tab-content">
            <div class="tab-pane active" id="xpagar"><br>

<?php $this->widget('bootstrap.widgets.BootButton', array(
                        'label'=>'Actualizar Facturas',
                        'url'=>Yii::app()->createUrl("facturacion/facturas/consultarFacturas"),
                        'type'=>'primary',
                        'htmlOptions'=>array('style' => 'margin:-9px 0px 0px 35px; '),
                    )); ?>                
                
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'facturas-ope-cxp',
	'dataProvider'=>$model->search_operaciones(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
    'updateSelector' => "{page}, #facturas-ope-cxp thead th a",
	'columns'=>array(
		array(
		      'header' => 'Número de Factura',
		      'name' => 'nro_factura',
		      'type' => 'raw',
		      'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/view", array("id"=>$data->id_factura)))'
		      ),
		'nit_proveedor',
                array(
                    'header'=>'Nombre',
                    'name'=>'razon_social',
                    'value'=>'$data->nitProveedor->razon_social'
                ),
                array(
                    'name'=>'valor_productos',
                    'type'=>'number'
                ),
                'fecha_vencimiento',
                array(
                    'name'=>'paso_wf',
                    'value'=>'$data->labelEstado($data->paso_wf)'
                ),
                array(
                    'name'=>'usuario_actual',
                    'value'=>'$data->usuarioActual->nombre_completo'
                ),
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
            </div>
            <div class="tab-pane" id="pagadas">
                
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'facturas-pagadas',
	'dataProvider'=>$model->search_operaciones_pagadas(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
    'updateSelector' => "{page}, #facturas-pagadas thead th a",
	'columns'=>array(
		array(
		      'header' => 'Número de Factura',
		      'name' => 'nro_factura',
		      'type' => 'raw',
		      'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/view", array("id"=>$data->id_factura)))'
		      ),
		'nit_proveedor',
                array(
                    'name'=>'razon_social',
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
                    'header'=>'Estado Lote',
                    'value'=>'$data->estadoLote()'
                ),
                array(
                    'name'=>'usuario_actual',
                    'value'=>'$data->usuarioActual->nombre_completo'
                ),
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
            </div>
        </div>
    </div>
