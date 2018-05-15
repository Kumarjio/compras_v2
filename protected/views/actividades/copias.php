<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$form=$this->beginWidget('booster.widgets.TbActiveForm',array( 
	'id'=>'form-copias',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('actividades/copias').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){var rows = parseFloat($(\'#rows\').val()) + parseFloat(1);$(\'#modal-copias\').modal(\'hide\');$(\'#modal-gestion\').modal(\'show\');$(\'#rows\').val(rows);}else{	$(\'#body-copias\').html(data.content);}},\'cache\':false});return false;'
	),
));?>
<?php if($model->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($model)  ?> 
  </div>
<?php } ?>
<?php if($fisico->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($fisico)  ?> 
  </div>
<?php } ?>
<?php if($mail->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($mail)  ?> 
  </div>
<?php } ?>
<div class='col-md-12 oculto'>
  <div class="form-group">
    <?php echo $form->textField($model,'na',array('class'=>'form-control')); ?>
  </div>
</div>
<div class='col-md-12 oculto'>
  <div class="form-group">
    <?php echo $form->textField($model,'carta',array('class'=>'form-control')); ?>
  </div>
</div>
<div class='col-md-6'>
   	<?php echo $form->labelEx($model,'nombre_destinatario'); ?>
    <div class="form-group">
    	<?php echo $form->textField($model,'nombre_destinatario',array('class'=>'form-control')); ?>
    </div>
</div>
<div class='col-md-6'>
   	<?php echo $form->labelEx($model,'proveedor'); ?>
    <div class="form-group">
    	<?php echo $form->dropDownList($model,'proveedor', Proveedores::model()->cargaProveedores(),array('class'=>'form-control',
    	'id'=>'proveedor_copia','prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-6 oculto' id="tipo_entrega_copia">
   	<?php echo $form->labelEx($model,'entrega'); ?>
    <div class="form-group">
      <?php echo $form->dropDownList($model,'entrega', TipoEntrega::model()->cargaEntrega(),array('class'=>'form-control','id'=>'entrega_copia','prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-6 oculto impreso_copia'>
   	<?php echo $form->labelEx($fisico,'firma'); ?>
    <div class="form-group">
      <?php echo $form->dropDownList($fisico,'firma', Firmas::model()->cargaFirmas(),array('class'=>'form-control','id'=>'firma_copia','prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-6 oculto' id="mail_copia">
   	<?php echo $form->labelEx($mail,'mail'); ?>
    <div class="form-group">
      <?php echo $form->textField($mail,'mail',array('class'=>'form-control','id'=>'input_mail')); ?>
    </div>
</div>
<div class='col-md-6 oculto impreso_copia'>
   	<?php echo $form->labelEx($fisico,'ciudad'); ?>
    <div class="form-group">
      <?php echo $form->dropDownList($fisico,'ciudad', Ciudades::model()->cargaCiudades(),array('class'=>'form-control','id'=>'ciudad_copia','prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-6 oculto impreso_copia'>
   	<?php echo $form->labelEx($fisico,'direccion'); ?>
    <div class="form-group">
      <?php echo $form->textField($fisico,'direccion',array('class'=>'form-control inicial','id'=>'direccion_copia')); ?>
    </div>
</div>
<div class='col-md-6 oculto impreso_copia'>
   	<?php echo $form->labelEx($telefono,'telefono'); ?>
    <div class="form-group">
      <?php echo $form->textField($telefono,'telefono',array('class'=>'form-control', 'onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;','id'=>'telefono_copia')); ?>
    </div>
</div>
<div class="row">
</div>
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit', 
			'type'=>'success', 
			'label'=>$model->isNewRecord ? 'Guardar' : 'Guardar', 
		)); ?>
	</div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
	if($("#proveedor_copia").val() != ""){
		$("#tipo_entrega_copia").show();
	}
	if($( "#entrega_copia").val() == "1"){
  		$("#mail_copia").show();
  	}else if($( "#entrega_copia").val() == "2"){
		$(".impreso_copia").show();
	}
});
$("#proveedor_copia").change(function(){
	if($("#proveedor_copia").val() != ""){
		$("#tipo_entrega_copia").show();
	}else{
		$("#tipo_entrega_copia").hide();
		$(".impreso_copia").hide();
		$("#mail_copia").hide();
		$("#entrega_copia").val("");
		$("#firma_copia").val("");
		$("#ciudad_copia").val("");
		$("#direccion_copia").val("");
		$("#telefono_copia").val("");
		$("#input_mail").val("");
	}
});
$("#entrega_copia").change(function(){
	var tipo_entrega = $("#entrega_copia").val();
	if(tipo_entrega == "1"){
		$("#mail_copia").show();
		$(".impreso_copia").hide();
		$("#firma_copia").val("");
		$("#ciudad_copia").val("");
		$("#direccion_copia").val("");
		$("#telefono_copia").val("");
	}else if(tipo_entrega == "2"){
		$(".impreso_copia").show();
		$("#mail_copia").hide();
		$("#input_mail").val("");
	}else{
		$(".impreso_copia").hide();
		$("#mail_copia").hide();
		$("#firma_copia").val("");
		$("#ciudad_copia").val("");
		$("#direccion_copia").val("");
		$("#telefono_copia").val("");
		$("#input_mail").val("");
	}
});
</script>
<?php $this->endWidget(); ?>