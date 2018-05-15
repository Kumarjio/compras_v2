<?php
$this->breadcrumbs=array(
	'Crear',
);

if($model->paso_wf == 'swOrden/analista_compras'){
  echo '<div class="row">';
    echo '<div class="col-md-2">';
    $this->widget(
        'booster.widgets.TbButtonGroup',
        array(    
            'size' => 'large',
            'buttons' => array(array(
              'label'=>'Acciones',
              'items'=>
                array(
                  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
                  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
                  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
                array('label'=>'Delegar Solicitud','url'=>array('delegar', 'id' => $model->id),'icon'=>'hand-right'),
                ),  
              )
          )
        )
    );
}else{
  echo '<div class="row">';
    echo '<div class="col-md-2">';
    $this->widget(
        'booster.widgets.TbButtonGroup',
        array(    
            'size' => 'large',
            'buttons' => array(array(
              'label'=>'Acciones',
              'items'=>
                array(
                  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
                  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
                  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','visible'=> $model->paso_wf == "swOrden/llenaroc",'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
                  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
                  array('label'=>'Trazabilidad','url'=>'#', 'linkOptions'=>array('class'=>'traza')),
                  array('label'=>'Observaciones','url'=>'#', 'linkOptions'=>array('class'=>'observaciones')),
                ),  
              )
          )
        )
    );
}

    echo '</div>';
echo '</div>';
?>

<?php 
if($paso_actual == "swOrden/analista_compras"){
  echo $this->renderPartial('_form_steps_analista_compras',array('model'=>$model, 
      'paso_actual' => $paso_actual, 
      'observaciones' => $observacion_model,
      'reemplazos' => $reemplazos,
      'productos' => $productos,
      'Mgrid' => $Mgrid,
      'orden_solicitud' =>$orden_solicitud
  ));
}
elseif($paso_actual == "swOrden/en_negociacion"){
  echo $this->renderPartial('_form_steps_negociacion',array('model'=>$model, 
      'paso_actual' => $paso_actual, 
      'observaciones' => $observacion_model,
      'reemplazos' => $reemplazos,
      'productos' => $productos,
      'orden_producto' => $orden_producto,
      'orden_solicitud' =>$orden_solicitud
  ));
}
elseif($paso_actual == "swOrden/validacion_cotizaciones" || $paso_actual == "swOrden/gerente_compra" || $paso_actual == "swOrden/vicepresidente_compra"){
  echo $this->renderPartial('_form_steps_area',array('model'=>$model, 
      'paso_actual' => $paso_actual, 
      'observaciones' => $observacion_model,
      'reemplazos' => $reemplazos,
      'productos' => $productos,
      'orden_producto' => $orden_producto,
      'orden_solicitud' =>$orden_solicitud
  ));
}
else{
  echo $this->renderPartial('_form_steps',array('model'=>$model, 
      'paso_actual' => $paso_actual, 
      'observaciones' => $observacion_model,
      'reemplazos' => $reemplazos,
      'productos' => $productos,
      'Mgrid' => $Mgrid,
      'orden_solicitud' =>$orden_solicitud
  ));
}
   
?>

<?php echo $this->renderPartial('_nuevo_producto',array()); ?>

<?php echo $this->renderPartial('_modales_genericos', array('centro_costos_model' => $centro_costos_model,'cuenta_contable_model' => $cuenta_contable_model,'productos'=>$productos, 'proveedores'=>$proveedor_model, 'traza'=>$traza, 'id_model'=>$model->id, 'activerecord'=>$activerecord)); ?>


<script type="text/javascript">
  
  $("#btn_crear_producto").live("click", function(e){
    if(!confirm("¿Creará un nuevo registro de producto desea continuar?")) return false;
    e.preventDefault();
    App.nuevoProducto(this , "modalNuevoProducto");

  });
  
    $(".traza").on("click", function(e){
    $("#modalTraza").modal("show");

  });


  $(".traza").live("click", function(e){
    $("#modalTraza").modal("show");

  });
  
  $(".observaciones").live("click", function(e){
    $("#modalObservaciones").modal("show");

  });

  $("#btn_crear_producto_tabla").live("click", function(e){
    e.preventDefault();
    $("#modalProductos").modal("hide");
    App.nuevoProductoTabla(this , "modalNuevoProductoTabla");

  });

  $('.grid-solicitud-orden').find(".update").live("click", function(e){
    e.preventDefault();
    App.nuevoProducto(this , "modalNuevoProducto");

  });

  $("#btn_crear_pro").live("click", function(e){
    e.preventDefault();
    $("#modalProveedores").modal("hide");
    App.crearProveedor(this , "modalNuevoProveedor");

  });

  /*$("#btn_guardar_solicitud").live("click", function(e){
    e.preventDefault();
    alert('salir');
    return false;
    //var serialized = form.serialize(); 
    //doReqData(form.attr("action"), serialized, postFun);

  });*/

  $("#btn_crear_direccion").live("click", function(e){
    e.preventDefault();
    $("#modalNuevoProducto").modal("hide");
    App.crearDireccion(this , "modalNuevaDireccion");

  });

  $("#btn_agregar_orden").live("click", function(e){
    e.preventDefault();
    App.agregarOrdenReeem(this , "reemplazoOrden");

  });
  

  $('.grid-direcc').find(".update").live("click", function(e){
    e.preventDefault();
    $("#modalNuevoProducto").modal("hide");
    App.crearDireccion(this , "modalNuevaDireccion");

  });

  $('.grid-direcc .delete, .grid-proveed .delete, .grid-costos .delete').live("click", function(e){
    e.preventDefault();
    //$("#modalNuevoProducto").modal("hide");
    if(!confirm('¿Seguro que quiere eliminar este item?')) {
      //$("#modalNuevoProducto").modal("show");
      return false;
    }
    var url = $(this).attr('href');
    $.ajax({
      url: url,
      dataType: 'json',
      type : 'post',
      success: function(data){
        if(data.status == 'success'){
          actualizarModalProductos(data.id_orden_solicitud);
        }else
          alert(data.error);
      },
      beforeSend: function(xhr){
        $("#modalNuevoProducto").modal("hide");
        //debugger;
      }
    });
    return false;
  });

  $("#btn_agregar_proveedor").live("click", function(e){
    e.preventDefault();
    $("#modalNuevoProducto").modal("hide");
    App.agregarProveedor(this , "modalAgregarProveedor");

  });

  $('.grid-proveed').find(".update").live("click", function(e){
    e.preventDefault();
    $("#modalNuevoProducto").modal("hide");
    App.agregarProveedor(this , "modalAgregarProveedor");

  });

  $("#btn_agregar_cc").live("click", function(e){
    e.preventDefault();
    $("#modalNuevoProducto").modal("hide");
    App.agregarProveedor(this , "modalAgregarCentro");

  });

  $('.select_producto').live("click", function(e){
    e.preventDefault();
    App.agregarProducto(this , "orden_pedido");

  });
  
  $('.detalle_producto').live("click", function(e){
    e.preventDefault();
    App.nuevoProducto(this , "modalNuevoProducto");

  });

  $("#btn_crear_cotizacion").live("click", function(e){
    e.preventDefault();
    App.crearCotizacion(this , "modalCotizacion");

  });

  $(".agregar-pago").live("click", function(e){
    e.preventDefault();
    $("#modalPagos").modal("hide");
    App.agregarPago(this , "agregarPago");

  });

  $('.grid-cot').find(".update").live("click", function(e){
    e.preventDefault();
    App.crearCotizacion(this , "modalCotizacion");

  });


  $("#crear_contacto").live("click", function(e){
    e.preventDefault();
    if($(this).attr('href') != "#"){
      $("#modalCotizacion").modal("hide");
      App.crearContactoOp(this , "modalContacto");
    }
    return false;  
  });


  $('.grid-pedido .delete').live("click", function(e){
    e.preventDefault();
    //$("#modalNuevoProducto").modal("hide");
    if(!confirm('¿Seguro que quiere eliminar este item?')) {
      //$("#modalNuevoProducto").modal("show");
      return false;
    }
    var url = $(this).attr('href');
    $.ajax({
      url: url,
      dataType: 'json',
      type : 'post',
      success: function(data){
        if(data.status == 'success'){
          $('#solpe_grid').yiiGridView.update('solpe_grid');
          $('#productos-creados-grid').yiiGridView.update('productos-creados-grid');
        }else
          alert(data.error);
      },
    });
    return false;
  });
  $('#ayuda_wf').live("click", function(e){
    e.preventDefault();
    alert("holollalala");
    return false;
  });
  $('.grid-solicitud-orden .delete').live("click", function(e){
    e.preventDefault();
    //$("#modalNuevoProducto").modal("hide");
    if(!confirm('¿Seguro que quiere eliminar este item?')) {
      //$("#modalNuevoProducto").modal("show");
      return false;
    }
    var url = $(this).attr('href');
    $.ajax({
      url: url,
      dataType: 'json',
      type : 'post',
      success: function(data){
        if(data.status == 'success'){
          $('#orden-solicitud-grid').yiiGridView.update('orden-solicitud-grid');
        }else
          alert(data.error);
      },
    });
    return false;
  });

  $('.grid-orden-reem .delete').live("click", function(e){
    e.preventDefault();
    //$("#modalNuevoProducto").modal("hide");
    if(!confirm('¿Seguro que quiere eliminar este item?')) {
      //$("#modalNuevoProducto").modal("show");
      return false;
    }
    var url = $(this).attr('href');
    $.ajax({
      url: url,
      dataType: 'json',
      type : 'post',
      success: function(data){
        if(data.status == 'success'){
          $('#orden-reemplazos-grid').yiiGridView.update('orden-reemplazos-grid');
        }else
          alert(data.error);
      },
    });
    return false;
  });

  $('.grid-proveed').find(".update").live("click", function(e){
    e.preventDefault();
    $("#modalNuevoProducto").modal("hide");
    App.agregarProveedor(this , "modalAgregarProveedor");

  });

  $("#OrdenSolicitudCostos_presupuestado").live("change", function(e){
      e.preventDefault();
      if($(this).val() == "Presupuestado"){
        $("#OrdenSolicitudCostos_mes_presupuestado").removeAttr("disabled");
      }
      else{
        $("#OrdenSolicitudCostos_mes_presupuestado").attr("disabled", "disabled");
      }

  });

  $('.grid-costos').find(".update").live("click", function(e){
    e.preventDefault();
    $("#modalNuevoProducto").modal("hide");
    App.agregarProveedor(this , "modalAgregarProveedor");

  });

  function selectCostos(e){
    $("#modalAgregarCentro").modal("hide");
    $("#modalSeleccionarCentro").modal("show");
    return false;
  }

  function selectCuenta(e){
    $("#modalAgregarCentro").modal("hide");
    $("#modalSeleccionarCuenta").modal("show");
    return false;
  }

  function selectCostosOP(e){
    $("#orden_pedido").modal("hide");
    $("#modalSeleccionarCentroOP").modal("show");
    return false;
  }

  function selectCuentaOP(e){
    $("#orden_pedido").modal("hide");
    $("#modalSeleccionarCuentaOP").modal("show");
    return false;
  }

  function selectProveedor(e){
    $("#modalCotizacion").modal("hide");
    $("#modalProveedores").modal("show");
    return false;
  }

  function setProveedor(event){
    var arr = event.href.split("#");
    var nit = arr[1];
    var razon_social = arr[2];
    $('#CotizacionOp_nit').val(nit);
    $('#CotizacionOp_nombre_proveedor').val(razon_social);
    $("#modalProveedores").modal('hide');
  }


  function actualizarPagos(id){

    var url = $(id).attr("href");
    var id = {id_cot:id};
    $.ajax({
      url: '<?php echo $this->createUrl("/orden/agregarPagosACotizacionOp") ?>',
      data: (id),
      dataType:'json',
      success: function(data){
        $("#modalPagos .modal-body").html(data.content);
        $("#modalPagos").modal("show");
      },
      error: function()
      {
        
      }
    });
    return false;
  }

  function actualizarModalProductos(id){

    var data = {id_orden_solicitud:id, actualizar_modal:true};
    $.ajax({
      url: '<?php echo $this->createUrl("orden/updateSolicitud") ?>',
      data: (data),
      dataType: 'json',
      success: function(data){
        $("#modalNuevoProducto .modal-body").html(data.content);
        $("#modalNuevoProducto").modal("show");
        var form = $("#modalNuevoProducto .modal-body").find("form");
        var button = form.find("button[type=submit]");
        button.click(function(e){
            var serialized = form.serialize(); 

            App.doReqData(form.attr("action"), serialized, function(post_data){
                App.okOnPostFijo(post_data, function(){
                    //$('#proveedor-om-grid').yiiGridView.update('proveedor-om-grid');
                    //$("#modalProveedores").modal("show");
                    //$('#itinerario-grid').yiiGridView.update('itinerario-grid');
                    //$('#gastos-viaje-grid').yiiGridView.update('gastos-viaje-grid');
                }, "modalNuevoProducto");
            });
        });
      },
    });
  }

 $("#orden_pedido, #modalSeleccionarCuentaOP, #modalSeleccionarCentroOP, #modalNuevoProducto, #modalAgregarProveedor, #modalNuevaDireccion, #modalNuevoProducto, #modalAgregarCentro, #modalSeleccionarCentro, #modalSeleccionarCuenta, #modalProveedores, #modalContacto, #modalCotizacion, #modalProductos, #modalNuevoProductoTabla, #modalNuevoProveedor, #agregarPago").bind('mousewheel DOMMouseScroll', function(e) {
    var scrollTo = null;

    if (e.type == 'mousewheel') {
        scrollTo = (e.originalEvent.wheelDelta * -1);
    }
    else if (e.type == 'DOMMouseScroll') {
        scrollTo = 40 * e.originalEvent.detail;
    }

    if (scrollTo) {
        e.preventDefault();
        $(this).scrollTop(scrollTo + $(this).scrollTop());
    }
});

</script>


<script type="text/javascript">
nueva_solicitud = false;
var me_puedo_ir = false;

function nuevoProveedor(dir)
{
  
    var url = "<?php echo $this->createUrl('/ordenproveedor/create', array('orden' => $_GET['id'])); ?>";
    
    jQuery.ajax({'url': url ,'type':'post','data' : $('#myModalAjax div.modal-body form').serialize(),'dataType':'json','success':function(data)
            {
                if (data.status == 'failure')
                {
                    $('#myModalAjax div.modal-body').html("");
                    $('#myModalAjax div.modal-body').html(data.div);
                    $('#myModalAjax div.modal-header h3').html("Agregar un proveedor");
                    $('#myModalAjax div.modal-body form').submit(nuevoProveedor);
                }
                else
                {
                    $('#orden-proveedor-grid').yiiGridView.update('orden-proveedor-grid');
                    $('#myModalAjax div.modal-body').html("");
                    $('#myModalAjax').modal('hide');
                }
 
            } ,'cache':false});
    
    return false;  
}

function updateProveedor(url)
{
    jQuery.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
            {
                if(data.status == 'success'){
					$('#proveedor-modal-content').html(data.content);
					$('#crearProveedorModal').modal('show');
				}
 
            } ,'cache':false});
    
    return false;  
}

function updateCostos(url)
{
    jQuery.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
            {
                if(data.status == 'success'){
					$('#costos-modal-content').html(data.content);
					$('#crearCostosModal').modal('show');
				}
 
            } ,'cache':false});
    
    return false;  
}

function updateDireccion(url)
{
    jQuery.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
            {
                if(data.status == 'success'){
					$('#direccion-modal-content').html(data.content);
					$('#crearDireccionModal').modal('show');
				}
 
            } ,'cache':false});
    
    return false;  
}

function actualizarNombre(id){
	var nombre = $('#collapse-'+id+' input[name="OrdenSolicitud[nombre]"]').val();
	if(nombre == ''){
		nombre = "Producto sin Nombre";
	}
	var cantidad = $('#collapse-'+id+' input[name="OrdenSolicitud[cantidad]"]').val();
	if(cantidad != ''){
		nombre = nombre + ' - ' + cantidad;
	}
	var fecha = $('#collapse-'+id+' input[name="OrdenSolicitud[fecha_maxima_aprobacion]"]').val();
	if(fecha != ''){
		nombre = nombre + ' - ' + fecha;
	}
	$('#accordion-title-'+id).html(nombre);
}

function pagosCotizacion(id){
  var url = $(id).attr("href");
  $.ajax({
    url: url,
    dataType:'json',
    success: function(data){

      $("#modalPagos .modal-body").html(data.content);
      $("#modalPagos").modal("show");
    },
    error: function()
    {
      
    }
  });
  return false;
}
$(document).ready(function(){

  $(".autoGuardar").live("blur", function(e){
    e.preventDefault();
    var campo = $(this).attr('campo');
    var valor = $(this).val();
    var id = $(this).attr('id_sol_direc');
    jQuery.ajax({
        url:'<?php echo $this->createUrl('orden/autosavesol') ?>' + '?id=' + id,
        type : 'post',
        data: {campo:campo, valor:valor},
        success: function(data) {
            console.log(data);
        },
        cache:false
    });

  });

	$(".ver-otras, .subir-archivos, .upload-cot").live("click", function(e){
		e.preventDefault();
    jQuery('.tooltip').remove();
    $('#genericModal div.modal-body').html("");
    $("#genericModal a.delete").on('click', function(){return false;});
   	jQuery.ajax({
			url :$(this).attr("href"),
			type :'get',
			success : function(data){
				    /*var reply = $(data);                                                                                                                   
				    var target = $('#genericModal .modal-body');
				    target.html('');                                                                                                                         
				    target.append(reply.filter('script[src]').filter(function() { return $.inArray($(this).attr('src'), script_files) === -1; }));           
				    target.append(reply.filter('link[href]').filter(function() { return $.inArray($(this).attr('href'), css_files) === -1; }));              
				    target.append(reply.filter('#content'));                                                                                                      
				    target.append(reply.filter('script:not([src])'));  
				    $("#genericModal").modal();*/
            var reply = $(data);                                                                                                                
            var target = $('#genericModal .modal-body');
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

            var content = reply.filter('#content');
            var target_dir = reply.find("div")[1];
            var id = $(target_dir).attr("id");
            $("#"+id+ " a.delete").die('click');  
            $("#"+id+ " .filters").die('change');       
            target.append(content);                                                                                                      
            target.append(reply.filter('script:not([src])'));
            $("#genericModal").modal();                                                                                           
			}
		});
	});

	$(".actualizar-proveedor").live("click", function(e){
	    e.preventDefault();
	    updateProveedor($(this).attr("href"));
	});
	$(".actualizar-costos").live("click", function(e){
	    e.preventDefault();
	    updateCostos($(this).attr("href"));
	});
	$(".actualizar-direccion").live("click", function(e){
	    e.preventDefault();
	    updateDireccion($(this).attr("href"));
	});

  $(".enviar-cotizacion-a-usuario").live("click", function(e){
    e.preventDefault();
    pagosCotizacion(this);

  });

  $("#btn_rechazar_producto").live("click", function(e){
    e.preventDefault();
    App.rechazarProducto(this , "modalCotizacion");

  });

  $(".elegir-cotizacion").live("click", function(e){
    e.preventDefault();
    App.elegirCotizacion(this , "elegirCotizacion");

  });

  $("#btn_aprobar_consumo").live("click", function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
      "url":url,
      "type":"post",
      "dataType":"json",
      "success":function(data){
        if (data.status == "success"){
          actualizarTd(data.grid);
        }

      } ,"cache":false
    }); 
    return false;

  });

  $(".seleccionar-pago").live("click", function(e){
    e.preventDefault();
    var url = $(this).attr('url');
    var cot = $(this).attr('cotizacion');
    $.ajax({
      "url":url,
      "type":"post",
      "dataType":"json",
      "success":function(data){
        if (data.status == "success"){
          $("#modalPagos").modal("hide");
          actualizarTd(data.grid);
        }
        else{
          bootbox.alert("mensaje: "+data.status);
          $("#modalPagos").modal("show");
        }

      } ,"cache":false
    }); 
    return false;

  });

  $(".deseleccionar-pago").live("click", function(e){
    e.preventDefault();
    var url = $(this).attr('url');
    var cot = $(this).attr('cotizacion');

    $.ajax({
      "url":url,
      "type":"post",
      "dataType":"json",
      "success":function(data){
        if (data.status == "success"){
          $("#modalPagos").modal("hide");
          actualizarTd(data.grid);
        }else{
          bootbox.alert("mensaje: "+data.status);
        }

      } ,"cache":false
    }); 
    return false;

  });

	//alSalir();
  $('#wizard').smartWizard({
      keyNavigation: false,
      onLeaveStep:leaveAStepCallback,
      onFinish:onFinishCallback,   // array of step numbers to highlighting as error steps
      labelNext:'Siguiente', // label for Next button
      labelPrevious:'Anterior', // label for Previous button
      labelFinish:'Finalizar y Guardar'
  });
  function leaveAStepCallback(obj, context){
    
        if(context.fromStep > context.toStep)
          return true;
        var ret = validateSteps(context.fromStep);
        if (ret.status == "success"){
          $("#errors").html("");
          if(context.fromStep == '1')
            $('#productos-creados-grid').yiiGridView.update('productos-creados-grid');
          return true;
        }
        else {
          $("#errors").html(ret.content);
          $('body, html').animate({
            scrollTop: '0px'
          }, 300);
          return false;
        }
        return ret; // return false to stay on step and true to continue navigation 
    }
    // Your Step validation logic
    function validateSteps(stepnumber){
        var isStepValid = true;
        // validate step 1
        var url = '<?php echo $this->traerUrlPaso($model->id)?>'+'&paso='+stepnumber;
        return JSON.parse($.ajax({
              type: "post",
              url: url,
              dataType: 'json',
              data: $("#orden-form").serialize(),
              async:false,
              success: function(data)
              {
                return data;
              }
          }).responseText);
    }

    function onFinishCallback(objs, context){
        var ret = validateSteps(context.fromStep);
        if (ret.status == "success"){
          location.href = '<?php echo $this->createUrl("orden/admin")?>';
          return true;
        }
        else {
          $("#errors").html(ret.content);
          return false;
        }
        return ret;
    }

    function validateAllSteps(){
        var isStepValid = true;
        // all step validation logic     
        return isStepValid;
    } 


  $(document).on('click','.tbrelational-column', function(){
    var that = $(this);
    var rowid = that.data('rowid');
    var tr = $('#relatedinfo'+rowid);

    
    if (tr.length && !tr.is(':visible'))
    {
      $('.stepContainer').height($('.stepContainer').height() + 150);
      return;
    }else if (tr.length && tr.is(':visible'))
    {
      $('.stepContainer').height($('.stepContainer').height() - 130);
      return;
    }
    else if (!tr.length)
    {
      $('.stepContainer').height($('.stepContainer').height() + 150);
    }
  });

  $('#CotizacionOp_cantidad, #CotizacionOp_valor_unitario, #CotizacionOp_trm').live('blur', function(e){
    $("#CotizacionOp_total_compra").val($("#CotizacionOp_cantidad").val() * $("#CotizacionOp_valor_unitario").val());
    $("#CotizacionOp_total_compra_pesos").val($("#CotizacionOp_cantidad").val() * $("#CotizacionOp_valor_unitario").val() * $("#CotizacionOp_trm").val());
  });

  $('#CotizacionOp_moneda').live('change', function(e){
    if($("#CotizacionOp_moneda option:selected").val() == "Peso"){
      $("#trm").slideUp();
      $("#CotizacionOp_trm").val(1);
      $("#CotizacionOp_trm").attr("readonly","readonly"); 
      $(".totales").attr('class', 'col-md-6 totales');
    }else{
      $("#CotizacionOp_trm").val("");
      $("#CotizacionOp_trm").removeAttr("readonly"); 
      $("#trm").slideDown();
      $("#trm").attr('class', 'col-md-4');
      $(".totales").attr('class', 'col-md-4 totales');
    }
    $("#CotizacionOp_total_compra").val($("#CotizacionOp_valor_unitario").val() * $("#CotizacionOp_cantidad").val());
    $("#CotizacionOp_total_compra_pesos").val($("#CotizacionOp_valor_unitario").val() * $("#CotizacionOp_cantidad").val() * $("#CotizacionOp_trm").val());
  });

  $('#CotizacionOp_descuento_prontopago').live('change', function(e){
    if($("#CotizacionOp_descuento_prontopago option:selected").val() == "Si"){
      $("#CotizacionOp_porcentaje_descuento").removeAttr("disabled");
      $("#CotizacionOp_dias_pago_factura").removeAttr("disabled");
    }
    else{
      $("#CotizacionOp_porcentaje_descuento").attr("disabled","disabled");
      $("#CotizacionOp_dias_pago_factura").attr("disabled","disabled");
    }
  });
	/*syncFields2();
	autoSaveSol(<?php echo $model->id; ?>);
	autoSaveProd();
	catchBackspace();*/
});


function actualizarTd(id){

  var tr = $('#relatedinfo'+id);
  var id = {id:id};
  $.ajax({
    url: '<?php echo $this->createUrl("orden/traerCotizaciones") ?>',
    data: (id),
    success: function(data){
      tr.find('td').html(data);
    },
    error: function()
    {
      tr.find('td').html(data.error);
    }
  });
}
</script>

<?php Yii::app()->clientScript->registerScript('register_static_css_js', "                                                                               
$(function() {                                                                                                                                         
     script_files = $('script[src]').map(function() { return $(this).attr('src'); }).get();                                                                                                                                          
     css_files = $('link[href]').map(function() { return $(this).attr('href'); }).get();                                                                                                                                          
});"); ?>

<?php Yii::app()->clientScript->registerScript('no_scripts_ajax_callback', "                                                                               



window.clean_response = function (titulo, data) {

            var reply = $(data);                                                                                                                
            var target = $('#modalTraza .modal-body');
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
            $('#modalTraza .modal-header h3').html(titulo);
            $('#modalTraza').modal('show');
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


