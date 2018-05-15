<?php
$volver= ($fn)? 'crearContratoConsulta':(($tipo_documento_p==1 or $tipo_documento_p==2 ) ? 'crearContrato' : 'CrearTemporal');
$this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
        array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
        array( 'label'=>'Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/view",array("id_proveedor"=>base64_encode($model[proveedor]))), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>"Principal", 'url'=>Yii::app()->createUrl("documentoProveedor/".$volver,array("id_docpro"=>base64_encode($model[id_doc_pro_padre]), 'fn'=>$fn))),
		array( 'label'=>"Agregar documentos", 'url'=>'#', "active"=>true),
    ); 
 
	?>
<div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
<?php
 $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'documento-proveedor-form',
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
	<?php echo $form->errorSummary($model); 
 echo $form->labelEx($model,'tipo_documento'); ?>
	<?php echo $form->dropDownList($model,
		'tipo_documento',
		CHtml::listData(TipoDocumentos::model()->findAll(array("order"=>"tipo_documento", "condition"=>"$model_padre->tipo_documento = any(doc_padre::int[]) ")),"id_tipo_documento","tipo_documento"),
  array('prompt' => 'Seleccione...','class'=>'span5'));

	echo $form->labelEx($model,'path_archivo'); 
		 echo $form->fileField($model,'path_archivo'); 
		?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Crear Documento',
		)); 
		if($cerrar){
			echo "&nbsp;";
			if(!in_array(DocumentoProveedor::traeEstadoContrato($model[id_doc_pro_padre]), array('2','4','7'))){
				$this->widget('bootstrap.widgets.BootButton', array(
					'buttonType'=>'url',
					'url'=>Yii::app()->createUrl("documentoProveedor/enviarJuridico",array('id_docpro'=>base64_encode($model[id_doc_pro_padre]))),
					'type'=>'primary',
					'label'=>'Enviar a Juridico',
				));
			}
		} ?>
	</div>
<?php $this->endWidget(); ?>