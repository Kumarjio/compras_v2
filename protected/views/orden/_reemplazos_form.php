<?php 
if($model->isNewRecord){
	$id_modelo = -1;
}else{
	$id_modelo = $model->id;
}
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
		    'id'=>'reemplazos-form',
		    'enableAjaxValidation'=>false,
		    'htmlOptions' => array('onSubmit' => 'return false')
		));

?>


			<?php echo $form->errorSummary($model); ?>
			<div style="overflow:hidden;">
				
				<?php echo $form->textFieldGroup($model,'orden_vieja',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'numeric')))); ?>
				
			</div>
			<div class="form-actions"> 
				<?php $this->widget('bootstrap.widgets.BootButton', array( 
					'buttonType'=>'submit', 
					'type'=>'primary', 
					'label'=>$model->isNewRecord ? 'Crear' : 'Editar', 
					)); ?>
			</div> 

<?php $this->endWidget(); ?>