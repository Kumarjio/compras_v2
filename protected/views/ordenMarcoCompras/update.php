<?php
/*$this->breadcrumbs=array(
	'Orden Marco Comprases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);*/

/*$this->menu=array(
	array('label'=>'List OrdenMarcoCompras','url'=>array('index')),
	array('label'=>'Create OrdenMarcoCompras','url'=>array('create')),
	array('label'=>'View OrdenMarcoCompras','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage OrdenMarcoCompras','url'=>array('admin')),
);*/
?>

<div class="">
  	<div class="row">

      	<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
    	        <div class="x_title">
		            <?php if($model->id < 600000000): ?>
		        	    <h3>Solicitud de Marco No. <b><?php echo $model->id; ?></b></h3> 
		            <?php else: ?>
		            	<h3>Formato de Solicitud Marco</h3> 
		            <?php endif ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

					<?php echo $this->renderPartial('_form',array('model'=>$model,'productos'=>$productos, 'detalle'=>$detalle)); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo $this->renderPartial('_modal_productos',array('productos'=>$productos)); ?>

<?php echo $this->renderPartial('_modal_proveedores',array('proveedores'=>$proveedores)); ?>

<?php echo $this->renderPartial('_modales_genericos'); //modalCotizacion, modalContacto, modalNuevoProveedor ?>

<script type="text/javascript">
	$(document).ready(function(){   
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
        $("#OrdenMarcoCompras_paso_wf").val($("#OrdenMarcoCompras_paso_wf")[0][0].value);
        var ret = validateSteps(context.fromStep);
        if (ret.status == "success"){
          $("#errors").html("");
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

        var url = '<?php echo $this->createUrl("ordenMarcoCompras/update", array("id"=>$model->id)) ?>'+'&paso='+stepnumber;
        return JSON.parse($.ajax({
              type: "post",
              url: url,
              dataType: 'json',
              data: $("#orden-marco-compras-form").serialize(),
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
          bootbox.alert(ret.msg, function(){ location.href = ret.href; });
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
    $('#modalProductos').modal({
        width:80,
        show:false,
        maxHeight:3000
    });
    $(".ver-otras, .subir-archivos, .upload-cot").live("click", function(e){
      alert('asjdfsafsad');
      e.preventDefault();
      jQuery('.tooltip').remove();
      $('#genericModal div.modal-body').html("");
      $("#genericModal a.delete").on('click', function(){alert('hoool'); return false;});
      jQuery.ajax({
        url :$(this).attr("href"),
        type :'POST',
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
              $("#genericModal").modal("show");                                                                
        }
      });
    });


  });

  $("#crear_contacto").live("click", function(e){
    e.preventDefault();
    if($(this).attr('href') != "#"){
      $("#modalCotizacion").modal("hide");
      App.crearContacto(this , "modalContacto");
    }
    return false;  
  });



  $("#btn_crear_pro").live("click", function(e){
    e.preventDefault();
    $("#modalProveedores").modal("hide");
    App.crearProveedor(this , "modalNuevoProveedor");

  });

  $('.grid-cot').find(".update").live("click", function(e){
    e.preventDefault();
    App.crearCotizacion(this , "modalCotizacion");

  });
  $("#btn_crear_cotizacion").live("click", function(e){
    e.preventDefault();
    App.crearCotizacion(this , "modalCotizacion");

  });

  $("#btn_rechazar_producto").live("click", function(e){
    e.preventDefault();
    App.rechazarProducto(this , "modalCotizacion");

  });

  $('.grid-cot').find(".update").live("click", function(e){
    e.preventDefault();
    App.crearCotizacion(this , "modalCotizacion");

  });

  $(".agregar-pago").live("click", function(e){
    e.preventDefault();
    $("#modalPagos").modal("hide");
    App.agregarPago(this , "agregarPago");

  });

  $(".delete-pago").live("click", function(e){
    e.preventDefault();
    if(!confirm('¿Está seguro que desea eliminar este registro?')) 
      return false;
    var url = $(this).attr('href');
    $.ajax({
      "url":url,
      "type":"post",
      "dataType":"json",
      "success":function(data){
        if (data.status == "success"){
          $("#modalPagos .modal-body").html(data.content);
          //$('#pagos-grid').yiiGridView.update('pagos-grid');
          //$("#modalPagos").modal("hide");
          //actualizarTd(data.grid);
        }

      } ,"cache":false
    }); 
    return false;
    //$("#modalPagos").modal("hide");
    //App.agregarPago(this , "agregarPago");
    //actualizarPagos(data.grid);

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


  $(".enviar-cotizacion-a-usuario").live("click", function(e){
    e.preventDefault();
    pagosCotizacion(this);

  });

  $(".elegir-cotizacion").live("click", function(e){
    e.preventDefault();
    App.elegirCotizacion(this , "elegirCotizacion");

  });

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

  $('#OmCotizacion_cantidad, #OmCotizacion_valor_unitario, #OmCotizacion_trm').live('blur', function(e){
    var cantidad = parseFloat($("#OmCotizacion_cantidad").val().replace(".",""));
    var valor_unit = parseFloat($("#OmCotizacion_valor_unitario").val().replace(".",""));
    var trm = parseFloat($("#OmCotizacion_trm").val().replace(".",""));

    $("#OmCotizacion_total_compra").val(cantidad * valor_unit);
    $("#OmCotizacion_total_compra_pesos").val(cantidad * valor_unit * trm);
  });

  $('#OmCotizacion_moneda').live('change', function(e){
    if($("#OmCotizacion_moneda option:selected").val() == "Peso"){
      $("#trm").slideUp();
      $("#OmCotizacion_trm").val(1);
      $("#OmCotizacion_trm").attr("readonly","readonly"); 
      $(".totales").attr('class', 'col-md-6 totales');
    }else{
      $("#OmCotizacion_trm").val("");
      $("#OmCotizacion_trm").removeAttr("readonly"); 
      $("#trm").slideDown();
      $("#trm").attr('class', 'col-md-4');
      $(".totales").attr('class', 'col-md-4 totales');
    }
    $("#OmCotizacion_total_compra").val($("#OmCotizacion_valor_unitario").val() * $("#OmCotizacion_cantidad").val());
    $("#OmCotizacion_total_compra_pesos").val($("#OmCotizacion_valor_unitario").val() * $("#OmCotizacion_cantidad").val() * $("#OmCotizacion_trm").val());
  });

  $('#OmCotizacion_descuento_prontopago').live('change', function(e){
    if($("#OmCotizacion_descuento_prontopago option:selected").val() == "Si"){
      $("#OmCotizacion_porcentaje_descuento").removeAttr("disabled");
      $("#OmCotizacion_dias_pago_factura").removeAttr("disabled");
    }
    else{
      $("#OmCotizacion_porcentaje_descuento").attr("disabled","disabled");
      $("#OmCotizacion_dias_pago_factura").attr("disabled","disabled");
    }
  });

  /*$(document).on('hide.bs.modal', function (e) {

      var id_modal = $(e.target).attr('id');  
      if(id_modal == 'modalNuevoProveedor' )
        $('#modalProveedores').modal('show');
      if(id_modal == 'modalProveedores' )
        $('#modalCotizacion').modal('show');
      
  });*/ 


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
//home/indexacion_masiva/autdatospersonales/ Imagine+2017
  function agregarProductoOM(id){
    var producto = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('producto' => 'js:producto'),
        'url' => $this->createUrl("ordenMarcoCompras/buscarProductoMarco"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.cant_ordenes > 0){
              $("#modalProductos").modal("hide");
              bootbox.confirm({
                message : "<h3>Este producto ya tiene cantidades marco aprobadas en otras ordenes, ¿De todas maneras desea agregarlo?</h3>", 
                buttons: {
                    confirm: {
                        label: "SI",
                        className: "btn-success"
                    },
                    cancel: {
                        label: "NO",
                        className: "btn-danger"
                    }
                },
                callback: function(result){ 
                  if(result){
                    agregarProductoOMStep2(data.producto);
                  }
                  else
                    $("#modalProductos").modal("show");
                } 
              } );
            }
            else {
            	agregarProductoOMStep2(data.producto);
            }
        }'
      )
    );?>
    return false;
  }

  function agregarProductoOMStep2(producto){
    //var producto = $(id).attr("href");
    var id_om = '<?php echo $model->id; ?>';
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('producto' => 'js:producto', 'id_om' => 'js:id_om'),
        'url' => $this->createUrl("ordenMarcoCompras/adicionarProducto"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#modalProductos").modal("hide");
              bootbox.alert("<h4>Producto adicionado correctamente a la orden<h4>", function(){ $("#modalProductos").modal("show");});
              $("#seleccionar-productos-om").yiiGridView.update("seleccionar-productos-om");
              $(".stepContainer").height($(".stepContainer").height() + 150);
            }
            else {
              console.log(data.errores);
            }
        }'
      )
    );?>
    return false;
  }

  function agregarCot(el){
  	var id = $(el).attr('href');
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id_detalle_om' => 'js:id'),
        'url' => $this->createUrl("ordenMarcoCompras/adicionarCotizacion"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#modalCotizacion .modal-header").html(data.header);
              $("#modalCotizacion .modal-body").html(data.content);
              $("#modalCotizacion").modal("show");
              
            }
        }'
      )
    );?>
    return false;
  }

  function setProveedor(event){
    var arr = event.href.split("#");
    var nit = arr[1];
    var razon_social = decodeURIComponent(arr[2]);
    $('#OmCotizacion_nit').val(nit);
    $('#OmCotizacion_nombre_proveedor').val(razon_social);
    $("#modalProveedores").modal('hide');
  }

  function selectProveedor(e){
    $("#modalCotizacion").modal("hide");
    $("#modalProveedores").modal("show");
    return false;
  }

  function actualizarTd(id){

    var tr = $('#relatedinfo'+id);
    var id = {id:id};
    $.ajax({
      url: '<?php echo $this->createUrl("ordenMarcoCompras/traerCotizaciones") ?>',
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


  function actualizarPagos(id){

    var url = $(id).attr("href");
    var id = {id_cot:id};
    $.ajax({
      url: '<?php echo $this->createUrl("/ordenMarcoCompras/agregarPagosACotizacionOm") ?>',
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


$("#modalCotizacion, #modalProveedores, #modalNuevoProveedor, #modalContacto, #modalProductos, #agregarPago, #modalPagos").bind('mousewheel DOMMouseScroll', function(e) {
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

<?php Yii::app()->clientScript->registerScript('register_static_css_js', "                                                                               
$(function() {                                                                                                                                       
     script_files = $('script[src]').map(function() { return $(this).attr('src'); }).get();                                                                                                                                          
     css_files = $('link[href]').map(function() { return $(this).attr('href'); }).get();                                                                                                                                          
});"); ?>
