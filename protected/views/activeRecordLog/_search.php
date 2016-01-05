<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'action',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'model',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'idmodel',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'iduser',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'field',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'description_new',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'fecha',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
