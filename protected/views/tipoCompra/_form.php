<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'negociador',
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong> Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'id_empleado',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5', 
					'prompt' => 'Seleccione...',
				), 
				'data'=> TipoCompra::getCreacionResponsables()
			)
		)); ?>
	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
            'context'=>'primary',
			'label'=> 'Crear' ,
		)); ?>
	</div>

	

<?php $this->endWidget(); ?>

</div><!-- form -->