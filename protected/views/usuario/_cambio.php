<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-cambio-contrasena',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onSubmit' => 'jQuery.ajax({
			"url":"'.$this->createUrl("cambiarPass").'",
			"dataType":"json",
			"data":$(this).serialize(),
			"type":"post",
			"success":function(res){
      			$("#dialogo-cambio-contrasena #body-cambio-contrasena").html(res.content);
			},
			"cache":false
		});
		return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model)  ?> 
	<div class="form-group">
		<?php echo $form->labelEx($model,'valida_contrasena'); ?>
   		<?php echo $form->passwordField($model,'valida_contrasena',array('class'=>'form-control')); ?>
  	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'contraseña'); ?>
   		<?php echo $form->passwordField($model,'contraseña',array('class'=>'form-control')); ?>
  	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'repetir'); ?>
   		<?php echo $form->passwordField($model,'repetir',array('class'=>'form-control')); ?>
  	</div>
	<div class="form-actions"> 
	<?php $this->widget('bootstrap.widgets.BootButton', array( 
		'buttonType'=>'submit', 
		'type'=>'success', 
		'htmlOptions'=>array(
			'id'=>'guardar',
		),
		'label'=>$model->isNewRecord ? 'Guardar' : 'Actualizar', 
	)); ?>
	</div>
<?php $this->endWidget(); 
?>

<script type="text/javascript">
	$("#Usuario_contraseña").val("");
	$("#Usuario_repetir").val("");
</script>