<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'controllador_accion',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'creacion',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'actualizacion',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
