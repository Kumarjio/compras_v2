<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'observaciones-wfs-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'model',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'idmodel',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'usuario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'estado_anterior',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'estado_nuevo',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'observacion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'fecha',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
