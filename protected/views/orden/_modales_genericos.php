<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalNuevaDireccion')); ?>


  <div class="modal-header">
		      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Agregar Dirección</h3> 
  </div>

  <div id="modal-content" class="modal-body">

  </div>
  <div class="modal-footer">
		      <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
  		      'url'=>'#',
  		      'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_cotizacion", 
  		      	'onClick' => '$("#modalNuevaDireccion").modal("hide");$("#modalNuevoProducto").modal("show"); '//resetGridView("centro-costos-grid"); 
  		      ),
	      	)); ?>
  </div>


<?php $this->endWidget(); ?>


<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalAgregarProveedor')); ?>


  <div class="modal-header">
      <h3>Agregar Proveedor Recomendado</h3> 
  </div>

  <div id="modal-content" class="modal-body scrollmovil">

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_proveedor", 
              'onClick' => '$("#modalAgregarProveedor").modal("hide");$("#modalNuevoProducto").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>


<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalAgregarCentro')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Asignar centro de costos / cuenta contable</h3> 
  </div>

  <div id="modal-content" class="modal-body">

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('id' => "cerrar_modal_proveedor", 
              'onClick' => '$("#modalAgregarCentro").modal("hide");$("#modalNuevoProducto").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalSeleccionarCentro')); ?>


  <div class="modal-header">
      <h3>Seleccionar centro de costos</h3> 
  </div>

  <div class="modal-body">

 <?php

  $this->widget('booster.widgets.TbGridView',array(
             'id'=>'centro-costos-grid',
             'dataProvider'=>$centro_costos_model->search(),
             'type'=>'striped bordered condensed',
             'filter'=>$centro_costos_model,
             'columns'=>array(
                  'codigo',
                  'nombre',
                  //array('name'=>'nombre_jefatura_search', 'value'=>'$data->jefatura->nombre', 'header'=>'Jefatura'),
                  array(
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                    'template' => '{select}',
                    'buttons'=>array(
                        'select' => array(
                          'label'=>'Seleccionar',
                          'url'=>'"#".$data->id."#".$data->nombre',
                          'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok4.png',
                          'options'=>array(
                             'title' => 'Seleccionar',    
                             "onClick"  => '(function(e, obj){
                                    var arr = $(obj).parent().find("a").attr("href").split("#");
                                    $("#OrdenSolicitudCostos_id_centro_costos").val(arr[1]);
                                    $("#OrdenSolicitudCostos_nombre_centro").val(arr[2]);
                                    //resetGridView("centro-costos-grid");
                                    $("#modalSeleccionarCentro").modal("hide");
                                    $("#modalAgregarCentro").modal();
                                  })(event, this)',                                

                          ), 
  
                        ),
                    ),
                  ),
              ),
  ));

?>
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal','id' => "cerrar_modal_centro", 
              'onClick' => '$("#modalSeleccionarCentro").modal("hide");$("#modalAgregarCentro").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalSeleccionarCuenta')); ?>


  <div class="modal-header">
      <h3>Seleccionar cuenta contable</h3> 
  </div>

  <div class="modal-body">
       <?php 


  $this->widget('booster.widgets.TbGridView',array(
    'id'=>'cuenta-contable-grid',
    'dataProvider'=>$cuenta_contable_model->search(),
    'type'=>'striped bordered condensed',
    'filter'=>$cuenta_contable_model,
  //'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'columns'=>array(
      'codigo',
      'nombre',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{select}',
        'buttons'=>array(
            'select' => array(
                  'label'=>'Seleccionar',
                  'url'=>'"#".$data->id."#".$data->nombre',
                  'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok4.png',
                  'options'=>array(
                     'title' => 'Seleccionar',    
                     "onClick"  => '(function(e, obj){ 
                        var arr = $(obj).parent().find("a").attr("href").split("#");
                        $("#OrdenSolicitudCostos_id_cuenta_contable").val(arr[1]);  
                        $("#OrdenSolicitudCostos_nombre_cuenta").val(arr[2]);
                        //resetGridView("cuenta-contable-grid");
                        $("#modalSeleccionarCuenta").modal("hide");
                        $("#modalAgregarCentro").modal("show");
                      })(event, this)',                                

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
            'htmlOptions'=>array('id' => "cerrar_modal_agregar_pagos", 
              'onClick' => '$("#modalSeleccionarCuenta").modal("hide");$("#modalAgregarCentro").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalSeleccionarCentroOP')); ?>


  <div class="modal-header">
      <h3>Seleccionar centro de costos</h3> 
  </div>

  <div class="modal-body">

 <?php

  $this->widget('booster.widgets.TbGridView',array(
             'id'=>'centro-costos-grid-op',
             'dataProvider'=>$centro_costos_model->search(),
             'type'=>'striped bordered condensed',
             'filter'=>$centro_costos_model,
             'columns'=>array(
                  'codigo',
                  'nombre',
                  //array('name'=>'nombre_jefatura_search', 'value'=>'$data->jefatura->nombre', 'header'=>'Jefatura'),
                  array(
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                    'template' => '{select}',
                    'buttons'=>array(
                        'select' => array(
                          'label'=>'Seleccionar',
                          'url'=>'"#".$data->id."#".$data->nombre',
                          'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok4.png',
                          'options'=>array(
                             'title' => 'Seleccionar',    
                             "onClick"  => '(function(e, obj){
                                    var arr = $(obj).parent().find("a").attr("href").split("#");
                                    $("#OrdenProducto_id_centro_costos").val(arr[1]);
                                    $("#OrdenProducto_nombre_centro").val(arr[2]);
                                    //resetGridView("centro-costos-grid");
                                    $("#modalSeleccionarCentroOP").modal("hide");
                                    $("#orden_pedido").modal();
                                  })(event, this)',                                

                          ), 
  
                        ),
                    ),
                  ),
              ),
  ));

?>
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal','id' => "cerrar_modal_centro", 
              'onClick' => '$("#modalSeleccionarCentroOP").modal("hide");$("#orden_pedido").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalSeleccionarCuentaOP')); ?>


  <div class="modal-header">
      <h3>Seleccionar cuenta contable</h3> 
  </div>

  <div class="modal-body">
       <?php 


  $this->widget('booster.widgets.TbGridView',array(
    'id'=>'cuenta-contable-grid-op',
    'dataProvider'=>$cuenta_contable_model->search(),
    'type'=>'striped bordered condensed',
    'filter'=>$cuenta_contable_model,
  //'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'columns'=>array(
      'codigo',
      'nombre',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{select}',
        'buttons'=>array(
            'select' => array(
                  'label'=>'Seleccionar',
                  'url'=>'"#".$data->id."#".$data->nombre',
                  'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok4.png',
                  'options'=>array(
                     'title' => 'Seleccionar',    
                     "onClick"  => '(function(e, obj){ 
                        var arr = $(obj).parent().find("a").attr("href").split("#");
                        $("#OrdenProducto_id_cuenta_contable").val(arr[1]);  
                        $("#OrdenProducto_nombre_cuenta").val(arr[2]);
                        //resetGridView("cuenta-contable-grid");
                        $("#modalSeleccionarCuentaOP").modal("hide");
                        $("#orden_pedido").modal("show");
                      })(event, this)',                                

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
            'htmlOptions'=>array('id' => "cerrar_modal_agregar_pagos", 
              'onClick' => '$("#modalSeleccionarCuentaOP").modal("hide");$("#orden_pedido").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>



<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'reemplazoOrden')); ?>
  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Agregar orden a reemplazar</h3>
  </div>
  <div id="modal-content" class="modal-body">
      
  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal'),
      )); ?>
  </div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'genericModal','htmlOptions' => array('data-backdrop' => 'static'))); ?>


  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>Adjuntos</h3> 
  </div>

  <div id="modal-content" class="modal-body">
      
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_generic"),
          )); ?>
  </div>


<?php $this->endWidget(); ?>


<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'orden_pedido', 'large'=>true)
); ?>
 
    <div class="modal-header" id="op-modal-header">
        <!--a class="close" data-dismiss="modal">&times;</a-->
        <h4>Solicitud de productos </h4>
    </div>
 
    <div class="modal-body" id="body_orden_pedido">
        <p>One fine body...</p>
      
    </div>
 
 
<?php $this->endWidget(); ?><?php $this->beginWidget(
  'booster.widgets.TbModal', 
  array(
    'id'=>'modalProductos',
    'large'=>true,
    'htmlOptions' => array(
        //'class' => 'bd-example-modal-lg',
    ),
    
  )); ?>

<?php 

$criteria = new CDbCriteria;
if($productos->id_categoria != "")
  $criteria->compare('id_categoria',$productos->id_categoria);
$criteria->order = 'nombre';
?>

  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar productos</h3> 
  </div>

  <div id="modal-content" class="modal-body">

 <?php
  $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Nuevo Producto',
        'context' => 'warning',
        'id'=>'btn_crear_producto_tabla',
        'url'=>$this->createUrl("producto/createAjax"),
        'htmlOptions' => array(
            'href'=>$this->createUrl("producto/createAjax"),
        ),
    )
);
   $this->widget('booster.widgets.TbGridView',array(
    'id'=>'productos-om-grid',
    'dataProvider'=>$productos->search_presupuesto(),
    //'template' => "{items}",
    'filter' => $productos,
    'type' => 'striped bordered condensed',
    'responsiveTable' => true,
    'columns'=>array(
        //'id_categoria',
        //'categoria',
        array(
            'name'=>'id_categoria',
            'filter'=>CHtml::activeDropDownList($productos, 'id_categoria', CHtml::listData(Categorias::model()->findAll(), 'id', 'nombre'), array('class'=>'form-control', 'prompt'=>''
          )),
          'value'=>'$data->familia->idCategoria->nombre'

        ),
        array(
          'name'=>'id_familia',
          'header'=>'SubCategoria',
          'filter'=>CHtml::activeDropDownList($productos, 'id_familia', CHtml::listData(FamiliaProducto::model()->findAll($criteria), 'id', 'nombre'), array('class'=>'form-control', 'prompt'=>'')),
          'value'=>'$data->familia->nombre'
        ),
        'nombre',
        
        array(
          'header'=>'Agregar',
          'class'=>'booster.widgets.TbButtonColumn',
          'template'=>'{gestion} ',
          'buttons' => array(
              'gestion' => array(
                  'label'=>'Seleccionar',
                  //'url'=>'CJSON::encode($data)',
                  'url'=>'"#".$data->id."#".$data->nombre',
                  //'icon'=>'glyphicon glyphicon-ok',
                  'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok4.png',
                  //'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario',
                  //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
                  'options'=>array(
                     'title' => 'Seleccionar',    
                     "onClick"  => '(function(e, obj){ 
                        var arr = $(obj).parent().find("a").attr("href").split("#");
                        $("#OrdenSolicitud_id_producto").val(arr[1]);  
                        $("#OrdenSolicitud_nombre_producto").val(arr[2]);
                        //resetGridView("cuenta-contable-grid");
                        $("#modalProductos").modal("hide");
                        $("#modalNuevoProducto").modal("show");
                      })(event, this)',                                

                  ),
              ),
          )
        ),  
    ),
  )); 

?>
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
  'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('id' => "cerrar_modal", 
            'onClick' => '$("#modalProductos").modal("hide");$("#modalNuevoProducto").modal("show");'
          ),
          )); ?>
  </div>


      <?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalCotizacion')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Cotización</h3> 
  </div>

  <div id="modal-content" class="modal-body">

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_cotizacion", 
              //'onClick' => 'resetGridView("centro-costos-grid"); $("#myModal").modal("hide");$("#crearCostosModal").modal();'
            ),
          )); ?>
  </div>

<?php $this->endWidget(); ?>


<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalContacto')); ?>


  <div class="modal-header">
      <h3>Crear Contacto</h3> 
  </div>

  <div id="modal-content" class="modal-body scrollmovil">

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_contacto", 
              'onClick' => '$("#modalContacto").modal("hide");$("#modalCotizacion").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>      


<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalProveedores')); ?>

  <div class="modal-header">
      <h3>Seleccionar Proveedor</h3>
  </div>

  <div id="modal-content" class="modal-body">

 <?php


$this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Agregar Nuevo Proveedor',
        'context' => 'info',
        'url'=>$this->createUrl('proveedor/createAjax'),
        'htmlOptions' => array(
            'href'=>$this->createUrl('proveedor/createAjax'),
            'id'=>'btn_crear_pro'
        ),
    )
);


 $this->widget('booster.widgets.TbGridView',array(
      'id'=>'proveedor-om-grid',
      'type'=>'striped bordered condensed',
      'dataProvider'=>$proveedores->search_2(),
      'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
      'filter'=>$proveedores,
      'rowCssClassExpression' => '($data->bloqueado == 1)?"proveedor_bloqueado":""',
      'pager'=>array(
              'class'=>'bootstrap.widgets.BootPager',
              'displayFirstAndLast'=>true,
      ),
      'columns'=>array(
      'nit',
      'razon_social',
      array(
          'class'=>'booster.widgets.TbButtonColumn',
          'template' => '{select}',
          'buttons'=>array
              (
                'select' => array
                (
                  'url' => '"#".$data->nit."#".$data->razon_social',
                  'label' => false,
                  'icon'=>'ok',
                  'options'=>array(
                      //'title' => 'seleccionar este proveedor', 
                      'onClick' => "
                          $('#modalProveedores').modal('hide');; 
                          setProveedor(this); 
                          resetGridView('proveedor-om-grid'); 
                          jQuery.ajax({'type':'post','dataType':'json','data':{'proveedor':$('#CotizacionOp_nit').val()},
                            'url':'".$this->createUrl('proveedor/contactos')."',
                            'success':function(data){
                              if(data.status == 'ok'){
                                $('#CotizacionOp_contacto').html(data.combo);
                                $('#crear_contacto').attr('href','".$this->createUrl('contactoProveedor/createContactoAjax')."?nit='+$('#CotizacionOp_nit').val());
                                //$('#crear_contacto_proveedor').slideDown();
                                $('#modalCotizacion').modal('show');
                              }else{
                                alert(data.mensaje);
                              }

                          },'cache':false});
                
                    "),
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
            'htmlOptions'=>array( 'id' => "cerrar_modal", 
              'onClick' => '$("#modalProveedores").modal("hide");$("#modalCotizacion").modal("show");'
            ),
          )); ?>
  </div>


      <?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalPagos')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Agregar Pagos y Seleccionar</h3> 
  </div>

  <div class="modal-body">

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal','id' => "cerrar_modal_pagos", 
              //'onClick' => '$("#modalNuevoProveedor").modal("hide");$("#modalProveedores").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'agregarPago')); ?>


  <div class="modal-header">
      <h3>Agregar Pagos y Seleccionar</h3> 
  </div>

  <div class="modal-body">
      
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('id' => "cerrar_modal_agregar_pagos", 
              'onClick' => '$("#agregarPago").modal("hide");$("#modalPagos").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'elegirCotizacion')); ?>


  <div class="modal-header">
      <h3>Elegir Cotización</h3> 
  </div>

  <div class="modal-body">
      
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_elegir_cotizacion"),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalNuevoProveedor')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Crear Proveedor</h3> 
  </div>

  <div id="modal-content" class="modal-body">

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('id' => "cerrar_modal_proveedor", 
              'onClick' => '$("#modalNuevoProveedor").modal("hide");$("#modalProveedores").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalTraza')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Trazabilidad</h3> 
  </div>

  <div id="modal-content" class="modal-body">
    <?php 
      $this->widget('booster.widgets.TbGridView',array(
        'id'=>'trazabilidad-grid',
        'dataProvider'=>$traza->search_2('Orden', $id_model),
        'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
        'type'=>'striped bordered condensed',
        'columns'=>array(
          'usuario_anterior',
          'usuario_nuevo',
          array(
              'name'=>'estado_anterior',
                  'value'=>'Orden::model()->labalEstado($data->estado_anterior)'
          ),
          array(
              'name'=>'estado_nuevo',
                  'value'=>'Orden::model()->labalEstado($data->estado_nuevo)'
          ),
          
          'fecha'  
        )
    )); ?>
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_cotizacion", 
              'onClick' => '$("#modalTraza").modal("hide"); '//resetGridView("centro-costos-grid"); 
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>  

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalObservaciones')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Observaciones</h3> 
  </div>
  <div id="modal-content" class="modal-body">
    <?php 
      $this->widget('booster.widgets.TbGridView',array(
        'id'=>'activerecord_grid',
        'dataProvider'=>$activerecord->search_2('Orden', $id_model),
        'type'=>'striped bordered condensed',
        'columns'=>array(
          'action',
          'iduser',
          'field',
          'username',
          'description',
          'description_new',
          'fecha',
        )
      )); ?>

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_cotizacion", 
              'onClick' => '$("#modalTraza").modal("hide"); '//resetGridView("centro-costos-grid"); 
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>
