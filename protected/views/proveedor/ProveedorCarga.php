<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor")),
        array( 'label'=>'Anteriores y finalizados', 'url'=>Yii::app()->createUrl("documentoProveedor/finalizados")),
		array( 'label'=>'Todos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta")),
		array( 'label'=>"Seleccionar Proveedor", 'url'=>Yii::app()->createUrl("Proveedor/carga"), 'active'=>true ),
    ); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('proveedor-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'proveedor-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		array(
		      'name' => 'nit',
		      'type' => 'raw',
		      'value' => 'CHtml::link($data->nit, Yii::app()->createUrl("documentoProveedor/view", array("id_proveedor" => base64_encode($data->nit))))'
		      ),
		'razon_social',
		/* array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{image}',
			'header' => 'Documentos',
			'htmlOptions' => array('width' => '56px'),
			'buttons' => array(
				'image' => array(
					'url' => 'Yii::app()->createUrl("documentoProveedor/view", array("id_proveedor" => base64_encode($data->nit)))',
					'icon' => 'icon-arrow-up',
					'label' => 'Documentos'
				)
			)
		), */
	),
)); ?>
