<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php /*$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-gestion-default',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('actividades/index').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestion\').modal(\'hide\'); parent.window.location.reload();}else{	$(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;'
	)
));*/?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-gestion-default',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('actividades/index').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestiontraza\').modal(\'hide\'); $(\'#trazabilidad-grid\').yiiGridView.update(\'trazabilidad-grid\');}else{	$(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;'
	)
));?>
<style type="text/css">
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
<div class='col-md-12 oculto'>
	<?php echo $form->textField($model,'na',array('class'=>'form-control')); ?>
</div>
<div class='col-md-12 oculto'>
	<?php echo $form->textField($model,'id_trazabilidad',array('class'=>'form-control')); ?>
</div>
<div class='col-md-12'>
	<strong>Observaciones:</strong>
    <div class="form-group">
      <?php echo $form->textArea($model,'observacion',array('class'=>'form-control')); ?>
    </div>
</div>
<div class='col-md-1' id="div_gestion_observacion">
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit', 
			'type'=>'success', 
			'label'=>'Guardar',
			'htmlOptions' => array('id'=>'gestion_observacion'), 
		)); ?>
	</div>
</div>
<div class='col-md-1 oculto' id="div_loader_observacion">
  <div class="loader"></div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
	$("#div_gestion_observacion").show();
});
$("#gestion_observacion").click(function(){
  $("#div_gestion_observacion").hide();
  $("#div_loader_observacion").show();
});
</script>
<?php $this->endWidget(); ?>
