<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'orden-proveedor-form',
	'enableAjaxValidation'=>false,
)); ?>

	
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id_orden',array('class'=>'span5', 'value' => isset($_GET['orden'])?$_GET['orden']:$model->id_orden)); ?>

	<?php echo $form->textFieldRow($model,'nit',array('class'=>'span5', 'onblur' => 
			CHtml::ajax(array(
				'url' => $this->createUrl("proveedor/nombre"),
				'data' => array('nit' => 'js:this.value'),
				'method' => 'post',
				'success' => 'function(data){
					if(data != "not_found")
						$("#OrdenProveedor_proveedor").val(data);
				}',
			))

	)); ?>

	<?php echo $form->textFieldRow($model,'proveedor',array('class'=>'span5', 'readonly' => true)); ?>

	<?php echo $form->textFieldRow($model,'cantidad',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_unitario',array('class'=>'span5', 'onblur' => '$("#OrdenProveedor_total_compra").val(this.value * $("#OrdenProveedor_cantidad").val())')); ?>

	<?php echo $form->textFieldRow($model,'total_compra',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'observaciones',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
