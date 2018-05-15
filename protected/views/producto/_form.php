<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>
	<?php
	if($model->id_familia != ''){
		$model->id_categoria = $model->familia->id_categoria;
		$familia = CHtml::listData(FamiliaProducto::model()->findAll('id_categoria = :id_uno',array(':id_uno'=>$model->id_categoria)), 'id', 'nombre');
	}
	else {
		$familia = array();
	}
	?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->dropDownListGroup(
		$model,
		'id_categoria',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5', 
					'prompt' => 'Seleccione...',
					'ajax'=>array(
                        'type'=>'POST',
                        'url'=>CController::createUrl('FamiliaProducto/selectFamilia'),
                        'update'=>'#'.CHtml::activeId($model,'id_familia'),
                    ),
				), 
				'data'=>CHtml::listData(Categorias::model()->findAll(), 'id', 'nombre')
			)
		)); ?>
	
	<?php echo $form->dropDownListGroup($model,'id_familia',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'prompt' => 'Seleccione Categoria...'), 'data'=>$familia))); ?>

	<?php echo $form->textFieldGroup($model,'nombre', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255, 'onblur' => 'this.value = this.value.toUpperCase();' )))); ?>
	
	<?php echo $form->hiddenField($model,'orden'); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
        )); ?>
	</div>

<?php $this->endWidget(); ?>
