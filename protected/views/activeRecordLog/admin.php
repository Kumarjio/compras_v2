<?php
$this->breadcrumbs=array(
	'Active Record Log'=>array('admin'),
	'Home',
);

$this->menu=array(
	array('label'=>'Home','url'=>array('admin'), 'icon'=>'home'),
	array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('active-record-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'active-record-log-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'action',
		'model',
		'idmodel',
		'iduser',
		'field',
		/*
		'username',
		'description',
		'description_new',
		'fecha',
		*/
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
