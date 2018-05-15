<?php
$this->breadcrumbs=array(
	'Parametros'=>array('admin'),
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
	$.fn.yiiGridView.update('parametros-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'parametros-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		'id_parametro',
                array(
                    'name'=>'id_empl_listas',
                    'value'=>  'Empleados::model()->getNombre($data->id_empl_listas)'
                ),
                array(
                    'name'=>'id_empl_clientes',
                    'value'=>  'Empleados::model()->getNombre($data->id_empl_clientes)'
                ),
                array(
                    'name'=>'id_empl_operaciones',
                    'value'=>  'Empleados::model()->getNombre($data->id_empl_operaciones)'
                ),
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}'
		),
	),
)); ?>
