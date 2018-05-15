<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'create_actividad',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('actividades/create').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#crea_actividad\').modal(\'hide\'); $(\'#rol-grid\').yiiGridView.update(\'actividades_grid\');}else{$(\'#body_creacion\').html(data.content);}},\'cache\':false});return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model)  ?>
<div class='col-md-12'>
	<?php echo $form->labelEx($model,'actividad'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'actividad',array('class'=>'form-control','maxlength'=>'50','onKeypress'=>'return soloLetras(event)')); ?>
  	</div>
</div>
<div class='col-md-1'>
	<div class="form-actions"> 
	<?php $this->widget('bootstrap.widgets.BootButton', array( 
		'buttonType'=>'submit', 
		'type'=>'danger', 
		'label'=>'Guardar',
		'htmlOptions' => array('id'=>'guarda_actividad'), 
	)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	function soloLetras(e) { // 1
	  tecla = (document.all) ? e.keyCode : e.which; // 2
	  if (tecla==8) return true; // 3
	  patron =/[A-Za-z-ñ\s]/; // 4
	  te = String.fromCharCode(tecla); // 5
	  return patron.test(te); // 6
	}
</script>