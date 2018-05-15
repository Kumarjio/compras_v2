var App = function (v) {
    var modal;

    function crearContacto(el, m){

        modal = m;
        var okCrearContacto = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(){
                    var url = $(el).attr('urlUpdateList') + "?nit=" + $('#OmCotizacion_nit').val();
                    var serialized = {'proveedor':$('#OmCotizacion_nit').val()};
                    doReqData(url, serialized, function(res){
                        if(res.status == 'ok'){
                            $('#OmCotizacion_contacto').html(res.combo);
                            $('#modalCotizacion').modal('show');
                        }else{
                            alert(res.mensaje);
                        }
                    });
                    //$('#itinerario-grid').yiiGridView.update('itinerario-grid');
                    //$('#gastos-viaje-grid').yiiGridView.update('gastos-viaje-grid');
                });
            });
        };
        doReq(extractUrl(el), okCrearContacto, null);
    }

    function crearContactoOp(el, m){

        modal = m;
        var okCrearContactoOp = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(){
                    var url = $(el).attr('urlUpdateList') + "?nit=" + $('#CotizacionOp_nit').val();
                    var serialized = {'proveedor':$('#CotizacionOp_nit').val()};
                    doReqData(url, serialized, function(res){
                        if(res.status == 'ok'){
                            $('#CotizacionOp_contacto').html(res.combo);
                            $('#modalCotizacion').modal('show');
                        }else{
                            alert(res.mensaje);
                        }
                    });
                    //$('#itinerario-grid').yiiGridView.update('itinerario-grid');
                    //$('#gastos-viaje-grid').yiiGridView.update('gastos-viaje-grid');
                });
            });
        };
        doReq(extractUrl(el), okCrearContactoOp, null);
    }
    function crearProveedor(el, m){

        modal = m;
        var okCrearProveedor = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(){
                    $('#proveedor-om-grid').yiiGridView.update('proveedor-om-grid');
                    $("#modalProveedores").modal("show");
                    //$('#itinerario-grid').yiiGridView.update('itinerario-grid');
                    //$('#gastos-viaje-grid').yiiGridView.update('gastos-viaje-grid');
                });
            });
        };
        doReq(extractUrl(el), okCrearProveedor, null);
    }

    function nuevoProducto(el, m){

        modal = m;
        var okNuevoProducto = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(){
                    $('#orden-solicitud-grid').yiiGridView.update('orden-solicitud-grid');
                    //$("#modalProveedores").modal("show");
                    //$('#itinerario-grid').yiiGridView.update('itinerario-grid');
                    //$('#gastos-viaje-grid').yiiGridView.update('gastos-viaje-grid');
                });
            });
        };
        doReq(extractUrl(el), okNuevoProducto, null);
    }

    function nuevoProductoTabla(el, m){

        modal = m;
        var okNuevoProducto = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(){
                    $('#productos-om-grid').yiiGridView.update('productos-om-grid');
                    $("#modalProductos").modal("show");
                    //$("#modalProveedores").modal("show");
                    //$('#itinerario-grid').yiiGridView.update('itinerario-grid');
                    //$('#gastos-viaje-grid').yiiGridView.update('gastos-viaje-grid');
                });
            });
        };
        doReq(extractUrl(el), okNuevoProducto, null);
    }


    function crearCotizacion(el, m){

        modal = m;
        var okCrearCotizacion = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(data){
                    actualizarTd(data.grid);
                    //$("#modalCotizacion").modal("hide");
                    //$('#'+data.grid).yiiGridView.update(data.grid);
                });
            });
        };
        doReq(extractUrl(el), okCrearCotizacion, null);
    }

    function rechazarProducto(el, m){

        modal = m;
        var okRechazarPto = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(data){
                    actualizarTd(data.grid);
                    //$('#'+data.grid).yiiGridView.update(data.grid);
                });
            });
        };
        doReq(extractUrl(el), okRechazarPto, null);
    }

    function agregarPago(el, m){

        modal = m;
        var okAgregarPago = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(data){
                    actualizarPagos(data.grid);
                });
            });
        };
        doReq(extractUrl(el), okAgregarPago, null);
    }

    function elegirCotizacion(el, m){

        modal = m;
        var okElegirCotizacion = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(data){
                    actualizarTd(data.grid);
                });
            });
        };
        doReq(extractUrl(el), okElegirCotizacion, null);
    }

    function crearDireccion(el, m){

        modal = m;
        var okCrearDireccion = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(data){
                    
                    actualizarModalProductos(data.id_orden_solicitud);
                    /*$('#orden-solicitud-direccion-grid').yiiGridView.update('orden-solicitud-direccion-grid',{
                        data: {'id_orden_solicitud':data.id_orden_solicitud}
                    });*/
                });
            });
        };
        doReq(extractUrl(el), okCrearDireccion, null);
    }

    function agregarOrdenReeem(el, m){
        modal = m;
        var okCrearDireccion = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(data){
                    $('#orden-reemplazos-grid').yiiGridView.update('orden-reemplazos-grid');
                });
            });
        };
        doReq(extractUrl(el), okCrearDireccion, null);
    }

    function agregarProveedor(el, m){

        modal = m;
        var okAgregarProveedor = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(data){
                    
                    actualizarModalProductos(data.id_orden_solicitud);
                    /*$('#orden-solicitud-direccion-grid').yiiGridView.update('orden-solicitud-direccion-grid',{
                        data: {'id_orden_solicitud':data.id_orden_solicitud}
                    });*/
                });
            });
        };
        doReq(extractUrl(el), okAgregarProveedor, null);
    }


    function agregarProducto(el, m){

        modal = m;
        var okAgregarProducto = function(data){
            okOnGet(data, function(post_data){
                okOnPost(post_data, function(data){
                    $('#solpe_grid').yiiGridView.update('solpe_grid');
                    $('#productos-creados-grid').yiiGridView.update('productos-creados-grid');
                });
            });
        };
        doReq(extractUrl(el), okAgregarProducto, null);
    }
    /* Callback usado cuando se envia un form
     * CON parametros post, por ejemplo al hacer
     * click en guardar o actualizar
     */
    function okOnPost(data, fun){
        if(data.modal !== undefined)
            modal = data.modal;
        if(data.status == 'success'){
            $("#"+modal).modal("hide");
            fun(data);
        }else{
            $("#"+modal+" .modal-body").html(data.content);
            registerForm(function(post_data){
                okOnPost(post_data, fun);
            });
        }
    }

    function okOnPostFijo(data, fun, modalFijo){
        modal = modalFijo;
        if(data.status == 'success'){
            $("#"+modalFijo).modal("hide");
            fun(data);
        }else{
             $("#"+modalFijo+" .modal-body").html(data.content);
            registerForm(function(post_data){
                okOnPost(post_data, fun);
            });
        }
    }
    /* Callback usado cuando se envia un form
     * sin parametros post, por ejemplo al cargar
     * el formulario.
     */
    function okOnGet(data, postFun){
        $("#"+modal+" .modal-body").html(data.content);
        registerForm(postFun);
        $("#"+modal).modal("show");
        //mymodal.open();
    }

    function registerForm(postFun){
        var form = $("#"+modal+" .modal-body").find("form");
        var button = form.find("button[type=submit]");
        button.click(function(e){
           e.preventDefault(); 
           var serialized = form.serialize(); 
           doReqData(form.attr("action"), serialized, postFun);
        });

        
        /*$datepick = $(mymodal.content).find(".datetime");
        var mindate = $datepick.attr("data-min-date");
        
        /*$datepick.datetimepicker({
            format:'Y-m-d H:i:00',
            minDate: mindate,
            minTime: '4:30',
            step: 30
        });

        $(".xdsoft_datetimepicker, .xdsoft_time_box").bind('mousewheel DOMMouseScroll', function(e) {
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
        });*/

    }

    function doReqData(url, serialized, ok){
        jQuery.ajax(
            {'url':url,
            'dataType':'json',
            'type':'post',
            'data' : serialized,
            'success': ok,
            'cache':false
            }
        );
    }

    function doReq(url, ok, fail){
        
        jQuery.ajax(
            {'url':url,
            'dataType':'json',
            'type':'get',
            'success': ok,
            'cache':false}
        );
    }

    function extractUrl(el){
        url = $(el).attr("href");
        if (url != undefined)
            return $(el).attr("href");
        return $(el).attr("url");
    }

    function preventDefaults(){
        $(".prevent").on("click", function(e){
            e.preventDefault();
        });
    }

    function registerItinerarioUpdates(){
        $('#itinerario-grid').find(".update").live("click", function(e){
            e.preventDefault();
            nuevoItinerario(this);
        });
    }

    function registerItinerarioUI(){

        $("#Itinerario_tipo_transporte").live("change", function(){
            console.log($("#Itinerario_requiere_transporte").prop("checked"));
            if($("#Itinerario_requiere_transporte").prop("checked")){
                if($(this).val() == 1){
                    $("#Itinerario_direccion_recoger_destino").val("Aeropuerto");
                }else{
                    $("#Itinerario_direccion_recoger_destino").val("");
                }
            }
        });

        $("#Itinerario_requiere_transporte").live("change", function() {
            $("#direcciones-div").toggleClass("hidden", !this.checked);
            var trans = $("#Itinerario_tipo_transporte");
            if(this.checked && trans.val() == 1){
                $("#Itinerario_direccion_recoger_destino").val("Aeropuerto");
            }else{
                $("#Itinerario_direccion_recoger_destino").val("");
            }
        });
    }

    function registerGastosUpdates(){
        $('#gastos-viaje-grid').find(".solo-admtvo").live("click", function(e){
            e.preventDefault();
            nuevoGastos(this);
        });
    }

    function registerItinerarioCancel(){
        $('#itinerario-grid').find(".cancelar").live("click", function(e){
            e.preventDefault();
            cancelarItinerario(this);
        });
    }

    function registerRenunciarViaticos(){
        $(".renunciar").live("click", function(e){
            doReq($(this).attr("href"),function(data){
                $('#gastos-viaje-grid').yiiGridView.update('gastos-viaje-grid');
            });
        });
    }

    function registerTransporteUpdates(){
        $('#transporte-adicional-grid').find(".update").live("click", function(e){
            e.preventDefault();
            nuevoTransporte(this);
        });
    }

    function registerCotizacionUpdates(){
        $('#cotizacion-viaje-grid').find(".ver-cotizacion").live("click", function(e){
            e.preventDefault();
            nuevaCotizacion(this);
        });
    }

    function registerVerInfoEmision(){
        $(".ver-emision").live("click", function(e){
            e.preventDefault();
            verInfoEmision(this);
        });
    }

    function registerViajeroExterno(){
        $("#ViajerosExternos_cedula").keyup(function(e){
            var $this = $(this);
            if($this.val().length === 0){
                $this.parent().parent().find("input").val('');
            }
        }).blur(function(e){
            doReqData($(this).attr("data-url"),$(this).serialize(), function(data){
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        $("#ViajerosExternos_"+key).val(data[key]);
                    }
                }
            });
        });
    }

    function registerGerente(){
        $("#ContactoEmpleados_empleado").change(function(e){
            var $this = $(this);
            
            if($this.is("select")){
                $this.parent().parent().find("input").not($this).val('');
            }else{
                $this.parent().parent().find("input").not($this).not("#Empleado").val('');
            }
            
            doReqData($this.attr("data-url"),$(this).serialize(), function(data){
                for (var key in data) {
                  if (data.hasOwnProperty(key)) {
                    var $node = $("#ContactoEmpleados_"+key);

                    if(!$node.is("input") && !$node.is("select")){
                        $node.html(data[key]);
                    }else{
                        $node.val(data[key]);
                    }
                  }
                }
            });
            
        });
    }

    function registerFireComplete(){
        $(".fire-complete").click(function(e){
            $firer = $(this);
            $firer.val('');
            $("#"+$firer.attr("data-hidden")).val('');
            doReq($firer.attr("data-url"), function(data){
                $(mymodal.content).html(data.content);
                 $(mymodal.content).find("input").focus();
                v.MyComplete(".auto-search", ".results", function(){
                    $('.auto-link').click(function(e){
                        e.preventDefault();
                        var $el = $(this);
                        var parts = $el.attr("data-complete").split("|");
                        $("#"+$firer.attr("data-visible")).val(parts[1]);
                        $("#"+$firer.attr("data-hidden")).val(parts[0]);
                        $("#"+$firer.attr("data-hidden")).trigger("change");
                        mymodal.close();
                    });
                });
                mymodal.open();
            });
        });
    }

    function registerFireChange(e){
        $(".fire-change").change(function(e){
            $firer = $(this);
            doReqData($firer.attr("data-url"), $firer.serialize(), function(data){
                $("#"+$firer.attr("data-target")).val(data.res);
            });  
        });            
    }


    /* AutoSave Functions */
    function autoSaveSol(url){

        var fireEvent = function(){
            if(this.id.match(/Viaje_\w/) || this.id.match(/ContactoEmpleados_\w/) || this.id.match(/ViajerosExternos_\w/)){
                var forma = $(':input').filter(function() {
                    var is_unsync = false;
                    try { is_unsync = $(this).attr("data-sync").match(/false/); }catch(e){}
                    return is_unsync;
                }).serialize();

                var input_ev = this;
                jQuery.ajax(
                    {
                        url:url,
                        type : 'post',
                        data: forma,
                        success: function(data) {
                            $(input_ev).attr("data-sync",true);
                        }
                    }
                );
            }
        };

        $(document).on("blur", ":input", function(e){
            fireEvent.call(this);
        });

        $("#Viaje_centro_costos,#ContactoEmpleados_empleado").on("change", function(){
            var el = $(this);
            if((el.attr("id") == "ContactoEmpleados_empleado") || this.type == "text")
                fireEvent.call(this);
        });
        
    }

    function syncFields(){
        $(':input').on({
            click: function(){
                if(this.type == "text"){
                    $(this).attr("data-sync", false);
                }
            },

            change: function(){
                    $(this).attr("data-sync", false);
            },

            keyup: function(){
                if(this.type == "text" || this.type == "textarea"){
                    $(this).attr("data-sync", false);
                }
            }
        });
    }

    function init(){
        preventDefaults();
        /*registerItinerarioUpdates();
        registerItinerarioUI();
        registerGastosUpdates();
        registerItinerarioCancel();
        registerRenunciarViaticos();
        registerTransporteUpdates();
        registerCotizacionUpdates();
        registerVerInfoEmision();
        registerViajeroExterno();
        registerGerente();
        registerFireComplete();
        registerFireChange();*/
    }

    return {
        init: init,
        crearContacto : crearContacto,
        crearProveedor : crearProveedor,
        crearCotizacion : crearCotizacion,
        agregarPago : agregarPago,
        elegirCotizacion : elegirCotizacion,
        rechazarProducto : rechazarProducto,
        nuevoProducto : nuevoProducto,
        crearDireccion : crearDireccion,
        agregarProveedor : agregarProveedor,
        doReqData : doReqData,
        okOnPostFijo : okOnPostFijo,
        agregarProducto : agregarProducto,
        agregarOrdenReeem : agregarOrdenReeem,
        nuevoProductoTabla : nuevoProductoTabla,
        crearContactoOp : crearContactoOp
        /*asignaCita : asignaCita,
        pruebaModal : pruebaModal,
        nuevoItinerario : nuevoItinerario,
        nuevoTransporte : nuevoTransporte,
        syncFields : syncFields,
        autoSaveSol: autoSaveSol*/
    };

}(window.viajes);
