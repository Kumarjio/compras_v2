
	<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
		'id'=>'email-form',
		'enableAjaxValidation'=>false,
			'htmlOptions' => array('onSubmit' => 'return false')
	)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textFieldRow($model,'email'); ?>

	<?php $this->endWidget(); ?>


