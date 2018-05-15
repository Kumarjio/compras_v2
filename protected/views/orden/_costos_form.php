<?php 
if($model->isNewRecord){
	$id_modelo = -1;
}else{
	$id_modelo = $model->id;
}
if($model->isNewRecord == true and ($model->orden_solicitud->cantidad == null or $model->orden_solicitud->cantidad == '')){
	echo '<h4>Aún no ha ingresado la cantidad de productos. Esto se debe hacer antes de ingresar los centros de costo.</h4>';
}else{

	$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	    'id'=>'orden-solicitud-costos-form',
	    'enableAjaxValidation'=>false,
	    'htmlOptions' => array('onSubmit' => 'return false')
	));?>

			<?php echo $form->errorSummary($model); ?>
			<div style="overflow:hidden;">
				<div>
					<?php echo $form->hiddenField($model,'id_orden_solicitud',array('class'=>'span4')); ?>
				</div>
				<div class="row">
    				<div class="col-md-6">
                <?php echo $form->dropDownListGroup($model,'porcentaje_o_cantidad',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4'), 'data'=>array("Cantidad" => "Cantidad","Porcentaje" => "Porcentaje")))); ?>
                               
					
				    </div>
				    <div class="col-md-6">
					<?php echo $form->textFieldGroup($model,'numero',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4 numeric')))); ?>
				
					</div>
				</div>
                    <?php echo $form->hiddenField($model,'id_centro_costos',array('class'=>'span4', 'readonly' => true)); ?>

					
				<?php if($model->id_centro_costos != ""): ?>
			        <?php $centro_costos = CentroCostos::model()->findByPk($model->id_centro_costos); ?>
			        <?php echo $form->textFieldGroup(
			            $model,
			            'nombre_centro',
			            array( 
			                'append'=>CHtml::linkButton('Seleccionar centro de costos', array('class'=>'primary', 'id'=>'selectCostos', 'onClick'=>'selectCostos(this)')),
			                'appendOptions'=>array(
			                    'isRaw'=>false
			                ),  
			                'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true', 'value'=>$centro_costos->nombre))
			            )
			        ); ?>        

		    	<?php else: ?>

			        <?php echo $form->textFieldGroup(
			            $model,
			            'nombre_centro',
			            array( 
			                'append'=>CHtml::linkButton('Seleccionar centro de costos', array('class'=>'primary', 'id'=>'selectCostos', 'onClick'=>'selectCostos(this)')),
			                'appendOptions'=>array(
			                    'isRaw'=>false
			                ),  
			                'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true'))
			            )
			        ); ?>
			                

			    <?php endif ?>
 

					<?php echo $form->hiddenField($model,'id_cuenta_contable',array('class'=>'span1', 'readonly' => true)); ?>
					
				<?php if($model->id_cuenta_contable != ""): ?>
			        <?php $centro_costos = CentroCostos::model()->findByPk($model->id_cuenta_contable); ?>
			        <?php echo $form->textFieldGroup(
			            $model,
			            'nombre_cuenta',
			            array( 
			                'append'=>CHtml::linkButton('Seleccionar cuenta', array('class'=>'primary', 'id'=>'selectCuenta', 'onClick'=>'selectCuenta(this)')),
			                'appendOptions'=>array(
			                    'isRaw'=>false
			                ),  
			                'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true', 'value'=>$centro_costos->nombre))
			            )
			        ); ?>        

			    <?php else: ?>

			        <?php echo $form->textFieldGroup(
			            $model,
			            'nombre_cuenta',
			            array( 
			                'append'=>CHtml::linkButton('Seleccionar cuenta', array('class'=>'primary', 'id'=>'selectCuenta', 'onClick'=>'selectCuenta(this)')),
			                'appendOptions'=>array(
			                    'isRaw'=>false
			                ),  
			                'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true'))
			            )
			        ); ?>
			                

			    <?php endif ?>
 				<div class="row">
    				<div class="col-md-6">

				<?php echo $form->dropDownListGroup($model,'presupuestado',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4', 'prompt' => 'Seleccione...'), 'data'=>array("Presupuestado" => "Presupuestado", "Estimado" => "Estimado", "No Presupuestado" => "No Presupuestado")))); ?>
					</div>
    				<div class="col-md-6">
					<?php echo $form->textFieldGroup(
			            $model,
			            'valor_presupuestado',
			            array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4 numeric','maxlength'=>255)))
			        ); ?> 
			    	</div>
		    	</div>
					<?php 
					if($model->presupuestado == "Presupuestado"){
						echo $form->dropDownListGroup($model,'mes_presupuestado',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4','maxlength'=>255,'prompt' => 'Seleccione...'), 'data'=>CHtml::listData(Orden::model()->meses(), 'id','mes'))));
					}else{
						echo $form->dropDownListGroup($model,'mes_presupuestado',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4','maxlength'=>255,'prompt' => 'Seleccione...', 'disabled' => 'disabled'), 'data'=>array("Presupuestado" => "Presupuestado", "Estimado" => "Estimado", "No Presupuestado" => "No Presupuestado"))));
					}
					?>

			</div>

			<div class="form-actions">
			    <?php $this->widget('booster.widgets.TbButton', array(
			            'buttonType'=>'submit',
			            'context'=>'primary',
			            'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
			        )); ?>
			</div>

				<?php $this->endWidget(); ?>
<?php } ?>
