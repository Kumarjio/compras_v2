<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tipo-compra-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>
	<h1>Nuevo Tipo Compra </h1> 

	<?php if($model->hasErrors()){ ?>
	<div class="alert alert-danger">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php } ?>

	<div class="orden_row_view">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('class'=>'span5','maxlength'=>255)); ?> 
	</div>

	<div class="orden_row_view">
		<?php echo $form->labelEx($model,'responsable'); ?>
		<?php echo $form->dropDownList($model,'responsable', TipoCompra::getResponsables(),array('class'=>'span5', 'prompt'=>'...')) ?>
		<!--<?php echo $form->textField($model,'responsable'); ?>-->
		<?php echo $form->error($model,'responsable'); ?>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>
	</div>

	
<?php $this->endWidget(); ?>

</div>