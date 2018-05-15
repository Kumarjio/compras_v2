<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-fecha-fliente',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('recepcion/fechaCliente').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-fecha-cliente\').modal(\'hide\');parent.window.location.reload();}else{$(\'#body-fecha-cliente\').html(data.content);}},\'cache\':false});return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model,'na'); ?>
<?php echo $form->hiddenField($model,'documento'); ?>
<?php echo $form->hiddenField($model,'tipologia'); ?>
<?php echo $form->hiddenField($model,'ciudad'); ?>
<?php echo $form->hiddenField($model,'tipo_documento'); ?>
<?php echo $form->hiddenField($model,'user_recepcion'); ?>
<?php echo $form->hiddenField($model,'fecha_recepcion'); ?>
<?php echo $form->hiddenField($model,'fecha_entrega'); ?>
<?php echo $form->hiddenField($model,'hora_entrega'); ?>
<?php echo $form->hiddenField($model,'fecha_interna'); ?>
<div class='col-sm-1'></div>
<div class='col-sm-3'>
	<?php echo $form->labelEx($model,'fecha_cliente', array('class' => 'control-label')); ?>
</div>
<div class='col-sm-4'>
	<?php
		$this->widget('booster.widgets.TbDatePicker',   
			array(
				'model'=>$model,
				'attribute'=>'fecha_cliente',
				'options' => array(
					'language' => "es",
					'autoclose'=>true,
					'format' => "yyyy/mm/dd",
				    'startDate' => date("Y/m/d", strtotime($model->fecha_interna)),
				    'endDate' => date("Y/m/d", strtotime('+5 year', strtotime(date("Y/m/d")))),
				),
				'htmlOptions' => array(
		        	'class'=>'form-control',
		    	),
			)
		);
	?>
</div>
<div class='col-sm-4'>
<div class="form-actions"> 
	<?php $this->widget('bootstrap.widgets.BootButton', array( 
		'buttonType'=>'submit', 
		'type'=>'success', 
		'label'=>'Guardar', 
		)); ?>
</div>
</div>
<?php $this->endWidget(); ?>