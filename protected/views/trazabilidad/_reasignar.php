<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-reasignar',
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('trazabilidad/reasignar').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestion\').modal(\'hide\'); parent.window.location.reload();}else{	$(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;',
		'enctype' => 'multipart/form-data',
	),
));
/*$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-reasignar',
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('trazabilidad/reasignar').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestion\').modal(\'hide\'); $(\'#trazabilidad-grid\').yiiGridView.update(\'trazabilidad-grid\');}else{	$(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;',
		'enctype' => 'multipart/form-data',
	),
));*/?>
<?php echo $form->errorSummary($model)  ?>
<div class='col-md-12'>
   	<?php echo $form->labelEx($model,'user_asign'); ?>
    <div class="form-group">
	  <?php echo $form->hiddenField($model,'id',array('class'=>'form-control'));?>
      <?php /*echo $form->dropDownList($model,'user_asign', Usuario::cargarUsuarios(),array('class'=>'form-control', 
	  'prompt'=>'...')); */?>
	  <?php echo $form->dropDownList($model,'user_asign', UsuariosActividadTipologia::cargaUsuariosActividad($model->actividad),array('class'=>'form-control', 
	  'prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit', 
			'type'=>'success',
			'label'=>'Guardar',
		)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>