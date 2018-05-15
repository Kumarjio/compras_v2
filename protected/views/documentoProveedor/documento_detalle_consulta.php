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
		'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/print", array("id_docpro" => base64_encode($data->id_docpro))))'
		),	
		array(
			'header'=>'Indicativo',
			//'type'=>'raw',
			'value' => '($data->tipo_documento == "8")? $data->id_docpro." - Póliza Nro. ".$data->id_poldoc : $data->id_docpro'
		),		
		array(
			'header'=>'Nombre Documento',
            //'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'16%'),
			'value' => '$data->getNombreDoc($data->tipopol)',
		),
		array(
			'header'=>'Fecha Vigencia',
			'value' => '$data->fecha_fin_pol'
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