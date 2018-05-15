<?php $this->menu_izquierdo =array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor")),
        array( 'label'=>'Anteriores y finalizados', 'url'=>Yii::app()->createUrl("documentoProveedor/finalizados")),
		array( 'label'=>'Todos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta")),
		array( 'label'=>'Crear Contrato', 'url'=>Yii::app()->createUrl("Proveedor/carga") ),
		array( 'label'=>DocumentoProveedor::model()->traerNombreProveedor($proveedor), 'url'=> Yii::app()->createUrl("documentoProveedor/view",array('id_proveedor'=>base64_encode($proveedor) ) ),'active'=>true )
    ); ?>
<?php $this->widget( 'bootstrap.widgets.BootButton',array(
	'buttonType'=>'submit', 
            'type'=>'primary', 
            'icon'=>'arrow-up white',
            'label'=>'Crear Contrato',
			'htmlOptions'=>array('submit'=>Yii::app()->createUrl("documentoProveedor/adjunto", array("proveedor" => base64_encode($proveedor),"tipo_documento"=>1)))
	)
); ?>
<?php $this->widget( 'bootstrap.widgets.BootButton',array(
		'buttonType'=>'submit', 
        'type'=>'default', 
        'icon'=>'arrow-up',
           'label'=>'Documento Temporal',
			'htmlOptions'=>array('submit'=>Yii::app()->createUrl("documentoProveedor/crearTemporal", array("proveedor" => base64_encode($proveedor))))
	) 
); ?>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'documento-proveedor-grid',
	'dataProvider'=>$model->search_contratos($proveedor),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		array(
		'header'=>'Tipo Documento',
		'type'=>'raw',
		'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/print", array("id_docpro" => base64_encode($data->id_docpro))))'
		),		

		'objeto',
		array(
			'name'=> 'fecha_inicio',
			'type'=> 'text',
			'value'=> '(strlen($data->fecha_inicio)>0) ? date("Y-m-d",strtotime($data->fecha_inicio) ) : ""'
		),
		array(
			'name'=> 'fecha_fin',
			'type'=> 'text',
			'value'=> '(strlen($data->fecha_fin)>0) ? date("Y-m-d",strtotime($data->fecha_fin) ) : ""'
		),
		array(
			'header'=>'No. Documentos',
			'value'=>'DocumentoProveedor::numDocs($data->id_docpro)'
		),
		array(
		'name'=>'estado',
		'value'=>'$data->estado_rel->estado'
		),
		/* array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{delete}',
			'header' => 'Operaciones',
			'htmlOptions' => array('width' => '56px'),
			'buttons' => array(
				'delete' => array(
					'url' => 'Yii::app()->createUrl("documentoProveedor/eliminarDocumento", array("id_d" => base64_encode($data->id_docpro)))',
					'label' => 'Eliminar Documentos',
					'visible'=> '$data->estado==0'
				),
				 'update' => array(
					'url' => 'Yii::app()->createUrl("documentoProveedor/crearContrato", array("id_docpro" => $data->id_docpro))',
					'label' => 'Editar Contrato',
					'visible'=> '$data->terminado==0'
				) 
			)
		) */
	),
) ); ?>