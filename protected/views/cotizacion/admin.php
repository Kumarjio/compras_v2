<?php
$this->breadcrumbs=array(
	'Cotizacion'
);

$this->menu=array(
	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
	array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cotizacion-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'cotizacion-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		'id',
		'producto_orden',
		'nit',
		'cantidad',
		'valor_unitario',
		'total_compra',
		/*
		'descripcion',
		'elegido_compras',
		'elegido_usuario',
		*/
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'buttons' => array(
				'update' => array(
					'url' => 'Cotizacion::model()->urlGrid("subir",$data->id)',
					'icon' => 'arrow-up',
					'options' => array(
						'class' => 'upload-cot' 
					)
				),
			)
		)
	),
)); ?>
