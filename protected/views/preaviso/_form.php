<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'preaviso-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'anios',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'meses',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'dias',array('class'=>'span5')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
