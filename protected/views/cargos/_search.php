<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_jefatura',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'recibe_dotacion',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'es_jefe',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'es_gerente',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'activo',array('class'=>'span5','maxlength'=>255)); ?>


	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
