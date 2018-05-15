<?php 
if($model->isNewRecord){
	$id_modelo = -1;
}else{
	$id_modelo = $model->id;
}

		$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
		    'id'=>'orden-solicitud-costos-form',
		    'enableAjaxValidation'=>false,
		    'htmlOptions' => array('onSubmit' => 'return false')
		));?>

			<?php echo $form->errorSummary($model); ?>
			<div style="overflow:hidden;">
				<div>
					<?php echo $form->hiddenField($model,'id_orden_solicitud',array('class'=>'span4')); ?>
  					<?php echo $form->hiddenField($model,'cantidad',array('class'=>'span4 numeric', 'maxlength' => '10')); ?>
				</div>
				
					<?php echo $form->textFieldGroup($model,'nit',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4 numeric', 'maxlength' => 9)))); ?>
				
					<?php echo $form->textFieldGroup($model,'proveedor',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>

					<?php echo $form->textFieldGroup($model,'valor_unitario',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4 numeric', 'onBlur' => "$('#OrdenSolicitudProveedor_total_compra').val($('#OrdenSolicitudProveedor_valor_unitario').val() * $('#OrdenSolicitud_cantidad').val());")))); ?>

					<?php echo $form->dropDownListGroup($model,'moneda',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4'), 'data'=>CHtml::listData(Cotizacion::model()->getMonedas(), "id", "nombre")))); ?>

					<?php echo $form->textFieldGroup($model,'total_compra',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4 numeric')))); ?>

				
				
			</div>
			<div class="form-actions"> 
				<?php $this->widget('bootstrap.widgets.BootButton', array( 
					'buttonType'=>'submit', 
					'type'=>'primary', 
					'label'=>$model->isNewRecord ? 'Crear' : 'Editar', 
					)); ?>
			</div> 

<?php $this->endWidget(); ?>