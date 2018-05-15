<?php if ($modificar_campos): ?>
    <div class="accordion" id="accordion2">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                   Órdenes de Compra Asociadas
                </a>
            </div>
            <div id="collapseOne" class="accordion-body in collapse">
                <div class="accordion-inner">
                <?php endif; ?>
                <div class="well">
                    <br/>   
                    <?php
                    if (!$modificar_campos) {
                        $this->widget('bootstrap.widgets.BootButton', array(
                            'label' => 'Agregar Orden de Compra',
                            'url' => '#myModalOrden',
                            'type' => 'primary',
                            'htmlOptions' => array('data-toggle' => 'modal', 'style' => 'margin:-9px 0px 0px 35px; '),
                        ));
                    }
                    ?>

                    <?php
                    $this->widget('bootstrap.widgets.BootGridView', array(
                        'id' => 'ordenes-factura-grid',
                        'dataProvider' => OrdenesFactura::model()->search($model->id_factura),
                        'type' => 'striped bordered condensed',
                        'enableSorting'=>false,
                        'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                        'columns' => array(
                            'id_orden',
                            array(
                                'header' => 'Cuentas Contables',
                                'type' => 'raw',
                                'value' => '$data->getCuentasContables()'
                            ),
                            array(
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{delete}',
                                'buttons' => array
                                    (
                                    'delete' => array
                                        (
                                        'visible' => ($this->getAction()->getId()=='view')?'false': '$data->permitirEliminar()'
                                    )
                                ),
                                'afterDelete' => 'function(link, success, data){ if(success){  $(\'#proveedores-seleccion-grid\').yiiGridView.update(\'proveedores-seleccion-grid\'); }}',
                                'deleteButtonUrl' => 'Yii::app()->createUrl(\'facturacion/facturas/deleteOrden/id/\'. $data->id_ordenes_factura)',
                            ),
                        ),
                    ));
                    ?>
                </div>
<?php if ($modificar_campos): ?> 
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                    Infomación General Factura
                </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner">   

                <?php endif; ?>
<?php echo $form->textFieldRow($model, 'nit_proveedor', array('class' => 'span5', 'readonly' => $readonly)); ?>

                <?php echo CHtml::label("Nombre Proveedor", 'name_pro'); ?>
                <?php echo CHtml::textField('name_proveedor', $model->nitProveedor->razon_social, array('class' => 'span5', 'disabled' => $readonly)); ?>
                
                <?php echo $form->textFieldRow($model, 'fecha_recibido', array('class' => 'span5', 'readonly' => $readonly)); ?>
                <?php echo $form->textFieldRow($model, 'valor_productos', array('class' => 'span5 maskValor autosave', 'disabled' => $modificar_campos)); ?>
                <span class="label label-warning">
                     Valor antes de IVA.
                </span><br><br>

                <?php echo $form->textFieldRow($model, 'nro_factura', array('class' => 'span5', 'maxlength' => 17, 'readonly' => $modificar_campos)); ?>

                <?php
                echo $form->labelEx($model, 'fecha_factura');
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'id' => 'picker_fecha_fact',
                    'attribute' => 'fecha_factura',
                    'language' => 'es',
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                        'changeYear' => true,
                        'maxDate' => date('Y-m-d'),
                    ), 'htmlOptions' => array(
                        'style' => 'height:20px;',
                        'data-sync' => 'true',
                        'class' => 'span5',
                        'readonly' => $modificar_campos,
                        'disabled' => $modificar_campos
                    )
                        )
                );
                ?>

                <?php
                echo $form->labelEx($model, 'fecha_vencimiento');
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'id' => 'picker_fecha_venc',
                    'attribute' => 'fecha_vencimiento',
                    'language' => 'es',
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                        'changeYear' => true,
                        'minDate' => date('Y-m-d'),
                    ), 'htmlOptions' => array(
                        'style' => 'height:20px;',
                        'data-sync' => 'true',
                        'class' => 'span5',
                        'readonly' => $modificar_campos,
                        'disabled' => $modificar_campos
                    )
                        )
                );
                ?>
<?php if ($modificar_campos): ?>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                    Cuentas y Centros de Costos
                </a>
            </div>
            <div id="collapseThree" class="accordion-body in collapse">
                <div class="accordion-inner">
                    <?php endif; ?>

                <div class="well">
<?php $modificar = (($model->paso_wf == 'swFacturas/revisionanalista' || $model->paso_wf == 'swFacturas/devolver_revision_analista') && !$model->hasErrors()) || ($model->paso_wf == 'swFacturas/aprobar_jefe' && $model->hasErrors()) ||
        (($model->paso_wf == 'swFacturas/causacion' || $model->paso_wf == 'swFacturas/devolver_causacion') && !$model->hasErrors()) || ($model->paso_wf == 'swFacturas/enviar_fra' && $model->hasErrors());
?>
                    <?php echo CHtml::label("Cuentas Contables", 'cta_ctable'); ?>
                    <?php if ($modificar): ?>


                        <?php
                        $this->widget('bootstrap.widgets.BootButton', array(
                            'label' => 'Agregar Cuenta Contable',
                            'url' => '#myModalContable',
                            'type' => 'primary',
                            'htmlOptions' => array('data-toggle' => 'modal', 'style' => 'margin:-9px 0px 0px 35px; '),
                        ));
                        ?>

                    <?php endif; ?>        
                    <?php
                    $this->widget('bootstrap.widgets.BootGridView', array(
                        'id' => 'contable-factura-grid',
                        'dataProvider' => CuentasFacturas::model()->search($model->id_factura),
                        'type' => 'striped bordered condensed',
                        'enableSorting'=>false,
                        'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                        'columns' => array(
                            array(
                                'name' => 'id_cuenta',
                                'value' => '$data->idCuentaContable->codigo'
                            ),
                            array(
                                'header' => 'Nombre',
                                'value' => '$data->idCuentaContable->nombre'
                            ),
                            array(
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{delete}',
                                'buttons' => array
                                    (
                                    'delete' => array
                                        (
                                        'visible' => ($this->getAction()->getId()=='view')?'false':'$data->permitirEliminar()'
                                    )
                                ),
                                //'afterDelete' => 'function(link, success, data){ if(success){  $(\'#proveedores-seleccion-grid\').yiiGridView.update(\'proveedores-seleccion-grid\'); }}',
                                'deleteButtonUrl' => 'Yii::app()->createUrl(\'facturacion/facturas/deleteCuenta/id/\'. $data->id_cuenta_factura)',
                            ),
                        ),
                    ));
                    ?>
                    <?php echo $form->label($model, 'id_centro_costos'); ?>

                    <?php if ($modificar): ?>


                        <?php
                        $this->widget('bootstrap.widgets.BootButton', array(
                            'label' => 'Agregar Centro Costos',
                            'url' => '#myModalCostos',
                            'type' => 'primary',
                            'htmlOptions' => array('data-toggle' => 'modal', 'style' => 'margin:-9px 0px 0px 35px; ', 'id' => 'btn_costos'),
                        ));
                        ?>

                    <?php endif; ?>  
                    <?php
                    $this->widget('bootstrap.widgets.BootGridView', array(
                        'id' => 'centro-costos-factura-grid',
                        'dataProvider' => CentroCostosFacturas::model()->search($model->id_factura),
                        'type' => 'striped bordered condensed',
                        'enableSorting'=>false,
                        'afterAjaxUpdate' => 'reinstalarValidacion',
                        'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                        'columns' => array(
                            array(
                                'name' => 'id_centro_costos',
                                'value' => '$data->idCentroCostos->codigo'
                            ),
                            array(
                                'header' => 'Nombre',
                                'value' => '$data->idCentroCostos->nombre'
                            ),
                            array(
                                'name' =>'valor',
                                'type'=>'raw',
                                'value'=>'CHtml::activeTextField($data, "valor[$data->id_centro_costos_factura]", array("value"=>$data->valor,"class"=>"maskValor valor_centro", "style"=>"text-align: right; width:123px;", "data_fra"=>$data->id_centro_costos_factura, "data_atrib"=>"valor"))'
                            ),
                            array(
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{delete}',
                                'buttons' => array
                                    (
                                    'delete' => array
                                        (
                                        'visible' => ($this->getAction()->getId()=='view')?'false':'$data->permitirEliminar()'
                                    )
                                ),
                                //'afterDelete' => 'function(link, success, data){ if(success){  $(\'#proveedores-seleccion-grid\').yiiGridView.update(\'proveedores-seleccion-grid\'); }}',
                                'deleteButtonUrl' => 'Yii::app()->createUrl(\'facturacion/facturas/deleteCostos/id/\'. $data->id_centro_costos_factura)',
                            ),
                        ),
                    ));
Yii::app()->clientScript->registerScript('centro-costos-factura-grid', "
function reinstalarValidacion(id, data) {
    
    $('.maskValor').maskMoney({decimal:'.',precision:0, allowZero:true});
    
    $('.valor_centro').blur(function(e){
        e.preventDefault();
        autoGuardarCentro(this);
    });
    function autoGuardarCentro(selector){
        
        var valor = selector.value;
        var id_centro_costos_factura = $(selector).attr('data_fra');
        var atributo = $(selector).attr('data_atrib');
        if(atributo == 'valor' && valor*1 == 0)
            valor = '';
        var url = '". Yii::app()->createUrl('facturacion/facturas/guardarValorCentro')."'; 
        
        var xhr =null;
        xhr = $.ajax({
            type: 'post',
            dataType : 'json',
            url : url,
            data : { valor : valor, id_centro_costos_factura : id_centro_costos_factura, atributo: atributo },
            success : function(data){
            //  console.log(data);
               if(data.status == '1'){
                   //resetGridView('facturas-tipi-grid-detalle');
               }else{
                   //alert('no guardo');
               }
            },
            cache: false
        });
    }
}
"); 
                    ?>
                </div>
<?php if ($modificar_campos): ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>                        
    <?php echo $form->textAreaRow($model, 'observacion', array('class' => 'span5')); ?>

    <?php echo $form->dropDownListRow($model, 'paso_wf', SWHelper::nextStatuslistData($model), array('class' => 'span5')); ?>

<div class="form-actions">
<?php
$this->widget('bootstrap.widgets.BootButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => $model->isNewRecord ? 'Crear' : 'Actualizar',
));
?>
</div>
