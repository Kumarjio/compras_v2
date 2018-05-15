<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-agregar-usuario',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('usuario/create').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#dialogo-usuario\').modal(\'hide\'); $(\'#usuario-grid\').yiiGridView.update(\'usuario-grid\');}else{$(\'#body-usuario\').html(data.content);}},\'cache\':false});return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model)  ?> 
<?php echo $form->errorSummary($roles)  ?>
<?php echo $form->errorSummary($areas)  ?>
<div class='col-md-6'>
	<?php echo $form->labelEx($model,'nombres'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'nombres',array('class'=>'form-control inicial','maxlength'=>'50','onKeypress'=>'return soloLetras(event)')); ?>
  	</div>
</div>
<div class='col-md-6'>
	<?php echo $form->labelEx($model,'apellidos'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'apellidos',array('class'=>'form-control inicial','maxlength'=>'50','onKeypress'=>'return soloLetras(event)')); ?>
  	</div>
</div>
<div class='col-md-4'>
	<?php echo $form->labelEx($model,'usuario'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'usuario',array('class'=>'form-control','maxlength'=>'10','onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;')); ?>
  	</div>
</div>
<?php if($model->isNewRecord){?>
<div class='col-md-4'>
	<?php echo $form->labelEx($model,'contraseña'); ?>
	<div class="form-group">
   		<?php echo $form->passwordField($model,'contraseña',array('class'=>'form-control','maxlength'=>'10')); ?>
  	</div>
</div>
<div class='col-md-4'>
	<?php echo $form->labelEx($model,'repetir'); ?>
	<div class="form-group">
   		<?php echo $form->passwordField($model,'repetir',array('class'=>'form-control','maxlength'=>'10')); ?>
  	</div>
</div>
<?php } ?>
<div class='col-md-12'>
	<?php echo $form->labelEx($model,'correo'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'correo',array('class'=>'form-control','maxlength'=>'50')); ?>
  	</div>
</div>
<div class='col-md-6'>
	<?php echo $form->labelEx($model,'cargo'); ?>
	<div class="form-group">
   		    <?php echo $form->dropDownList($model,'cargo', Cargos::cargosAll(),array('class'=>'form-control','prompt'=>'...')); ?>
  	</div>
</div>
<div class='col-md-6'>
	<?php echo $form->labelEx($roles,'id_rol'); ?>
    <div class="form-group">
      <?php //echo $form->textarea($model,'usuario',array('class'=>'form-control','readonly'=>'true')); 
       /*$this->widget('ext.select2.ESelect2',array(
		  'model'=>$roles,
		  'attribute'=>'id_rol',
		  'data'=>Roles::cargarRoles(),
		  'htmlOptions'=>array(
		    'options'=>array('selected'=>true), //the selected values
		    'multiple'=>'multiple',
		    'style'=>'width:548px',
		  ),
	  ));*/?>
    	<?php echo $form->dropDownList($roles,'id_rol', Roles::cargarRoles(),array('class'=>'form-control','prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-12'>
  <?php echo $form->labelEx($areas,'id_area'); ?>
  <div class="form-group">
    <?php //echo $form->dropDownList($areas,'id_area', Areas::model()->cargaAreas(),array('class'=>'form-control','prompt'=>'...')); ?>
	  <?php
	   $this->widget('ext.select2.ESelect2',array(
		  'model'=>$areas,
		  'attribute'=>'id_area',
		  'data'=>Areas::model()->cargaAreas(),
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
		'type'=>'success', 
		'label'=>$model->isNewRecord ? 'Guardar' : 'Actualizar', 
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