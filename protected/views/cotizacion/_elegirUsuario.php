<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'cotizacion-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textAreaRow($model,'razon_eleccion_usuario',array('rows'=>3, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'elegir',
		)); ?>
	</div>

<?php $this->endWidget(); ?>