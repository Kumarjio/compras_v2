<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-cambioTipologia',
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('trazabilidad/cambiarTipologia').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-gestion\').modal(\'hide\'); parent.window.location.reload();}else{	$(\'#body-gestion\').html(data.content);}},\'cache\':false});return false;',
            'enableAjaxValidation'=>true,
	),
));
/*if($model->hasErrors()){ ?>
	<div class="alert alert-danger">
		<strong class="text-muted"><?php echo $form->error($model, 'tipologia'); ?></strong>
	</div>
<?php }*/
echo $form->errorSummary($model);
echo $form->hiddenField($trazabilidad, 'id');
echo $form->hiddenField($model, 'na'); ?>
<div class='col-md-12'>
   	<?php echo $form->labelEx($model,'tipologia'); ?>
    <div class="form-group">
	  <?php echo $form->dropDownList($model,'tipologia', CHtml::listData(Tipologias::model()->findAll(array("condition"=>"activa =  true AND operacion = true","select"=>"id, INITCAP(tipologia) AS tipologia",'order' => 'tipologia')),'id',CHtml::encode('tipologia'),true),array('class'=>'form-control', 
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