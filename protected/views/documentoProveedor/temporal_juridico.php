<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico")),
		array( 'label'=>"Documento Temporal", 'url'=>'#', "active"=>true),
		array( 'label'=>"Trazabilidad", 'itemOptions'=>array('id'=>'trazabilidad','data-toggle'=>'modal',
        'data-target'=>'#myModal')),
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
  echo $form->errorSummary($model_estado); 
	echo $form->textAreaRow($model,'objeto',array('class'=>'span5')); ?>
	
	<label>Gerencia <span class="required">*</span></label>
			<?php echo $form->dropDownList($model,
					 'id_gerencia',
					 CHtml::listData(Gerencias::model()->findAll(),"id","nombre"),
					 array('prompt' => 'Seleccione...',
						'class'=>'span5',
						'data-sync'=>'true',
						'onChange' => CHtml::ajax(array(
						'type' => 'post',
						'dataType' => 'json',
						'data' => array('gerencia' => 'js:this.value','model'=>'DocumentoProveedor'),
						'url' => $this->createUrl("gerencias/jefaturasDoc"),
						'success' => 'function(data){
							if(data.status == "ok"){
								$("#DocumentoProveedor_id_jefatura").replaceWith(data.combo);
								$("#DocumentoProveedor_id_gerente").val(data.gerente.id);	
								 $("#DocumentoProveedor_responsable_proveedor").val("");
							}else{
								alert(data.mensaje);
								$("#DocumentoProveedor_id_gerente").val("");	
								
													$("#DocumentoProveedor_responsable_proveedor").val("");

							}
								
						}')))); ?>
		  
		  <?php if($model->id_gerencia != ""): ?>
							<label >Jefatura  <span class="required">*</span></label>
				<?php echo $form->dropDownList($model,
						 'id_jefatura',
						 CHtml::listData(
				 Jefaturas::model()->findAllByAttributes(array('id_gerencia' => $model->id_gerencia)),
				 "id",
				 "nombre"
				 ),
						 array('prompt' => 'Seleccione...',
							   'class' => 'span5',
			   'data-sync'=>'true',
			   'id' => 'DocumentoProveedor_id_jefatura',
			   'onChange' => CHtml::ajax(array(
				   'type' => 'post',
					'dataType' => 'json',
					'data' => array('jefatura' => 'js:this.value'),
					'url' => $this->createUrl("jefaturas/nombrejefe"),
					'success' => 'function(data){
						if(data.status == "ok"){
							
							$("#DocumentoProveedor_responsable_proveedor").val(data.jefe.nombre);
							
						}else{
							alert(data.mensaje);
							$("#DocumentoProveedor_id_jefatura").val("");	
							$("#DocumentoProveedor_responsable_proveedor").val("");
						}	                                       				
					}'
						  )
												)
											)); ?>
		  <?php else: ?>
				<?php echo $form->dropDownListRow($model,
												 'id_jefatura',
												 array(),
	  array('prompt' => 'Seleccione una gerencia...','class'=>'span5','data-sync'=>'true')); ?>
			
			<?php endif ?>
	
	<?php echo $form->textFieldRow($model,'responsable_proveedor',array('class'=>'span5','readonly'=>'readonly')); ?>
	<?php echo $form->labelEx($model,'responsable_compras'); ?>
		
		<?php echo $form->dropDownList($model,
			'responsable_compras',
			DocumentoResponsableCompras::model()->GetListaResponsableCompras(),
	  array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true')); ?>
	
	<?php echo $form->labelEx($model,'id_orden'); ?>
		 <?php echo $form->dropDownList($model,
					 'id_orden',
					 DocumentoProveedor::model()->getOrdenesCompra($model->proveedor),
					 array('prompt' => 'Seleccione...',
						   'class'=>'span5')); ?>
						   
		<br>	
	
	<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Guardar Datos' : 'Guardar Datos',
			)); ?>

<?php $this->widget( 'bootstrap.widgets.BootButton',array(
	'buttonType'=>'submit', 
            'type'=>'primary', 
            'icon'=>'arrow-up white',
            'label'=>'Crear Contrato',
            'htmlOptions'=>array('submit'=>Yii::app()->createUrl("documentoProveedor/adjunto", array("proveedor" => base64_encode($model[proveedor]),"tipo_documento"=>1,"id" => base64_encode($model[id_docpro]),'jur'=>true)))
	)
); ?>
		</div>

<?php $this->endWidget(); ?>

	<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
		'id'=>'documento-proveedor-form',
		'enableAjaxValidation'=>false,
	)); ?> 
	
	<?php echo $form->textAreaRow($model_estado,'observacion',array('class'=>'span5')); ?>
	<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Aprobar' 
			)); ?>
			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Devolver' 
			)); ?>

		</div>
	<?php $this->endWidget(); ?>


	</div>
</div>
<?php 
if($model->id_docpro>0){
	$this->renderPartial('documento_detalle_juridico',array('model_detalle'=>$model_detalle,'model'=>$model));
}
	$this->renderPartial('_trazabilidad',array('model_traza'=>$model_traza,'model'=>$model));

	?>
<br>