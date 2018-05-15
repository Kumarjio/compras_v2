<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'proveedor-orden-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_proveedor',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_orden_compra',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cantidad',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_unitario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_compra',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
