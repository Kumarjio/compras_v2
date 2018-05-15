<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'proveedor-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'nit', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10, 'disabled' => (!$model->isNewRecord))))); ?>

	<?php echo $form->textFieldGroup($model,'razon_social', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
        )); ?>
	</div>

<?php $this->endWidget(); ?>
