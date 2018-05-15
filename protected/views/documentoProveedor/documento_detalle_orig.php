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
		'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/update", array("id_docpro" => base64_encode($data->id_docpro))))'
		),		

		array(
			'name'=> 'fecha_insert',
			'type'=> 'text',
			'value'=> '(strlen($data->fecha_insert)>0) ? date("Y-m-d",strtotime($data->fecha_insert) ) : ""'
		),
		array(
			'name'=> 'user_insert'
		),
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{delete}',
			'header' => 'Operaciones',
			'htmlOptions' => array('width' => '56px'),
			'buttons' => array(
				'delete' => array(
					'url' => 'Yii::app()->createUrl("documentoProveedor/eliminarDocumento", array("id_d" => base64_encode($data->id_docpro)))',
					'label' => 'Eliminar Documentos',
					'visible'=> '('.$model->estado.'==0 or '.$model->estado.'==3)'
				),
				/* 'update' => array(
					'url' => 'Yii::app()->createUrl("documentoProveedor/crearContrato", array("id_docpro" => $data->id_docpro))',
					'label' => 'Editar Contrato',
					'visible'=> '$data->terminado==0'
				) */
			)
		) 
	),
) ); 
?>