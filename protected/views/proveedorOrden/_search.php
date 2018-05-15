<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_proveedor',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_orden_compra',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cantidad',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_unitario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_compra',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
