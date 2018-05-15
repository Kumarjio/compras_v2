<?php
$this->breadcrumbs=array(
	'Cotizacion Regalos'=>array('admin'),
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
	$.fn.yiiGridView.update('cotizacion-regalos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'cotizacion-regalos-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'id_cotizacion',
		'valor',
		'descripcion',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
