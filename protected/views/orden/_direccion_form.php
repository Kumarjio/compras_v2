<?php 
if($model->isNewRecord == true and ($model->orden_solicitud->cantidad == null or $model->orden_solicitud->cantidad == '')){
	echo '<h4>Aún no ha ingresado la cantidad de productos. Esto se debe hacer antes de ingresar las direcciones.</h4>';
}else{
	$dirs = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $model->id_orden_solicitud));
	$cant = 0;
	if(count($dirs) > 0){
		foreach($dirs as $d){
			$cant += $d->cantidad;
		}
	}
	if($model->isNewRecord == false or $model->orden_solicitud->cantidad > $cant){

		if($model->isNewRecord){
			$id_modelo = -1;
		}else{
			$id_modelo = $model->id;
		}
		$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
		    'id'=>'orden-solicitud-direccion-form',
		    'enableAjaxValidation'=>false,
		    'htmlOptions' => array('onSubmit' => 'return false')
		));?>

		<?php echo $form->errorSummary($model); ?>
		<div style="overflow:hidden;">
		<div>
			<?php echo $form->hiddenField($model,'id_orden_solicitud',array('class'=>'span4')); ?>
		</div>
		<?php 
			if((($model->orden_solicitud->cantidad - $cant) == 1) and $model->isNewRecord == true){
				$model->cantidad = 1;
				echo $form->textFieldGroup($model,'cantidad',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4 numeric', 'readonly' => 'readonly'))));
			}else{
				echo $form->textFieldGroup($model,'cantidad',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4 numeric'))));
			}
		?>
		<?php echo $form->textFieldGroup($model,'responsable',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>

		<?php echo $form->textFieldGroup($model,'direccion_entrega',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>

		<?php echo $form->textFieldGroup($model,'ciudad',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>

		<?php echo $form->textFieldGroup($model,'departamento',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>

		<?php echo $form->textFieldGroup($model,'telefono',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>
		</div>
	</div>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit', 
			'type'=>'primary', 
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar', 
			)); ?>
	</div> 
		<?php $this->endWidget(); 
	}else{
		echo '<h3>No se pueden agregar más direcciones.</h3>';
	}
}
?>