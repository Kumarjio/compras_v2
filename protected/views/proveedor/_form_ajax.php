<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'proveedor-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('onSubmit' => 'return false')
)); ?>

	<p class="help-block"><strong>Recuerde!</strong> 
        Los campos marcados con <span class="required">*</span>  son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup(
		$model,
		'nit',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5',
					'maxlength' => 10, 
					'disabled' => (!$model->isNewRecord)
				)
			)
		)
	); ?>

	<?php echo $form->textFieldGroup($model,'razon_social',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>


	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
