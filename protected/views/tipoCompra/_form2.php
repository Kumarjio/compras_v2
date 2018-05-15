
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'tipo-compra-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>
	<?php if(!$model->isNewRecord) : ?>
	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Si modifica el responsable todas las ordenes de este tipo de compra seran reasignadas al nuevo negociador 
	</div>
	<?php endif ; ?>


	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'nombre', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'responsable',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5', 
					'prompt' => 'Seleccione...',
				), 
				'data'=> TipoCompra::getResponsables()
			)
		)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
            'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>
	</div>

	

<?php $this->endWidget(); ?>

</div><!-- form -->