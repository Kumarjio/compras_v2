<?php
$this->breadcrumbs=array(
	'Poliza Documento'=>array('admin'),
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
	$.fn.yiiGridView.update('poliza-documento-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'poliza-documento-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		'id_poldoc',
		'fecha_inicio',
		'fecha_fin',
		'fecha_fin_ind',
		'id_tipo_poliza',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
