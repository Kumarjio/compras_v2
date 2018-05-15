<?php
$this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'documento-proveedor-grid', 
	'dataProvider'=>$model_detalle->search_detalle($model->id_docpro),
	'type'=>'striped bordered condensed',
	'filter'=>$model_detalle,
	'columns'=>array(
		array(
		'header'=>'Tipo Documento',
		'type'=>'raw',
		'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/updateJuridico", array("id_docpro" => base64_encode($data->id_docpro))))'
		),		

		array(
			'name'=> 'fecha_insert',
			'type'=> 'text',
			'value'=> '(strlen($data->fecha_insert)>0) ? date("Y-m-d",strtotime($data->fecha_insert) ) : ""'
		),
		array(
			'name'=> 'user_insert'
		),
		
	),
) ); 
?>