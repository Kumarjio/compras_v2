<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<style type="text/css">
	input[type="checkbox"]{
	  width: 30px;
	  height: 30px;
	}
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-update-tipologiaJ',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('controlFlujo/updateTipologia').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#dialogo-tipologiaJ\').modal(\'hide\'); $(\'#tipologiaJ-grid\').yiiGridView.update(\'tipologiaJ-grid\');}else{$(\'#body-tipologiaJ\').html(data.content);}},\'cache\':false});return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model) ?>
<div class='col-md-6 oculto'>
	<?php echo $form->labelEx($model,'id'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'id',array('class'=>'form-control','maxlength'=>'50','onKeypress'=>'return soloLetras(event)')); ?>
  	</div>
</div>
<div class='col-md-6'>
	<?php echo $form->labelEx($model,'tipologia'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'tipologia',array('class'=>'form-control inicial','maxlength'=>'50','onKeypress'=>'return soloLetras(event)')); ?>
  	</div>
</div>
 <div class='col-md-5'>
	<?php echo $form->labelEx($model,'area'); ?>
	<div class="form-group">
   		    <?php echo $form->dropDownList($model,'area', Areas::cargaAreas(),array('class'=>'form-control','prompt'=>'...')); ?>
  	</div>
</div>
 <div class='col-md-1' align="center">
	<?php echo $form->labelEx($model,'tutela'); ?>
	<div class="form-group">
		<?php echo $form->checkBox($model,'tutela'); ?>
  	</div>
</div>
<div class="row">
</div>
<div class='col-md-1'>
<div class="form-actions"> 
<?php $this->widget('bootstrap.widgets.BootButton', array( 
	'buttonType'=>'submit', 
	'type'=>'warning', 
	'label'=>$model->isNewRecord ? 'Guardar': 'Actualizar', 
)); ?>
</div>
<?php $this->endWidget(); ?>