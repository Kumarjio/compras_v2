<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'elegir-compras-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('onSubmit' => 'return false')
)); ?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textAreaGroup($model,'razon_eleccion_usuario',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>50, 'class'=>'span8')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType'=>'submit',
		'context'=>'primary',
		'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
	)); ?>
</div>

<?php $this->endWidget(); ?>