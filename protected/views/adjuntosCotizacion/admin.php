<?php
$this->breadcrumbs=array(
	'Adjuntos Cotizacion'=>array('admin'),
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
	$.fn.yiiGridView.update('adjuntos-cotizacion-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'adjuntos-cotizacion-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'cotizacion',
		'path',
		'tipi',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
