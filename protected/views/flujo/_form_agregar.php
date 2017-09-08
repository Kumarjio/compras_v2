<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-agregar',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\'/correspondencia/index.php/flujo/crearFlujo\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#dialogo-editar\').modal(\'hide\'); $(\'#flujo-grid\').yiiGridView.update(\'flujo-grid\');}else{	$(\'#body-editar\').html(data.content);}},\'cache\':false});return false;'
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
	    	<?php echo CHtml::textField('actividad',$model->actividad0->actividad, array('class'=>'form-control', 'readonly'=>'true')); ?>
	      <?php echo $form->hiddenField($model,'actividad', array('class'=>'form-control', 'readonly'=>'true')); ?>
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
	    </div>
	</div>
	<div class='col-md-4'>
		<?php //echo $form->labelEx($model,'usuario'); ?>
	    <div class="form-group">
	      <?php /*$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
	      		'attribute' => 'usuario',
			    'name'=>'usuario',
			    'source'=>$this->createUrl("traerUsuarios"),
			    'options'=>array(
			        'minLength'=>'2',
			        'select' => 'js:function(event, ui)
								{ var valor = $("#Flujo_usuario").val();
									$("#Flujo_usuario").val(valor+ui.item.value+".\n"); }',
			    ),
			    'htmlOptions'=>array(
			        'class'=>'form-control',
			        'multiple' => 'multiple',
			    ),
			));
			*/?>
		</div>
	</div>
	<div class='col-md-12'>
		<?php echo $form->labelEx($model,'usuario'); ?>
	    <div class="form-group">
	      <?php //echo $form->textarea($model,'usuario',array('class'=>'form-control','readonly'=>'true')); 
	       $this->widget('ext.select2.ESelect2',array(
			  'model'=>$model,
			  'attribute'=>'usuario',
			  'data'=>Usuario::model()->cargarUsuarios(),
			  'htmlOptions'=>array(
			    'options'=>array('selected'=>true), //the selected values
			    'multiple'=>'multiple',
			    'style'=>'width:570px',
			  ),
		  ));?>
	    </div>
	</div>
	<div class='col-md-12'>
	    <div class="form-group">
	      <?php //echo $form->textarea($model,'usuario',array('class'=>'form-control','readonly'=>'true')); 
			/*$this->widget(
			    'booster.widgets.TbSelect2',
			    array(
			        'name' => 'group_id_list',
			        'data' => CHtml::listData(Usuario::model()->findAll(array('order' => 'nombres')),'usuario','nombres'),
			        'options' => array(
			        	'width' => '100%',),
			        'htmlOptions' => array(
			            'multiple' => 'multiple',
			        ),
			    )
			);*/?>
	    </div>
	</div>
</div>
<div class="form-actions"> 
	<?php $this->widget('bootstrap.widgets.BootButton', array( 
		'buttonType'=>'submit', 
		'type'=>'success', 
		'label'=>$model->isNewRecord ? 'Agregar' : 'Agregar', 
		)); ?>
</div>
<?php $this->endWidget(); ?>

