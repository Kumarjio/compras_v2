<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'adjuntos-cotizacion-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'cotizacion',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'path',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'tipi',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
