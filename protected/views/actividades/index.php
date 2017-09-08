<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-gestion-default',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\'/correspondencia/index.php/actividades/index\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestion\').modal(\'hide\'); parent.window.location.reload();}else{	$(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;'
	)
));?>
<?php /*$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-gestion-default',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\'/correspondencia/index.php/actividades/index\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestion\').modal(\'hide\'); $(\'#trazabilidad-grid\').yiiGridView.update(\'trazabilidad-grid\');parent.window.location.reload();}else{	$(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;'
	)
));*/?>
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
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit', 
			'type'=>'success', 
			'label'=>$model->isNewRecord ? 'Guardar' : 'Guardar', 
		)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
