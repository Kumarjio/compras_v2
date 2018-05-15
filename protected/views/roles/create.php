<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-agregar-rol',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('roles/create').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#dialogo-rol\').modal(\'hide\'); $(\'#rol-grid\').yiiGridView.update(\'rol-grid\');}else{$(\'#body-rol\').html(data.content);}},\'cache\':false});return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model)  ?> 
<?php echo $form->errorSummary($permisos)  ?>
<div class='col-md-12'>
	<?php echo $form->labelEx($model,'rol'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'rol',array('class'=>'form-control inicial','maxlength'=>'50','onKeypress'=>'return soloLetras(event)')); ?>
  	</div>
</div>
<div class='col-md-12'>
	<?php echo $form->labelEx($permisos,'id_permiso'); ?>
    <div class="form-group">
      <?php $this->widget('ext.select2.ESelect2',array(
		  'model'=>$permisos,
		  'attribute'=>'id_permiso',
		  'data'=>Permisos::cargarPermisos(),
		  'htmlOptions'=>array(
		    'options'=>array('selected'=>true),
		    'multiple'=>'multiple',
		    'style'=>'width:548px',
		  ),
	  ));?>
    </div>
</div>
<div class="row">
</div>
<div class='col-md-1'>
	<div class="form-actions"> 
	<?php $this->widget('bootstrap.widgets.BootButton', array( 
		'buttonType'=>'submit', 
		'type'=>'primary', 
		'label'=>$model->isNewRecord ? 'Guardar' : 'Actualizar', 
	)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
function soloLetras(e) { // 1
	tecla = (document.all) ? e.keyCode : e.which; // 2
	if (tecla==8) return true; // 3
	patron =/[A-Za-z\s]/; // 4
	te = String.fromCharCode(tecla); // 5
	return patron.test(te); // 6
}
</script>