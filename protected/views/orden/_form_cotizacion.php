<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>'om-cotizacion-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('onSubmit' => 'return false')
)); ?>

<p class="help-block"><strong>Recuerde!</strong> 
        Los campos marcados con <span class="required">*</span>  son obligatorios.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'orden_producto'); ?>
    <?php if($model->nit != ""): ?>
        <?php $nit = Proveedor::model()->findByPk($model->nit); ?>
        <?php echo $form->textFieldGroup(
            $model,
            'nombre_proveedor',
            array( 
                'append'=>CHtml::linkButton('Seleccionar Proveedor', array('class'=>'primary', 'id'=>'selectProveedor', 'onClick'=>'selectProveedor(this)')),
                'appendOptions'=>array(
                    'isRaw'=>false
                ),  
                'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true', 'value'=>$nit->razon_social))
            )
        ); ?>        

    <?php else: ?>

        <?php echo $form->textFieldGroup(
            $model,
            'nombre_proveedor',
            array( 
                'append'=>CHtml::linkButton('Seleccionar Proveedor', array('class'=>'primary', 'id'=>'selectProveedor', 'onClick'=>'selectProveedor(this)')),
                'appendOptions'=>array(
                    'isRaw'=>false
                ),  
                'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true'))
            )
        ); ?>
                

    <?php endif ?>


    <?php echo $form->hiddenField($model,'nit'); ?>

    <?php echo $form->dropDownListGroup(
            $model,
            'contacto',
            array(
                'widgetOptions'=>array(
                    'htmlOptions'=>array('class'=>'span5'), 
                    'data'=> ($model->nit != '')? CHtml::listData(ContactoProveedor::model()->findAllByAttributes(array('nit' => $model->nit)), 'id', 'nombre') : array()

                ),
                'append'=>CHtml::linkButton('Crear Contacto', array('class'=>'primary', 'id'=>'crear_contacto','urlUpdateList'=>$this->createUrl('proveedor/contactos'))),
                'appendOptions'=>array(
                    'isRaw'=>false
                ),
            )); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->textFieldGroup($model,'numero',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span6','maxlength'=>255)))); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->textFieldGroup($model,'referencia',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span6','maxlength'=>255)))); ?>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-4">
            <?php echo $form->textFieldGroup($model,'cantidad',array( 'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6')))); ?>
        </div>
        <div class="col-md-4">
            <?php echo $form->textFieldGroup($model,'valor_unitario',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6')))); ?>
        </div>
        <div class="col-md-4">
            <?php echo $form->dropDownListGroup(
                $model,
                'moneda',
                array(
                    'widgetOptions'=>array(
                        'htmlOptions'=>array('class'=>'col-md-6','maxlength'=>255),
                        'data'=> CHtml::listData(Cotizacion::model()->getMonedas(), "id", "nombre")
                    ), 
                )
            ); ?>
        </div>
    </div>
<br />

    <div class="row">
        <?php
        if($model->moneda == "Peso" or $model->moneda == ''){
            $model->trm = 1;
            $style = "display:none";
            $class = "col-md-6";
        }
        else{
            $class = "col-md-4";
        }
        ?>
        <div id="trm" class="<?php echo $class ?>" style="<?php echo $style ?>" >
            <?php echo $form->textFieldGroup($model,'trm',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly' => 'readonly')))); ?>
        </div>
        <div class="<?php echo $class ?> totales">
            <?php echo $form->textFieldGroup($model,'total_compra',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'<?php echo $class ?>', 'readonly' => 'readonly')))); ?>
        </div>
        <div class="<?php echo $class ?> totales">
            <?php echo $form->textFieldGroup($model,'total_compra_pesos',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'readonly' => 'readonly')))); ?>
        </div>
    </div>

        <?php
        if($model->descuento_prontopago != 'Si'){
            $disabled = 'disabled';
        }
        ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->dropDownListGroup($model,'descuento_prontopago',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>2, 'prompt' => 'Seleccione...'),'data' =>array('Si' => 'Si', 'No' => 'No')))); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->textFieldGroup($model,'porcentaje_descuento',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'disabled'=>$disabled)))); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->textFieldGroup($model,'dias_pago_factura',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'disabled'=>$disabled)))); ?>
        </div>
    </div>

    <?php echo $form->textAreaGroup($model,'descripcion', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>


<div class="form-actions">
    <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
        )); ?>
</div>

<?php $this->endWidget(); ?>