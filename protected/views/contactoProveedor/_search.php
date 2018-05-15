<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'telefono',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'celular',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'ciudad',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'departamento',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'direccion',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
