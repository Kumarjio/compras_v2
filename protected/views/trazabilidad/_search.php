<?php
/* @var $this TrazabilidadController */
/* @var $model Trazabilidad */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'na'); ?>
		<?php echo $form->textField($model,'na'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_asign'); ?>
		<?php echo $form->textField($model,'user_asign'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_asign'); ?>
		<?php echo $form->textField($model,'fecha_asign'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'actividad'); ?>
		<?php echo $form->textField($model,'actividad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_cierre'); ?>
		<?php echo $form->textField($model,'user_cierre'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_cierre'); ?>
		<?php echo $form->textField($model,'fecha_cierre'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->