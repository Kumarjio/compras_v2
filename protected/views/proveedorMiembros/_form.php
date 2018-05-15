<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'proveedor-miembros-form',
	'enableAjaxValidation'=>false,
)); ?>

	
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'nit', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255, 'readonly'=>true, 'value' => ($model->nit != null)?$model->nit:$_GET['nit'])))); ?>

	<?php echo $form->dropDownListGroup($model,'tipo_documento',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'prompt' => 'Seleccione...'), 'data'=>CHtml::listData(ProveedorMiembros::model()->getTipoDoc(),"id", "valor")))); ?>

	<?php echo $form->textFieldGroup($model,'documento_identidad', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->textFieldGroup($model,'nombre_completo', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->dropDownListGroup($model,'participacion',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'prompt' => 'Seleccione...'), 'data'=>CHtml::listData(ProveedorMiembros::model()->getParticipacion(),"id", "valor")))); ?>
									
	<?php echo $form->textFieldGroup($model,'porcentaje_participacion', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
        )); ?>
	</div>

<?php $this->endWidget(); ?>
