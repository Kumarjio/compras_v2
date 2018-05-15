<?php
$this->breadcrumbs=array(
	'Cancelar solicitud',
);

$this->menu=array(
		  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
	);

?>


<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'orden-form',
	'enableAjaxValidation'=>false,
	)); 
?>

<?php echo $form->errorSummary($model); ?>


<div class="alert alert-block alert-warning fade in">
	<?php echo $form->textAreaRow($model,'observacion', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
</div>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.BootButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Cancelar'
		)); 
	?>
</div>

<?php $this->endWidget() ?>