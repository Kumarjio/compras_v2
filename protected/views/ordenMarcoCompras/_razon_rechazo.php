<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'razon_rechazo',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('onSubmit' => 'return false')
)); ?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textAreaGroup($model,'razon_rechazo',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>50, 'class'=>'span8')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType'=>'submit',
		'context'=>'danger',
		'label'=>$model->isNewRecord ? 'Rechazar' : 'Actualizar',
	)); ?>
</div>

<?php $this->endWidget(); ?>