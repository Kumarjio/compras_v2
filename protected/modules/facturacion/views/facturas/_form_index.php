    <?php //echo Yii::app()->user->getState('id_empleado');?>
    <?php echo $form->textFieldRow($model,'nit_proveedor',array('class'=>'span5', 'readonly'=>$readonly)); ?>

    <?php echo CHtml::label("Nombre Proveedor", 'name_pro'); ?>
    <?php echo CHtml::textField('name_proveedor',$model->nitProveedor->razon_social,array('class'=>'span5','readonly'=>$readonly)); ?>

    <?php echo $form->textFieldRow($model,'fecha_recibido',array('class'=>'span5', 'readonly'=>$readonly)); ?>

    <?php echo $form->textFieldRow($model,'nro_factura',array('class'=>'span5','maxlength'=>17,'readonly'=>$modificar_campos)); ?>

    <?php
            echo $form->labelEx($model,'fecha_factura');
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'id'=>'picker_fecha_fact',
                    'attribute'=>'fecha_factura',
                    'language' => 'es',
                    'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth'=> true,
                            'changeYear'=> true,
                            'maxDate'=>date('Y-m-d'),
                            ),'htmlOptions'=>array(
                                    'style'=>'height:20px;',
                                    'data-sync' => 'true',
                                    'class' => 'span5',
                                    'readonly'=>$modificar_campos
                                    )
                    )
            );
    ?>

    <?php
            echo $form->labelEx($model,'fecha_vencimiento');
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'id'=>'picker_fecha_venc',
                    'attribute'=>'fecha_vencimiento',
                    'language' => 'es',
                    'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth'=> true,
                            'changeYear'=> true,
                            'minDate'=>date('Y-m-d'),
                            ),'htmlOptions'=>array(
                                    'style'=>'height:20px;',
                                    'data-sync' => 'true',
                                    'class' => 'span5',
                                    'readonly'=>$modificar_campos
                                    )
                    )
            );
    ?>
<?php //echo $form->dropDownListRow($model,'analista_encargado',  CHtml::listData(Analistas::model()->with('infoAnalista')->findAll(), 'id_analista', 'infoAnalista.nombre_completo'),array('class'=>'span5', 'prompt'=>'Seleccione Responsable ...','disabled'=>$modificar_campos)); ?>
<?php echo $form->labelEx($model,'analista_encargado'); ?>
<?php echo $form->hiddenField($model,'analista_encargado'); ?>
    <?php 
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'nombre_analista',
                'name'=>'nombre_analista',
                'source'=>array_map(function($key, $value) {
                    $algo = explode(' - ', $value);
                   return array('label' => $value, 'value' => $algo[1], 'key'=>  $key);
                }, 
                array_keys(Facturas::model()->getAnalista()), 
                Facturas::model()->getAnalista()),
                'htmlOptions'=>array(
                    'class'=>'span5',
                ),
                'options'=> array(
                    'select'=>"js:function(event, ui) { 
                        $('#Facturas_analista_encargado').val(ui.item.key); 
                    }",
                    'response'=>"js:function(event, ui) { 
                        console.log('HL close');
                    }"
                ),
            ));
         ?>
<?php echo $form->textAreaRow($model,'observacion',array('class'=>'span5')); ?>

<?php echo $form->dropDownListRow($model,'paso_wf',  SWHelper::nextStatuslistData($model),array('class'=>'span5')); ?>

<div class="form-actions">
        <?php $this->widget('bootstrap.widgets.BootButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
        )); ?>
</div>