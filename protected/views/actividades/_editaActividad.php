<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'form-editar-actividad',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('actividades/editar').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#edita_actividad\').modal(\'hide\'); $(\'#rol-grid\').yiiGridView.update(\'actividades_grid\');}else{$(\'#body_edicion\').html(data.content);}},\'cache\':false});return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model)  ?> 
<div class='col-md-12'>
	<?php echo $form->labelEx($model,'actividad'); ?>
    <div class="form-group">
      	<?php echo $form->textField($model,'actividad', array('class'=>'form-control')); ?>
    </div>
</div>
<?php echo $form->hiddenField($model, 'id')?>
<div class='col-md-1'>
	<div class="form-actions"> 
	<?php $this->widget('bootstrap.widgets.BootButton', array( 
		'buttonType'=>'submit', 
		'type'=>'danger', 
		'label'=>$model->isNewRecord ? 'Guardar' : 'Guardar', 
	)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>