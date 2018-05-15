<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-actividad_tiempo',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('controlFlujo/tiempoActividad').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal_tiempo\').modal(\'hide\');}else{$(\'#body_tiempo\').html(data.content);}},\'cache\':false});return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model,'id'); ?>
<?php echo $form->hiddenField($model,'id_actividad'); ?>
<?php echo $form->hiddenField($model,'id_tipologia'); ?>
<?php echo $form->hiddenField($model,'activo'); ?>
<div class='col-md-7'>
	<strong>Actividad <?php echo Actividades::model()->getActividad($model->id_actividad); ?> :</strong>
</div>
<div class='col-md-3'>
  <?php echo $form->labelEx($model,'tiempo'); ?>
</div>
<div class='col-md-2'>
    <?php echo $form->textField($model,'tiempo',array('class'=>'form-control','maxlength'=>'2')); ?>
</div>
<div class="row">
</div>
<div class='col-md-1'>
  <div class="form-actions"> 
  <?php $this->widget('bootstrap.widgets.BootButton', array( 
    'buttonType'=>'submit', 
    'type'=>'warning',
    'label'=>'Guardar', 
  )); ?>
  </div>
</div>
<script type="text/javascript">
	$( document ).ready(function() {
		$('#ActividadTipologia_tiempo').keyup(function (){
        	this.value = (this.value + '').replace(/[^0-9]/g, '');
    	});
	});
</script>
<?php $this->endWidget(); ?>