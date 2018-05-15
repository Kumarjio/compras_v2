<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
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
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombres'); ?>
		<?php echo $form->textField($model,'nombres'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apellidos'); ?>
		<?php echo $form->textField($model,'apellidos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'correo'); ?>
		<?php echo $form->textField($model,'correo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'activo'); ?>
		<?php echo $form->checkBox($model,'activo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bloqueado'); ?>
		<?php echo $form->checkBox($model,'bloqueado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_creacion'); ?>
		<?php echo $form->textField($model,'fecha_creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_creacion'); ?>
		<?php echo $form->textField($model,'usuario_creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contraseña'); ?>
		<?php echo $form->textField($model,'contraseña'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cargo'); ?>
		<?php echo $form->textField($model,'cargo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'area'); ?>
		<?php echo $form->textField($model,'area'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->