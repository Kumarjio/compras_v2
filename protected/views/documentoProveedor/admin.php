<?php
$this->breadcrumbs=array(
	'Documento Proveedor'=>array('admin'),
	'Listar',
);

$this->menu=array(
	array('label'=>'Listar','url'=>array('admin'), 'icon'=>'home'),
	//array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('documento-proveedor-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'documento-proveedor-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		'id_docpro',
		'proveedor',
		array(
		'header'=>'Proveedor',
		'value'=>'DocumentoProveedor::traerNombreProveedor($data->proveedor)'
		),
		'tipo_documento',
		'fecha_inicio',
		'fecha_fin',
		'objeto',
		'valor',
		'fecha_firma',
		'tiempo_preaviso',
		'cuerpo_contrato',
		'anexos',
		'polizas',
		'tiempo_proroga',
		/*'area',
		'proroga_automatica',
		'consecutivo_contrato',
		'responsable_compras',
		'responsable_proveedor',*/
		'motivo_terminacion',
		'fecha_terminacion',
	
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
