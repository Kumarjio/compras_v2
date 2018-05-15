
	<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
		'id'=>'documento-proveedor-form',
		'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>

	<?php echo $form->textFieldRow($model,'email'); ?>

	<?php $this->endWidget(); ?>