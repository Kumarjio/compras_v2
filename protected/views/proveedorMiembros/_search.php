<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nit',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tipo_documento',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'documento_identidad',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'nombre_completo',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'participacion',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
