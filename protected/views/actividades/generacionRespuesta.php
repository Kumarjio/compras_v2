<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = true;
}?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array( 
	'id'=>'form-generacionRespuesta',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('actividades/index').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestion\').modal(\'hide\'); parent.window.location.reload();}else{	$(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;',
		'enctype' => 'multipart/form-data',
	),
));?>
<?php /*$form=$this->beginWidget('booster.widgets.TbActiveForm',array( 
  'id'=>'form-generacionRespuesta',
  'enableAjaxValidation'=>false,
  'htmlOptions' => array(
    'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('actividades/index').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestion\').modal(\'hide\'); $(\'#trazabilidad-grid\').yiiGridView.update(\'trazabilidad-grid\');}else{  $(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;',
    'enctype' => 'multipart/form-data',
  ),
));*/?>
<style type="text/css">
	#rows{
  	border-width:0;
  	text-align: center;
  	width:15px;
  }
  .loader {
    border: 10px solid #f3f3f3;
    border-radius: 50%;
    border-top: 10px solid #04B486;
    width: 40px;
    height: 40px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 1s linear infinite;
  }
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
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
  	<?php echo CHtml::textField('tipologia', $tipologia); ?>
  </div>
</div>
<div class='col-md-12 oculto'>
  <div class="form-group">
    <?php echo $form->textField($model,'na',array('class'=>'form-control')); ?>
  </div>
</div>
<div class='col-md-12 oculto'>
  <div class="form-group">
    <?php echo $form->textField($model,'trazabilidad',array('class'=>'form-control')); ?>
  </div>
</div>
<div class='col-md-12 oculto'>
  <div class="form-group">
    <?php echo $form->textField($model,'nombre_destinatario',array('class'=>'form-control','readonly'=>true)); ?>
  </div>
</div>
<div class='col-md-12 oculto'>
      <div class="form-group">
        <?php echo $form->textArea($model,'area_carta',array('class'=>'form-control')); ?>
      </div>
</div>
<div class='col-md-12'>
   	<?php echo $form->labelEx($model,'plantilla'); ?>
    <div class="form-group">
      <?php echo $form->dropDownList($model,'plantilla', PlantillasCartas::cargaPlantillas($tipologia),array('class'=>'form-control', 
	  'prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-12 oculto' id="editor">
    <div class="form-group">
  <?php $this->widget(
    'booster.widgets.TbCKEditor',
    array(
    	'model' => $model,
    	'attribute'=>'carta',
        'editorOptions' => array(
            'plugins' => 'basicstyles,toolbar,enterkey,entities,floatingspace,wysiwygarea,indentlist,link,list,dialog,dialogui,button,indent,fakeobjects'
        ),
    )
);?>
    </div>
</div>
<div class='col-md-6 oculto' id="proveedor">
   	<?php echo $form->labelEx($model,'proveedor'); ?>
    <div class="form-group">
    	<?php echo $form->dropDownList($model,'proveedor', Proveedores::model()->cargaProveedores(),array('class'=>'form-control', 
	    'prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-6 oculto' id="tipo_entrega">
   	<?php echo $form->labelEx($model,'entrega'); ?>
    <div class="form-group">
      <?php echo $form->dropDownList($model,'entrega', TipoEntrega::model()->cargaEntrega(),array('class'=>'form-control', 
	  'prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-6 oculto impreso'>
   	<?php echo $form->labelEx($fisico,'firma'); ?>
    <div class="form-group">
      <?php echo $form->dropDownList($fisico,'firma', Firmas::model()->cargaFirmas(),array('class'=>'form-control', 
	  'prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-6 oculto' id="mail">
   	<?php echo $form->labelEx($mail,'mail'); ?>
    <div class="form-group">
      <?php echo $form->textField($mail,'mail',array('class'=>'form-control')); ?>
    </div>
</div>
<div class='col-md-6 oculto impreso'>
   	<?php echo $form->labelEx($fisico,'ciudad'); ?>
    <div class="form-group">
      <?php echo $form->dropDownList($fisico,'ciudad', Ciudades::model()->cargaCiudades(),array('class'=>'form-control', 
	  'prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-6 oculto impreso'>
   	<?php echo $form->labelEx($fisico,'direccion'); ?>
    <div class="form-group">
      <?php echo $form->textField($fisico,'direccion',array('class'=>'form-control inicial')); ?>
    </div>
</div>
<div class='col-md-6 oculto impreso'>
   	<?php echo $form->labelEx($telefono,'telefono'); ?>
    <div class="form-group">
      <?php echo $form->textField($telefono,'telefono',array('class'=>'form-control', 'onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;')); ?>
    </div>
</div>
<div class="row">
</div>
<div class='col-md-6 oculto' id="adjunto">
    <div class="form-group">
      <?php //echo $form->fileField($adjuntos,'archivo') ; ?>
      <?php //echo CHtml::activeFileField($adjuntos,'archivo'); ?>
	  <?php /*$this->widget('booster.widgets.TbFileUpload', array(
	    'model' => $adjuntos,
	    'attribute' => 'archivo', // see the attribute?
	    'multiple' => true,
	    'options' => array(
	    'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png)$/i',
		))); */?>
    </div>
</div>
<div class='col-md-6 oculto' id="copias">
	<h5 class="hand" id="copia">Copias (<?php echo CHtml::textField('rows', $rows, array('class'=>'hand')); ?>)</h5>
</div>
<div class="row">
</div>
<div class='col-md-1 oculto' id="div_gestion_carta">
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit', 
			'type'=>'success',
			'label'=>$model->isNewRecord ? 'Guardar' : 'Guardar',
      'htmlOptions' => array('id'=>'gestion_carta'), 
		)); ?>
	</div>
</div>
<div class='col-md-1 oculto' id="div_loader">
  <div class="loader"></div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
$("#copia").click(function(){
    var na = $("#Cartas_na").val();
    var carta = CKEDITOR.instances.Cartas_carta.getData();
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('na' => 'js:na','carta' => 'js:carta'),
        'url' => $this->createUrl("actividades/copias"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#modal-copias #body-copias").html(data.content);
              $("#modal-gestion").modal("hide");
              $("#modal-copias").modal("show");
            }
        }'
      )
    );?>
});
$("#cierre_copia").click(function(){
	$("#modal-gestion").modal("show");
	$("#modal-copias").modal("hide");
});
$("#Cartas_plantilla").change(function(){
	var id_carta = $('#Cartas_plantilla').val();
	var na = $("#Cartas_na").val();
    if(id_carta != ""){
    CKEDITOR.instances.Cartas_carta.setData('');
	  <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id_carta' => 'js:id_carta','na' => 'js:na'),
	      'url' => $this->createUrl("carta"),
	      'success' => 'function(res){
	        js:CKEDITOR.instances.Cartas_carta.insertHtml(res);
	      }'
	    )
	  );?>
      $("#editor").show();
      $("#proveedor").show();
      //$("#adjunto").show();
      $("#copias").show();
    }else{
      CKEDITOR.instances.Cartas_carta.setData('');
      $("#editor").hide(); 
      $("#proveedor").hide();
	  //$("#adjunto").hide();
	  $("#copias").hide();
      $("#tipo_entrega").hide();
      $("#mail").hide();
	  $(".impreso").hide();
      $("#Cartas_proveedor").val("");
      $("#Cartas_entrega").val("");
  	  $("#CartasMail_mail").val("");
	  $("#CartasFisicas_firma").val("");
	  $("#CartasFisicas_ciudad").val("");
	  $("#CartasFisicas_direccion").val("");
	  $("#TelefonosCartas_telefono").val("");
	  
    }
});
$("#Cartas_proveedor").change(function(){
	if($("#Cartas_proveedor").val() != ""){
		$("#tipo_entrega").show();
	}else{
		$("#tipo_entrega").hide();
		$("#Cartas_entrega").val("");
		$("#mail").hide();
		$(".impreso").hide();
		$("#CartasMail_mail").val("");
		$("#CartasFisicas_firma").val("");
		$("#CartasFisicas_ciudad").val("");
		$("#CartasFisicas_direccion").val("");
		$("#TelefonosCartas_telefono").val("");
	}
});
$("#Cartas_entrega").change(function(){
	var tipo_entrega = $("#Cartas_entrega").val();
	if(tipo_entrega == "1"){
    na = $("#Cartas_na").val();
      <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'data' => array('na' => 'js:na'),
          'url' => $this->createUrl("consultaEmail"),
          'success' => 'function(data){
              if(data){
                $("#CartasMail_mail").val(data);
                $("#CartasMail_mail").attr("readonly", "true");
              }
          }'
        )
    );?>
		$("#mail").show();
		$(".impreso").hide();
		$("#CartasFisicas_firma").val("");
		$("#CartasFisicas_ciudad").val("");
		$("#CartasFisicas_direccion").val("");
		$("#TelefonosCartas_telefono").val("");
	}else if(tipo_entrega == "2"){
		$(".impreso").show();
		$("#mail").hide();
		$("#CartasMail_mail").val("");
	}else{
		$(".impreso").hide();
		$("#CartasFisicas_firma").val("");
		$("#CartasFisicas_ciudad").val("");
		$("#CartasFisicas_direccion").val("");
		$("#TelefonosCartas_telefono").val("");
		$("#mail").hide();
		$("#CartasMail_mail").val("");
	}
});
$("#gestion_carta").click(function(){
  $("#div_gestion_carta").hide();
  $("#div_loader").show();
  var carta = CKEDITOR.instances.Cartas_carta.getData();
  $("#Cartas_area_carta").val(carta);
});
$( document ).ready(function() {
  $("#div_gestion_carta").show();
  if($( "#Cartas_plantilla" ).val()){
  	  $("#editor").show();
      $("#proveedor").show();
      $("#copias").show();
  }
  if($( "#Cartas_proveedor").val()){
  	$("#tipo_entrega").show();
  }
  if($( "#Cartas_entrega").val() == "1"){
  	$("#mail").show();
  }else if($( "#Cartas_entrega").val() == "2"){
	$(".impreso").show();
  }
});
</script>