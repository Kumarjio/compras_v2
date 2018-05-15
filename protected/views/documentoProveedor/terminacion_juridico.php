<?php
$volver= ($tipo_documento_p==1 or $tipo_documento_p==2 )  ? 'crearContratoJuridico' : 'CrearTemporalJuridico';
$this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico")),
		array( 'label'=>"Principal", 'url'=>Yii::app()->createUrl("documentoProveedor/".$volver,array("id_docpro"=>base64_encode($model[id_doc_pro_padre])))),
		array( 'label'=>"Carta de Terminacion", 'url'=>'#', "active"=>true),
    ); ?>
	<div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
	
<div class='row'>
	<div class='span5'>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'documento-proveedor-form',
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
		 echo $form->errorSummary($model); 
 echo $form->textAreaRow($model,'motivo_terminacion',array('rows'=>6, 'cols'=>50, 'class'=>'span5')); ?>

	<?php echo $form->labelEx($model,'fecha_terminacion'); 
	 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'attribute'=>'fecha_terminacion',
							'language' => 'es', 
							'options'=>array(
								'showAnim'=>'fold', 
								'dateFormat' => 'yy-mm-dd',
								'changeMonth'=> true,
                    'changeYear'=> true,
								),'htmlOptions'=>array(
									'style'=>'height:20px;',
									'data-sync' => 'true',
									'class' => 'span5'
									)
							)
						); ?>

		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
		</div>

<?php $this->endWidget(); ?>
	</div>
	<div class="span7">
	<?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
	</div>
</div>
<br>