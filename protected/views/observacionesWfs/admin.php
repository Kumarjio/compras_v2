<?php
$this->breadcrumbs=array(
	'Observaciones Wfs'=>array('admin'),
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
	$.fn.yiiGridView.update('observaciones-wfs-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'observaciones-wfs-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		'id',
		'model',
		'idmodel',
		'usuario',
		'estado_anterior',
		'estado_nuevo',
		/*
		'observacion',
		'fecha',
		*/
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
