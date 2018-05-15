<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'producto_orden',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nit',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cantidad',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_unitario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'total_compra',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'descripcion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'elegido_compras',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'elegido_usuario',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
