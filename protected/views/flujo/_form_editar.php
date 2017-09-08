<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-editar',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\'/correspondencia/index.php/flujo/editar\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#dialogo-editar\').modal(\'hide\'); $(\'#flujo-grid\').yiiGridView.update(\'flujo-grid\');}else{	$(\'#body-editar\').html(data.content);}},\'cache\':false});return false;'
	)
));?>
<div class="row">
	<?php if($model->hasErrors()){ ?>
	  <div class="bg-danger alertaImagine">
	    <?php echo $form->errorSummary($model)  ?> 
	  </div>
	<?php } ?>
	<div class='col-md-6'>
		<?php echo $form->labelEx($model,'actividad'); ?>
	    <div class="form-group">
	      <?php echo $form->dropDownList($model,'actividad', Actividades::model()->cargaActividades(),array('class'=>'form-control', 'prompt'=>'...')); ?>
	    </div>
	</div>
	<div class='col-md-6'>
		<?php echo $form->labelEx($model,'sucesion'); ?>
	    <div class="form-group">
	      <?php echo $form->dropDownList($model,'sucesion', Actividades::model()->cargaActividades(),array('class'=>'form-control', 'prompt'=>'...')); ?>
	    </div>
	</div> 
	<div class='col-md-4 oculto'>
	    <div class="form-group">
	      <?php echo $form->textField($model,'tipologia',array('class'=>'form-control')); ?>
	       <?php echo $form->textField($model,'id', array('class'=>'form-control', 'readonly'=>'true')); ?>
	    </div>
	</div>
	<div class='col-md-12'>
		<?php echo $form->labelEx($model,'usuario'); ?>
	    <div class="form-group">
	      <?php
	       $this->widget('ext.select2.ESelect2',array(
			  'model'=>$model,
			  'attribute'=>'usuario',
			  'data'=>Usuario::model()->cargarUsuarios(),
			  'htmlOptions'=>array(
			    'options'=>array('selected'=>true),
			    'multiple'=>'multiple',
			    'style'=>'width:570px',
			  ),
		  ));?>
	    </div>
	</div>
</div>
<div class="form-actions"> 
	<?php $this->widget('bootstrap.widgets.BootButton', array( 
		'buttonType'=>'submit', 
		'type'=>'success', 
		'label'=>$model->isNewRecord ? 'Editar' : 'Editar', 
		)); ?>
</div>
<?php $this->endWidget(); ?>
