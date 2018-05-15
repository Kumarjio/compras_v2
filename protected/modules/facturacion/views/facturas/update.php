<?php
$this->breadcrumbs=array(
  'Facturas'=>($ver <7)? array('admin') : array('adminOperaciones'),  
  'Actualizar',
);


$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Actualizar','url'=>array('update','id'=>$model->id_factura),'icon'=>'edit'),
  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_factura),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

//print_r(Yii::app()->user->getState('permisos'));
?>

<div class="subnav">
  <div class="subnav-inner">
    <ul class="nav nav-pills">
      <li><a onclick="<?php 

          echo CHtml::ajax(
                    array(
                      'type' => 'get',
                      'data' => array('model' => 'Facturas', 'id' => $model->id_factura),
                      'url' => $this->createUrl("/trazabilidadWfs/index"),
                      'success' => 'function(data){
                          clean_response(\'Trazabilidad\', data);

                      }'
                    )
                );

       ?>">Trazabilidad</a></li>
      <li><a onclick="<?php 

          echo CHtml::ajax(
                    array(
                      'type' => 'get',
                      'data' => array('model' => 'Facturas', 'id' => $model->id_factura),
                      'url' => $this->createUrl("/observacionesWfs/index"),
                      'success' => 'function(data){
                          clean_response(\'Observaciones\', data); 
                      }'
                    )
                );

       ?>">Observaciones <?php if($model->observacionesCount[0]): ?><span class="badge badge-important"><?php echo $model->observacionesCount[0]; ?></span><?php endif ?></a></li>
       
    </ul>
  </div>
 </div>

<?php echo $this->renderPartial($vista,array('model'=>$model,
                        'readonly'=>$readonly,
                        'ordenes'=>$ordenes,
                        'cuentas'=>$cuentas,
                        'alertas_nit'=>$alertas_nit,
                        'ver'=>$ver,
                        'actualizado'=>$actualizado
        )); ?>

      <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModalAjax','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>&nbsp;</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      Cargando...
 
  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('register_static_css_js', "                                                                               
$(function() {                                                                                                                                         
     script_files = $('script[src]').map(function() { return $(this).attr('src'); }).get();                                                                                                                                          
     css_files = $('link[href]').map(function() { return $(this).attr('href'); }).get();                                                                                                                                          
});"); ?>

<?php Yii::app()->clientScript->registerScript('no_scripts_ajax_callback', "                                                                               



window.clean_response = function (titulo, data) {

            var reply = $(data);                                                                                                                
            var target = $('#myModalAjax .modal-body');
            target.html('');                                                                                                                            
            target.append(reply.filter('script[src]').filter(function() {
                if ($.inArray($(this).attr('src'), script_files) === -1) {
                    script_files.push($(this).attr('src'));
                    return true;
                }
                return false;
            }));        
            target.append(reply.filter('link[href]').filter(function() {
                if ($.inArray($(this).attr('href'), css_files) === -1) {
                    css_files.push($(this).attr('href'));
                    return true;
                }
                return false;
            }));     

            var content = reply.find('#content');
            var target_dir = reply.find('div')[1];
            var id = $(target_dir).attr('id');
           
            target.append(content);                                                                                                      
            target.append(reply.filter('script:not([src])'));
            $('#myModalAjax .modal-header h3').html(titulo);
            $('#myModalAjax').modal();
}

window.clean_response_generic = function (target_sel, data, prepend_or_replace) {
            var reply = $(data);                                                                                                                
            var target = $(target_sel);
            var old_content = target.html();
      //target.html(''); 
            target.append(reply.filter('script[src]').filter(function() {
                if ($.inArray($(this).attr('src'), script_files) === -1) {
                    script_files.push($(this).attr('src'));
                    return true;
                }
                return false;
            }));        
            target.append(reply.filter('link[href]').filter(function() {
                if ($.inArray($(this).attr('href'), css_files) === -1) {
                    css_files.push($(this).attr('href'));
                    return true;
                }
                return false;
            }));     
      
            var content = reply.find('#real_content');
          if(prepend_or_replace == 'append'){
        //target.prepend(old_content);
              target.append(content.html()); 
            }else{
        target.replaceWith(content.html());
        if(content.find('div.alert-error').size() != 0){
        }
      }                                          
            target.append(reply.filter('script:not([src])'));
            
}

"); ?>

<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModalOrden', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar Orden de Compra</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      
  <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'ordenes-compra-grid',
    'dataProvider'=>  $ordenes->search(),
    'type'=>'striped bordered condensed',
    'filter'=>$ordenes,
  'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'columns'=>array(
      'id_orden',
      'nit',  
      'dato',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{select}',
        'buttons'=>array
                  (
                    'select' => array
                        (
                          'label' => "<i class='icon-ok'></i>", 
                          'url' => 'Yii::app()->createUrl("facturacion/facturas/addOrden", array("id_factura"=>'.$model->id_factura.', "id_orden" => $data->id_orden))',
                          'options'=>array(
                             'title' => 'Seleccionar',  
                              'class'=> 'adiccionar-orden',
                             "onClick"  => '(function(e, obj){ 
                                $("#myModalOrden").modal("hide");
                              })(event, this)', 
//                            'onClick'=> 'jQuery.ajax({\'url\':\'$(this).attr("href")\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
//                                    alert(\'se va\');
//                                    if(data.status == \'success\'){
//                                            $(\'#myModalOrden\').modal(\'hide\');
//                                            resetGridView("proveedores-grid");
//                                    }else{
//                                        alert(\'algo paso\');
//                                    }
//                            },\'cache\':false});return false;'                               
                          ),
                        ),
                  ),
      ),
    ),
  )); ?>

  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("cuenta-contable-grid");$("#myModal2").modal("hide");$("#crearCostosModal").modal();'),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>
<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModalContable', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar Cuenta Contable</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      
  <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'cuenta-contable-grid',
    'dataProvider'=>  $cuentas->search_facturacion(),
    'type'=>'striped bordered condensed',
    'filter'=>$cuentas,
  'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'columns'=>array(
        'id',
      'codigo',
      'nombre',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{select}',
        'buttons'=>array
                  (
                    'select' => array
                        (
                          'label' => "<i class='icon-ok'></i>", 
                          'url' => 'Yii::app()->createUrl("facturacion/facturas/addCuenta", array("id_factura"=>'.$model->id_factura.', "id_cuenta" => $data->id))',
                          'options'=>array(
                             'title' => 'Seleccionar',  
                              'class'=> 'adiccionar-contable',
                             "onClick"  => '(function(e, obj){ 
                                $("#myModalContable").modal("hide");
                              })(event, this)', 
//                            'onClick'=> 'jQuery.ajax({\'url\':\'$(this).attr("href")\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
//                                    if(data.status == \'success\'){
//                                            $(\'#myModalOrden\').modal(\'hide\');
//                                            resetGridView("proveedores-grid");
//                                    }else{
//                                        alert(\'algo paso\');
//                                    }
//                            },\'cache\':false});return false;'                               
                          ),
                        ),
                  ),
      ),
    ),
  )); ?>

  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("contable-factura-grid");$("#myModal2").modal("hide");'),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>
<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModalCostos', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
<div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar Centro de Costos</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      
  <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'costos-factura-grid',
    'dataProvider'=>  $centros->search(),
    'type'=>'striped bordered condensed',
    'filter'=>$centros,
  'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'columns'=>array(
      'codigo',
      'nombre',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{select}',
        'buttons'=>array
                  (
                    'select' => array
                        (
                          'label' => "<i class='icon-ok'></i>", 
                          'url' => 'Yii::app()->createUrl("facturacion/facturas/addCostos", array("id_factura"=>'.$model->id_factura.', "id" => $data->id))',
                          'options'=>array(
                             'title' => 'Seleccionar',  
                              'class'=> 'adiccionar-centro-costos',
                             "onClick"  => '(function(e, obj){ 
                                $("#myModalCostos").modal("hide");
                              })(event, this)', 
//                            'onClick'=> 'jQuery.ajax({\'url\':\'$(this).attr("href")\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
//                                    if(data.status == \'success\'){
//                                            $(\'#myModalOrden\').modal(\'hide\');
//                                            resetGridView("proveedores-grid");
//                                    }else{
//                                        alert(\'algo paso\');
//                                    }
//                            },\'cache\':false});return false;'                               
                          ),
                        ),
                  ),
      ),
    ),
  )); ?>

  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("centro-costos-factura-grid");$("#myModal2").modal("hide");'),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>


<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModalModificarTipi', 'htmlOptions' => array('class' => 'hide','style'=>'width: 1200px; margin: -250px 0 0 -600px;', 'data-backdrop' => 'static'))); ?>

<div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Diligencie la linea que desea agregar</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      <div class="row">
        <div class="span4">
                <?php echo CHtml::hiddenField("id_lista");?>
                <?php                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                            $this->widget('bootstrap.widgets.BootGridView',array(
                              'id'=>'contable-factura-grid5',
                              'dataProvider'=> TipificadasFacturas::model()->search($model->id_factura),
                              'type'=>'striped bordered condensed',
                            'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                              'columns'=>array(
                                  'cuenta', 
                                    array(
                                          'name' => 'descripcion_tipificada',
                                          'type' => 'raw',
                                          'value' => 'CHtml::ajaxLink($data->descripcion_tipificada,
                                                        Yii::app()->createUrl("facturacion/facturas/traerDetalleTipi", 
                                                        array("cuenta"=>$data->cuenta, "tipificada"=>$data->codigo_tipificada, "factura"=>$data->id_factura,"descripcion"=>$data->descripcion_tipificada)), 
                                                        array(
                                                            "update"=>"#valores_tipi2",
                                                        ),array(
                                                            "onclick"=>"$(\"#id_lista\").val($(this).attr(\"id\"));"
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
                            )); ?>
            
                <div class="form-actions">
                        <?php $this->widget('bootstrap.widgets.BootButton', array(
                                'buttonType'=>'submit',
                                'type'=>'primary',
                                'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
                        )); ?>
                </div>
                </div>   
                <div class="span7" id="valores_tipi2">
                    
                </div>
      </div>
  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => '$("#myModalModificarTipi").modal("hide");location.reload();'),
      )); ?>
  </div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
 $(document).ready(function() {
    var analista_enca = '<?php echo Empleados::model()->findByPk($model->analista_encargado)->nombre_completo ?>';
    if(analista_enca != '')
      $('#nombre_analista').val(analista_enca);     
    $.ajaxSetup({ cache:false });
    $('#Facturas_rte_fte').change(function(){
        var porc = this.value;
        var valor = '<?php echo $model->valor_productos ?>';
        $('#Facturas_valor_rte_fte').val(porc * valor);
//        $('#Facturas_valor_rte_fte').val($('#Facturas_valor_rte_fte').val().replace(".",","));
//        $('#Facturas_valor_rte_fte').maskMoney('mask',$('#Facturas_valor_rte_fte').val());
    });
    $('#myModalOrden, #myModalModificarTipi, #myModalContable, #myModalCostos, #myModalAjax').on('hide.bs.modal', function (e) {
        $("#divCont").show();
    });
    $('#myModalOrden, #myModalModificarTipi, #myModalContable, #myModalCostos, #myModalAjax').on('show.bs.modal', function (e) {
        $("#divCont").hide();
    });     
    $('.numero').keypress(function(e){
        var tecla = document.all ? tecla = e.keyCode : tecla = e.which;
        
        if((tecla >= 48 && tecla <= 57) || tecla==8 || tecla==0){
                return true
        }else{
                return false;
        }     
    });
    $('.maskValor').maskMoney({decimal:'.',precision:0, allowZero:true});
    $('#name_proveedor').focus(function(){
        var nit = $('#nit_proveedor').val();
        $.ajax({
            type: 'post',
            dataType : 'json',
            url : '<?php echo $this->createUrl('/proveedor/getRazonSocial'); ?>',
            data : {nit : nit},
            success : function(data){ 
              if(data.status == "error"){
                $("#name_proveedor").val('').attr('readonly',false);

              }
            }
          });
    }); 
    $(".adiccionar-orden").live("click", function(e){
        e.preventDefault();
        addOrden($(this).attr("href"));
    });
    function addOrden(url)
    {
    jQuery.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
        {
            if(data.status == 'success'){
                $('#myModalProv').modal('hide');
                resetGridView("ordenes-factura-grid");
                resetGridView("contable-factura-grid");
                resetGridView("centro-costos-factura-grid");
                if($('#Facturas_id_centro_costos').val() == ''){
                    $('#Facturas_id_centro_costos').val(data.centro);
                    $('#name_centro_costos').val(data.nombre_centro);
                }
//                resetGridView("proveedores-seleccion-grid");
            }

        } ,'cache':false});
    
    return false;  
    }
    $(".adiccionar-contable").live("click", function(e){
        e.preventDefault();
        addContable($(this).attr("href"));
    });
    function addContable(url)
    {
    jQuery.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
        {
            if(data.status == 'success'){
                $('#myModalContable').modal('hide');
                resetGridView("contable-factura-grid");
                resetGridView("contable-factura-grid2");
                resetGridView("cuenta-contable-grid");
            }

        } ,'cache':false});
    
    return false;  
    }
    $(".adiccionar-centro-costos").live("click", function(e){
        e.preventDefault();
        addCostos($(this).attr("href"));
    });
    function addCostos(url)
    {
    jQuery.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
        {
            if(data.status == 'success'){
                $('#myModalCostos').modal('hide');
                $('#centro-costos-factura-grid').yiiGridView.update("centro-costos-factura-grid");
                //$('#btn_costos').addClass('hide');
            }

        } ,'cache':false});
    
    return false;  
    }
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
        var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/guardarValorCentro") ?>'; 
        
        var xhr =null;
        xhr = $.ajax({
            type: 'post',
            dataType : 'json',
            url : url,
            data : { valor : valor, id_centro_costos_factura : id_centro_costos_factura, atributo: atributo },
            success : function(data){
            //  console.log(data);
               if(data.status == "1"){
                   //resetGridView("facturas-tipi-grid-detalle");
               }else{
                   //alert("no guardo");
               }
            },
            cache: false
        });
    }
    
});
</script>