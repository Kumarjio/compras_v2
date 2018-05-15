<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_cargo',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'salario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_empleado',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_empleador',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_inicio',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_fin',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_motivo_ingreso',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_motivo_retiro',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'creacion',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'actualizacion',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
