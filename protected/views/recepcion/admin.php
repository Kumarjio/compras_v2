<?php
/* @var $this RecepcionController */
/* @var $model Recepcion */

$this->breadcrumbs=array(
	'Recepcions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Recepcion', 'url'=>array('index')),
	array('label'=>'Create Recepcion', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#recepcion-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Recepcions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'recepcion-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'na',
		'documento',
		'tipologia',
		'ciudad',
		'tipo_documento',
		/*
		'tipo_entrega',
		'user_recepcion',
		'fecha_recepcion',
		'fecha_entrega',
		'hora_entrega',
		'punteo_cor',
		'impreso',
		'na',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
