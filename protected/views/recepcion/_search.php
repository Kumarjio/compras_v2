<?php
/* @var $this RecepcionController */
/* @var $model Recepcion */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'na'); ?>
		<?php echo $form->textField($model,'na'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'documento'); ?>
		<?php echo $form->textField($model,'documento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipologia'); ?>
		<?php echo $form->textField($model,'tipologia'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ciudad'); ?>
		<?php echo $form->textField($model,'ciudad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_documento'); ?>
		<?php echo $form->textField($model,'tipo_documento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_recepcion'); ?>
		<?php echo $form->textField($model,'user_recepcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_recepcion'); ?>
		<?php echo $form->textField($model,'fecha_recepcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_entrega'); ?>
		<?php echo $form->textField($model,'fecha_entrega'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora_entrega'); ?>
		<?php echo $form->textField($model,'hora_entrega'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'punteo_cor'); ?>
		<?php echo $form->textField($model,'punteo_cor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'impreso'); ?>
		<?php echo $form->textField($model,'impreso'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->