<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'familia-producto-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'id_categoria',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5', 
					'prompt' => 'Seleccione...',
				), 
				'data'=>CHtml::listData(Categorias::model()->findAll(), 'id', 'nombre')
			)
		)); ?>

	<?php echo $form->textFieldGroup($model,'nombre', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255, 'onblur' => 'this.value = this.value.toUpperCase();' )))); ?>

	<div class="form-actions">

		<?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
        )); ?>
	</div>

<?php $this->endWidget(); ?>
