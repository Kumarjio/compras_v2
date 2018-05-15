<?php
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id' => 'facturas-form',
    'enableAjaxValidation' => false,
    'clientOptions' => array(
        ''
    )
        ));
?>

<!--    <div class="alert alert-block alert-warning fade in">
                <a class="close" data-dismiss="alert">×</a>
                <strong>Recuerde!</strong> 
                Los campos marcados con <span class="required">*</span> son obligatorios.
        </div>-->
<div class='row'>
    <div class='span5'>
<?php if ($alertas_nit): ?>
    <?php if ($alertas_nit->indicador1 == 2 || $alertas_nit->indicador2 == 1 || $alertas_nit->indicador3 == 2 || $alertas_nit->indicador4 == 2): ?>
                <div class="alert alert-block alert-warning fade in">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Alerta!</strong><br>
                    <?php if ($alertas_nit->indicador1 == 2): ?>
                        El nit no existe en AS400<br>
                    <?php endif; ?>
                    <?php if ($alertas_nit->indicador2 == 1): ?>
                        Este nit se encuentra en al menos una lista de clientes no deseables<br>
                    <?php endif; ?>
                    <?php if ($alertas_nit->indicador3 == 2): ?>
                        El proveedor tiene documentos incompletos<br>
                    <?php endif; ?>
                    <?php if ($alertas_nit->indicador4 == 2): ?>
                        El proveedor tiene documentos vencidos<br>
                <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php echo $form->errorSummary($model); ?>
        <?php if($actualizado): ?>
            <div class="alert alert-block alert-success fade in">
                <a class="close" data-dismiss="alert">×</a>
                <strong>OK!</strong><br>
                Factura Actualizada Correctamente<br>
            </div>
        <?php endif; ?>
<?php if ($ver >= 6): ?>    
            <div class="accordion" id="accordion2">
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                            Ordenes de Compra Asociadas
                        </a>
                    </div>
                    <div id="collapseOne" class="accordion-body in collapse">
                        <div class="accordion-inner">
                        <?php endif; ?>
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
                                        'visible' => ($this->getAction()->getId()=='view')?'false': '$data->idFactura->usuario_actual == Yii::app()->user->getState("id_empleado")',//'$data->permitirEliminar()'
                                    )
                                ),
                                'afterDelete' => 'function(link, success, data){ if(success){  $(\'#proveedores-seleccion-grid\').yiiGridView.update(\'proveedores-seleccion-grid\'); }}',
                                'deleteButtonUrl' => 'Yii::app()->createUrl(\'facturacion/facturas/deleteOrden/id/\'. $data->id_ordenes_factura)',
                            ),
                            ),
                        ));
                        ?>
<?php if ($ver >= 6): ?>  
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                            Infomación General Factura
                        </a>
                    </div>
                    <div id="collapseTwo" class="accordion-body in collapse">
                        <div class="accordion-inner">   

<?php endif; ?>
<?php echo $this->renderPartial('_view_parcial', array('model' => $model)) ?>
<?php if ($ver >= 6): ?>
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
<?php $modificar = (($model->paso_wf == 'swFacturas/causacion' || $model->paso_wf == 'swFacturas/devolver_causacion') && !$model->hasErrors()) || ($model->paso_wf == 'swFacturas/enviar_fra' && $model->hasErrors()); ?>

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
                                'id' => 'contable-factura-grid2',
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
                                        'visible' => ($this->getAction()->getId()=='view')?'false': '$data->idFactura->usuario_actual == Yii::app()->user->getState("id_empleado")',//'$data->permitirEliminar()'
                                            )
                                        ),
                                        //'afterDelete' => 'function(link, success, data){ if(success){  $(\'#proveedores-seleccion-grid\').yiiGridView.update(\'proveedores-seleccion-grid\'); }}',
                                        'deleteButtonUrl' => 'Yii::app()->createUrl(\'facturacion/facturas/deleteCuenta/id/\'. $data->id_cuenta_factura)',
                                    ),
                                ),
                            ));
                            ?>


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
                                        'visible' => ($this->getAction()->getId()=='view')?'false': '$data->idFactura->usuario_actual == Yii::app()->user->getState("id_empleado")',//'$data->permitirEliminar()'
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

        <?php if ($ver >= 6): ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
        if ($model->lote != '') {
            echo $form->textFieldRow($model, 'lote', array('class' => 'span5 numero', 'maxlength' => 8, 'readonly' => 'readonly'));
        }
        ?>
            <?php echo $form->textFieldRow($model, 'valor_productos', array('class' => 'span5 maskValor autosave', 'disabled' => ($ver >= 6))); ?>
            <?php if ($ver != 5) : ?>
                <?php echo CHtml::hiddenField('fecha_hoy', date('Ymd')); ?>
                <?php echo $form->dropDownListRow($model, 'agencia', array('100' => '100', '200' => '200', '300' => '300'), array('class' => 'span5 autosave', 'prompt' => 'Seleccione...', 'disabled' => ($ver >= 6))); ?>
                <?php echo $form->dropDownListRow($model, 'fuente', array('201' => '201', '406' => '406', '321' => '321', '003' => '003', '301' => '301'), array('class' => 'span5 autosave', 'prompt' => 'Seleccione...', 'disabled' => ($ver >= 6))); ?>
                <?php echo $form->textFieldRow($model, 'descripcion_lote', array('class' => 'span5 autosave', 'disabled' => ($ver >= 6))); ?>
                <?php echo $form->textFieldRow($model, 'fecha_limite_pago', array('class' => 'span5 numero autosave', 'maxlength' => 8, 'disabled' => ($ver >= 6))); ?>
                <?php echo $form->dropDownListRow($model, 'parametro', array('1' => 'Fecha Normal', '2' => 'Todas las Fechas'), array('class' => 'span5 autosave', 'disabled' => ($ver >= 6))); ?>
            <div id="fechas">
                <?php
                if ($model->fecha_proceso == '')
                    $val_pro = date('Ymd');
                else
                    $val_pro = $model->fecha_proceso;
                if ($model->fecha_efectiva == '')
                    $val_efe = date('Ymd');
                else
                    $val_efe = $model->fecha_efectiva;
                ?>
                <?php echo $form->textFieldRow($model, 'fecha_proceso', array('class' => 'span5 numero autosave', 'maxlength' => 8, 'value' => $val_pro, 'disabled' => ($ver >= 6))); ?>
                <?php echo $form->textFieldRow($model, 'fecha_efectiva', array('class' => 'span5 numero autosave', 'maxlength' => 8, 'value' => $val_efe, 'disabled' => ($ver >= 6))); ?>
            </div> 
            <?php endif; ?>    
            <?php if ($ver < 7): ?> 
    <?php echo $form->dropDownListRow($model, 'paso_wf', SWHelper::nextStatuslistData($model), array('class' => 'span5')); ?>
<?php endif; ?>
        <?php echo $form->textAreaRow($model, 'observacion', array('class' => 'span5')); ?>

        <div class="form-actions">
<?php
$this->widget('bootstrap.widgets.BootButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => $model->isNewRecord ? 'Crear' : 'Actualizar',
));
?>
        </div>
    </div>
    <div class="span7" id="divCont">
        <?php // echo CHtml::textField($name) ?>
        <?php $this->renderPartial('verArchivo', array('archivo' => $model->path_imagen)); ?>

    </div>
</div>
<div class="row">
        <?php if ($ver == 1): ?>
        <div class="span4">
            <?php echo CHtml::hiddenField("id_lista"); ?>
            <?php
            $this->widget('bootstrap.widgets.BootGridView', array(
                'id' => 'contable-factura-grid3',
                'dataProvider' => TipificadasFacturas::model()->search($model->id_factura),
                'enableSorting' => false,
                'type' => 'striped bordered condensed',
                'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                'columns' => array(
                    //'cuenta', 
                    'codigo_tipificada',
                    array(
                        'name' => 'descripcion_tipificada',
                        'type' => 'raw',
                        'value' => 'CHtml::ajaxLink($data->descripcion_tipificada,
                                                        Yii::app()->createUrl("facturacion/facturas/traerDetalleTipi", 
                                                        array("cuenta"=>$data->cuenta, "tipificada"=>$data->codigo_tipificada, "factura"=>$data->id_factura)), 
                                                        array(
                                                            "update"=>"#valores_tipi",
                                                        ),array(
                                                            "onclick"=>"$(\"#id_lista\").val($(this).attr(\"id\"));",
                                                            "class"=>"ocultar_view"
                                                        ))'
                    ),
//                                  'consecutivo_valor',
//                                  'descripcion_valor',
//                                  array(
//                                      'name'=>'valor',
//                                      'type'=>'raw',
//                                      'value'=>'CHtml::activeTextField($data, "valor[$data->id_tipificadas_facturas]", array("value"=>$data->valor,"class"=>"maskValor", "style"=>"text-align: right;"))'
//                                  )
//                                    array(
//                                        'class'=>'bootstrap.widgets.BootButtonColumn',
//                                        'template' => '{delete}',
//                                        'buttons'=>array
//                                                  (
//                                                    'delete' => array
//                                                        (
//                                                            'visible'=>'$data->permitirEliminarCaus()'
//                                                        )
//                                                ),
//                                        
//                                        //'afterDelete' => 'function(link, success, data){ if(success){  $(\'#proveedores-seleccion-grid\').yiiGridView.update(\'proveedores-seleccion-grid\'); }}',
//                                        'deleteButtonUrl'=>'Yii::app()->createUrl(\'facturacion/facturas/deleteCuenta/id/\'. $data->id_cuenta_factura)',
//                                ),
                ),
            ));
            ?>

            <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.BootButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => $model->isNewRecord ? 'Crear' : 'Actualizar',
        ));
        ?>
            </div>
        </div>   
        <div class="span8" id="valores_tipi">

        </div>
    <?php endif; ?>

    <?php if ($ver == 2): ?>
        <?php
        $this->widget('bootstrap.widgets.BootGridView', array(
            'id' => 'contable-factura-grid4',
            'dataProvider' => TipificadasFacturas::model()->search_lote_generado($model->id_factura),
            'type' => 'striped bordered condensed',
            'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
            'columns' => array(
                array(
                    'name' => 'cuenta',
                    'value' => '($data->cuenta != "")? $data->cuenta : $data->cuentas'
                ),
                'id_tipificadas_facturas',
                'descripcion_tipificada',
                'descripcion_valor',
                'naturaleza',
                array(
                    'name' => 'vr_codigo_cuentas',
                    'header' => 'Valor Calculado',
                    'type' => 'number',
                    'value' => '($data->vr_codigo_cuentas == "")? 0 : $data->vr_codigo_cuentas'
                ),
                array(
                    'name' => 'centro_costos',
                    'type' => 'raw',
                    'value' => '($data->tipo_consulta == 1)? CHtml::textField("centro_costos[$data->id_tipificadas_facturas]",$data->centro_costos , array("class"=>"centroAutocomplete", "size"=>10, "style"=>"width:123px", "data_fra"=>$data->id_tipificadas_facturas, "data_atrib"=>"centro_costos")) : $data->centro_costos'
                ),
                array(
                    'name' => 'agencia',
                    'type' => 'raw',
                    'value' => '($data->tipo_consulta == 1)? CHtml::dropDownList("agencia[$data->id_tipificadas_facturas]", $data->agencia, array("100"=>"100","200"=>"200","300"=>"300"),array("class"=>"valor_tipi", "style"=>"width:123px","data_fra"=>$data->id_tipificadas_facturas, "data_atrib"=>"agencia", "prompt"=>"Selecccione...")) : $data->agencia'
                ),
                array(
                    'name' => 'valor',
                    'type' => 'raw',
                    'value' => '($data->tipo_consulta == 1)? CHtml::activeTextField($data, "valor[$data->id_tipificadas_facturas]", array("value"=>$data->valor,"class"=>"maskValor valor_tipi", "style"=>"text-align: right;width:123px", "data_fra"=>$data->id_tipificadas_facturas, "data_atrib"=>"valor")) : "$data->valor"'
                )
//                                    array(
//                                        'class'=>'bootstrap.widgets.BootButtonColumn',
//                                        'template' => '{delete}',
//                                        'buttons'=>array
//                                                  (
//                                                    'delete' => array
//                                                        (
//                                                            'visible'=>'$data->permitirEliminarCaus()'
//                                                        )
//                                                ),
//                                        
//                                        //'afterDelete' => 'function(link, success, data){ if(success){  $(\'#proveedores-seleccion-grid\').yiiGridView.update(\'proveedores-seleccion-grid\'); }}',
//                                        'deleteButtonUrl'=>'Yii::app()->createUrl(\'facturacion/facturas/deleteCuenta/id/\'. $data->id_cuenta_factura)',
//                                ),
            ),
        ));
        ?>


        <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.BootButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => $model->isNewRecord ? 'Crear' : 'Actualizar',
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.BootButton', array(
            'label' => 'Agregar Linea para Modificar Lote',
            'url' => '#myModalModificarTipi',
            'type' => 'primary',
            'htmlOptions' => array('data-toggle' => 'modal', 'style' => 'margin:-9px 0px 0px 35px; ', 'id' => 'btn_costos'),
        ));
        ?>
        </div>
    <?php endif; ?>
    <?php if ($ver >= 6): ?>
        <?php
        $this->widget('bootstrap.widgets.BootGridView', array(
            'id' => 'contable-factura-grid4',
            'dataProvider' => TipificadasFacturas::model()->search_lote_generado($model->id_factura),
            'type' => 'striped bordered condensed',
            'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
            'columns' => array(
                array(
                    'name' => 'cuenta',
                    'value' => '($data->cuenta != "")? $data->cuenta : $data->cuentas'
                ),
                'descripcion_tipificada',
                'descripcion_valor',
                'naturaleza',
                array(
                    'name' => 'vr_codigo_cuentas',
                    'header' => 'Valor Calculado',
                    'type' => 'number',
                    'value' => '($data->vr_codigo_cuentas == "")? 0 : $data->vr_codigo_cuentas'
                ),
                'centro_costos',
                'agencia',
                'valor',
            ),
        ));
        ?>

<?php endif; ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">


    $(document).ready(function () {

        ocultarYMostrar();
        $('.autosave').on('blur', function () {
            var id_factura = <?php echo $model->id_factura; ?>;
            var valor = this.value;
            var atributo = $(this).attr('name').split("[")[1].split("]")[0];
            var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/autoSave") ?>';
            if (valor != '') {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: url,
                    data: {valor: valor, id_factura: id_factura, atributo:atributo},
                    success: function (data) {
                        //  console.log(data);
                        if (data.status == "1") {
                            console.log('Guardo perfectamente');
                        } else {
                            console.log('No guardo '+ data.errores);
                        }
                    }
                });
            }
            //alert(id_factura);
        });
        $('#Facturas_parametro').change(function () {
            ocultarYMostrar();
        });
        function ocultarYMostrar() {
            var parametro = $('#Facturas_parametro').val();
            if (parametro == 1) {
                $('#Facturas_fecha_proceso').attr('readonly', true);
                $('#Facturas_fecha_proceso').val($('#fecha_hoy').val());

            }
            else {
                $('#Facturas_fecha_proceso').attr('readonly', false);
            }
        }
        $(".centroAutocomplete").autocomplete({
            source: <?php
echo CJSON::encode(array_map(function($key, $value) {
            $algo = explode(' - ', $value);
            return array('label' => $value, 'value' => $algo[0]);
        }, array_keys(Facturas::model()->getCentroCosto()), Facturas::model()->getCentroCosto()));
?>,
            select: function (event, ui) {
                var selector = this;
                var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/validarCentro") ?>';
                var valor = ui.item.value;
                var id_tipificadas_facturas = $(this).attr('data_fra');
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: url,
                    data: {valor: valor, id_tipificadas_facturas: id_tipificadas_facturas},
                    success: function (data) {
                        //  console.log(data);
                        if (data.status == "1") {
                            autoGuardar(selector, ui.item.value);
                        } else {
                            alert("Este centro de costos debe ser diferente a los seleccionados en el mismo consecutivo");
                            $(selector).val('');
                        }
                    }
                });
            },
            response: function (event, ui) {
                console.log('HL close');
            }

        }).focus(function () {
            if ($(this).val() == '') {
                var selector = this;
                var valor = '<?php echo Facturas::model()->findByPk($factura)->centroCostos[0]->idCentroCostos->codigo; ?>';
                var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/validarCentro") ?>';
                var id_tipificadas_facturas = $(this).attr('data_fra');
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: url,
                    data: {valor: valor, id_tipificadas_facturas: id_tipificadas_facturas},
                    success: function (data) {
                        //  console.log(data);
                        if (data.status == "1") {
                            $(selector).val(valor);
                            autoGuardar(selector, valor);
                        }
                    }
                });
            }
        });
        $('.valor_tipi').blur(function () {
            autoGuardar(this, '');
        });
        function autoGuardar(selector, valor) {
            if (valor == '')
                valor = selector.value;
            var id_tipificadas_facturas = $(selector).attr('data_fra');
            var atributo = $(selector).attr('data_atrib');
            if (atributo == 'valor' && valor * 1 == 0)
                valor = '';
            var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/guardarValor") ?>';

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: url,
                data: {valor: valor, id_tipificadas_facturas: id_tipificadas_facturas, atributo: atributo},
                success: function (data) {
                    //  console.log(data);
                    if (data.status == "1") {
                        //resetGridView("facturas-tipi-grid-detalle");
                    } else {
                        //alert("no guardo");
                    }
                }
            });
        }
    });
</script>
