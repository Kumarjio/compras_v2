<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'contacto-proveedor-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'nombre', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php echo $form->textFieldGroup($model,'apellido', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php echo $form->textFieldGroup($model,'telefono', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>30)))); ?>

	<?php echo $form->textFieldGroup($model,'celular', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'email',array(
		'append'=>$this->widget('bootstrap.widgets.BootButton', array(
				    'label'=>'No Tiene',
				    'htmlOptions'=>array('style' => 'display: initial;','id' => 'crear_proveedor', 'onClick' => '$("#ContactoProveedor_email").val("notiene@notiene.com")'),
				), true),
        'appendOptions'=>array(
            'isRaw'=>false
        ),  
		'widgetOptions'=>array(
			'htmlOptions'=>array('class'=>'span5','maxlength'=>255)))
	); ?>
	<?php  ?>
	<?php echo $form->textFieldGroup($model,'ciudad', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->textFieldGroup($model,'departamento', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->textFieldGroup($model,'direccion', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
           	'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>

	</div>

<?php $this->endWidget(); ?>
