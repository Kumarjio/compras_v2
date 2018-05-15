<?php
$this->breadcrumbs=array(
	'Preaviso'=>array('admin'),
	'Listar',
);

$this->menu=array(
	array('label'=>'Listar','url'=>array('admin'), 'icon'=>'home'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('preaviso-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'preaviso-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		'anios',
		'meses',
		'dias',
		'total_dias',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{update}'
		),
	),
)); ?>
