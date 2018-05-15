<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'contratos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_cargo',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'salario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_empleado',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_empleador',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_inicio',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_fin',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_motivo_ingreso',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_motivo_retiro',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
