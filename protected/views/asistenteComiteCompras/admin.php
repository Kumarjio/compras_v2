<?php
$this->breadcrumbs=array(
	'Asistente Comite Compras'
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
	$.fn.yiiGridView.update('asistente-comite-compras-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'asistente-comite-compras-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		array('name'=>'empleado.nombre', 'value'=>'$data->empleado->nombre_completo', 'header'=>'Nombre'),
		array('name'=>'empleado.genero', 'value'=>'$data->empleado->genero', 'header'=>'Genero'),
		array('name'=>'empleado.tipo_documento', 'value'=>'$data->empleado->tipo_documento', 'header'=>'Tipo Documento'),
		array('name'=>'empleado.numero_identificacion', 'value'=>'$data->empleado->numero_identificacion', 'header'=>'Numero de Identificacion'),
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{delete}'
		),
	),
)); ?>
