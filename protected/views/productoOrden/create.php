<?php
$this->breadcrumbs=array(
	'Productos Orden',
);
if($orden->paso_wf == 'swOrden/en_negociacion'){
	$this->menu=array(
	  array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
	  array('label'=>'Delegar Solicitud','url'=>array('/orden/delegar', 'id' => $orden->id),'icon'=>'hand-right'),
	);
}else{
	if($orden->paso_wf == 'swOrden/aprobacion_comite_compras' or $orden->paso_wf == 'swOrden/aprobacion_comite_presidencia'){
		$this->menu=array(
		  array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
		  array('label'=>'Imprimir','url'=>array('/orden/print', 'orden' => $orden->id),'icon'=>'print'),
		);
	}
	$this->menu=array(
	  array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
	);
}

?>

<div class="subnav">
  <div class="subnav-inner">
    <ul class="nav nav-pills">
      
      <li><a href="javascript:void(0)" onclick="<?php 

          echo CHtml::ajax(
                    array(
                      'type' => 'get',
                      'data' => array('model' => 'Orden', 'id' => $orden->id),
                      'url' => $this->createUrl("trazabilidadWfs/index"),
                      'success' => 'function(data){
                          clean_response(\'Trazabilidad\', data);

                      }'
                    )
                );

       ?>">Trazabilidad</a></li>
      <li><a href="javascript:void(0)" onclick="<?php 

          echo CHtml::ajax(
                    array(
                      'type' => 'get',
                      'data' => array('model' => 'Orden', 'id' => $orden->id),
                      'url' => $this->createUrl("observacionesWfs/index"),
                      'success' => 'function(data){
                          clean_response(\'Observaciones\', data); 
                      }'
                    )
                );

       ?>">Observaciones <?php if($orden->observacionesCount[0]): ?><span class="badge badge-important"><?php echo $orden->observacionesCount[0]; ?></span><?php endif ?></a></li>
       <!--<li><a href="javascript:void(0)" onclick="<?php 

          echo CHtml::ajax(
                    array(
                      'type' => 'get',
                      'data' => array('model' => 'Orden', 'id' => $orden->id),
                      'url' => $this->createUrl("activeRecordLog/index"),
                      'success' => 'function(data){
                          clean_response(\'Log de cambios\', data); 
                      }'
                    )
                );

       ?>">Log de cambios</a></li> 
-->
    </ul>
  </div>
 </div>

<?php echo $this->renderPartial('_form', array('model'=>$model,
											   'orden' => $orden, 
											   'productos_orden' => $productos_orden, 
											   'cotizacion_model' => $cotizacion_model,	
											   'observaciones' => $observacion_model,
											   'orden_solicitud_model' => $orden_solicitud_model,
											   'asistentes_model' => $asistentes_model,
											   'empleados_model' => $empleados_model,
                         'reemplazos' => $reemplazos
												)); ?>


	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'productoModal', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccione un Producto</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      
  
  <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'productos-grid',
    'dataProvider'=>$producto_model->search(),
    'type'=>'striped bordered condensed',
    'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'filter'=>$producto_model,
    'columns'=>array(
	  'id',
      'nombre',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{select}',
        'buttons'=>array
                  (
                    'select' => array
                                (
                                  'label' => "<i class='icon-ok'></i>", 
                                  'url' => '"#".$data->id."#".$data->nombre',
                                  'options'=>array(
                                     'title' => 'Seleccionar',    
                                     "onClick"  => '(function(e, obj){ 
										var arr = $(obj).parent().find("a").attr("href").split("#");
										jQuery.ajax({\'url\':\'/index.php/ProductoOrden/ActualizarProducto\',\'type\':\'post\',\'dataType\':\'json\', \'data\': {\'id_producto_orden\': id_producto_actual, \'id_producto\': arr[1]}, \'success\':function(data)
									            {
									                if (data.status == \'failure\')
									                {
									                }
									                else
									                {
									                    $("#nombre-producto-"+id_producto_actual).html(arr[2]);
														resetGridView("productos-grid");
														$("#productoModal").modal("hide");
									                }

									            } ,\'cache\':false});
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
          'label'=>'Crear Producto',
          'url'=>'/index.php/producto/create/orden/'.$orden->id,
          'htmlOptions'=>array('class' => 'btn btn-primary', 'onClick' => 'resetGridView("productos-grid");'),
      )); ?>
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("productos-grid");'),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>

	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'genericModal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Nueva Cotización</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      
  
  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>

 <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'ver-mas-cotizacion-modal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


<div class="modal-header">
  <a class="close" data-dismiss="modal">&times;</a>
  <h3>Ver Cotización</h3>
</div>

<div id="ver-mas-cotizacion-modal-content" class="modal-body">
  

</div>
<div class="modal-footer">
  <?php $this->widget('bootstrap.widgets.BootButton', array(
      'label'=>'Cerrar',
      'url'=>'#',
      'htmlOptions'=>array('data-dismiss'=>'modal'),
  )); ?>
</div>


<?php $this->endWidget(); ?>


	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'ver-orden-solicitud-modal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Ver Solicitud</h3>
  </div> 
  <div id="ver-orden-solicitud-modal-content" class="modal-body"></div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
      )); ?>
  </div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'ver-mas-modal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
<div class="modal-header">
<a class="close" data-dismiss="modal">&times;</a>
<h3>Ver Más</h3>
</div> 
<div id="ver-mas-modal-content" class="modal-body"></div>
<div class="modal-footer">
<?php $this->widget('bootstrap.widgets.BootButton', array(
  'label'=>'Cerrar',
  'url'=>'#',
  'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
)); ?>
</div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'agregar-pago-modal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
<div class="modal-header">
<a class="close" data-dismiss="modal">&times;</a>
<h3>Agregar forma de pago</h3>
</div> 
<div id="agregar-pago-modal-content" class="modal-body"></div>
<div class="modal-footer">
<?php $this->widget('bootstrap.widgets.BootButton', array(
  'label'=>'Cerrar',
  'url'=>'#',
  'htmlOptions'=>array('data-dismiss'=>'modal', 'onClick' => '$("#genericModal").modal("show");'),
)); ?>
</div>
<?php $this->endWidget(); ?>

	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'proveedor-modal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>Seleccionar Proveedor</h3>
</div>
<div class="modal-body">
    <p>Puede buscar un proveedor en la lista utilizando los diferentes filtros.</p>
</div>
<div style="margin:10px;">
<script type="text/javascript">
input_id = "";
function setProveedor(event){
	var arr = event.href.split("#");
	var nit = arr[1];
	var razon_social = arr[2];
	$('#Cotizacion_nit').val(nit);
	$('#Cotizacion_razon_social').val(razon_social);
	$("#proveedor-modal").modal('hide');
}
</script>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'proveedor-grid',
	'type'=>'striped bordered condensed',
    	'dataProvider'=>$proveedor_model->search_2(),
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'filter'=>$proveedor_model,
	'rowCssClassExpression' => '($data->bloqueado == 1)?"proveedor_bloqueado":""',
	'pager'=>array(
	        'class'=>'bootstrap.widgets.BootPager',
	        'displayFirstAndLast'=>true,
	),
	'columns'=>array(
		'nit',
		'razon_social',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{select}',
				'buttons'=>array
				    (
				        'select' => array
				        (
							'url' => '"#".$data->nit."#".$data->razon_social',
							'label' => "<i class='icon-ok'></i>",
							'options'=>array('title' => 'seleccionar este proveedor', 'onClick' => "setProveedor(this); resetGridView('proveedor-grid'); $('#proveedor-modal').modal('hide'); $('#genericModal').modal('show'); 
							
									jQuery.ajax({'type':'post','dataType':'json','data':{'proveedor':$('#Cotizacion_nit').val()},'url':'/index.php/proveedor/contactos','success':function(data){
							       			if(data.status == 'ok'){
							       				$('#Cotizacion_contacto').replaceWith(data.combo);
													$('#crear_contacto_proveedor').attr('href','/index.php/contactoProveedor/create/id_proveedor/'+$('#Cotizacion_nit').val());
												$('#crear_contacto_proveedor').slideDown();
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
        'htmlOptions'=>array('data-dismiss'=>'modal', 'onClick' => 'resetGridView("proveedor-grid");'),
    )); ?>
</div>
<?php $this->endWidget(); ?>


<script type="text/javascript">

function nuevaCotizacion(url, callback)
{
    <?php $url = $this->createUrl('cotizacion/create/prodorden')."/" ?>

    if(!callback){
      callback = false;
    }

    jQuery.ajax({'url':url,'data':$('#genericModal div.modal-body form').serialize(),'type':'post','dataType':'json', 'success':function(data)
            {
                if (data.status == 'failure')
                {
                    $('#genericModal div.modal-body').html("");
                    $('#genericModal div.modal-body').html(data.div);
                    $('#genericModal div.modal-body form').submit(function(e){ e.preventDefault(); nuevaCotizacion(url, callback); });
                }
                else
                {
                    //$('#cotizacion-grid_'+ producto_orden).yiiGridView.update('cotizacion-grid_'+ producto_orden);
                    $("#"+data.grid).yiiGridView.update(data.grid);
                    $('#genericModal div.modal-body').html("");
                    $('#genericModal').modal('hide');
                    if(callback){
                       callback(data);
                    }
					<?php
						if($orden->paso_wf=='swOrden/en_negociacion'){
							echo 'location.reload();';
						}
						if(Yii::app()->user->getState('gerente')){
							echo 'location.reload();';
						} 
					?>
                }
 
            } ,'cache':false});

    
    return false; 
 
}

function rechazarProducto(url, model){
   var fn = function(data){
      $('#orden-solicitud-' + model).before(data.html);
      $('#rechazar-producto-' + model).removeClass('disabled');
   }
   $("#genericModal .modal-header h3").html("Razón del rechazo");
   $('#genericModal div.modal-body').html("");
   nuevaCotizacion(url, fn);
   $('#genericModal').modal();
}

function agregarAsistente(url)
{
    jQuery.ajax({'url':url,'type':'post','dataType':'json','success':function(data)
            {
                if (data.status == 'failure')
                {
                }
                else
                {
                    $("#asistentes-grid").yiiGridView.update("asistentes-grid");
                }
 
            } ,'cache':false});

    
    return false; 
 
}

$(document).ready(function(){
	id_producto_actual = 0;
	$(".ver-otras, .subir-archivos, .upload-cot, .enviar-cotizacion-a-usuario, .asignar-regalos").live("click", function(e){
		e.preventDefault();
    jQuery('.tooltip').remove();
    $('#genericModal div.modal-body').html("");

	switch(this.className){
		case 'ver-otras':
			$('#genericModal .modal-header h3').html("Cotizaciones del Proveedor");
			break;
		case 'subir-archivos':
			$('#genericModal .modal-header h3').html("Subir Archivos");
			break;
		case 'upload-cot':
			$('#genericModal .modal-header h3').html("Subir Cotizacion");
			break;
		case 'enviar-cotizacion-a-usuario':
			$('#genericModal .modal-header h3').html("Enviar Cotizacion a Usuario");
            $('#agregar-pago-modal .modal-header h3').html("Asignar forma de pago");
			break;
		case 'asignar-regalos':
			$('#genericModal .modal-header h3').html("Asignar regalos a la cotización");
            $('#agregar-pago-modal .modal-header h3').html("Agragar nuevo regalo");
			break;
		default:
			break;
	}
			
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


  $(".borrar-producto").live("click", function(e){
    var that = this;
    e.preventDefault();
    var seguro = confirm("Está seguro de eliminar el producto con sus cotizaciones?");
    if(seguro){
      jQuery.ajax({
        url :$(this).attr("data-url"),
        type :'post',
        success : function(){
          document.location.reload();
        },
        error : function(){
          alert("No se pudo eliminar el registro");
        }
      });
    }
    
  });

$(".agregar-pago, .agregar-regalo").live("click", function(e){
    e.preventDefault();
    jQuery.ajax({
      url :$(this).attr("href"),
      type :'post',
	  dataType :'json',
      success : function(data){
		$("#genericModal").modal('hide');
        $('#agregar-pago-modal-content').html(data.content);
		$('#agregar-pago-modal').modal('show');
      },
	  saved : function(data){
		$('#agregar-pago-modal').modal('hide');
      }
    });
});

$(".ver-orden-solicitud").live("click", function(e){
    e.preventDefault();
    jQuery.ajax({
      url :$(this).attr("href"),
      type :'post',
	  dataType :'json',
      success : function(data){
        $('#ver-orden-solicitud-modal-content').html(data.content);
		$('#ver-orden-solicitud-modal').modal();
      }
    });
  });

$(".ver-mas-cotizacion").live("click", function(e){
    e.preventDefault();
    jQuery.ajax({
      url :$(this).attr("href"),
      type :'post',
	  dataType :'json',
      success : function(data){
        $('#ver-mas-cotizacion-modal-content').html(data.content);
		$('#ver-mas-cotizacion-modal').modal('show');
      }
    });
  });

 $(".razon_rechazo").click(function(e){
    e.preventDefault();
   
    rechazarProducto($(this).attr("href") || $(this).attr("data-url"), $(this).attr("data-model"));
    
 });

  $(".actualizar-cotizacion, .crear-cotizacion, .duplicar-cotizacion, .update-cot, .elegir-cotizacion-us, .elegir-cotizacion, .elegir-cotizacion-comite").live("click", function(e){
    e.preventDefault();
    //$('#genericModal').modal('hide');
	  jQuery('.tooltip').remove();
		switch(this.className){
			case "elegir-cotizacion-us":
				$("#genericModal .modal-header h3").html("Elegir Cotizacion");
				break;
			case "elegir-cotizacion":
				$("#genericModal .modal-header h3").html("Elegir Cotizacion");
				break;
			case "elegir-cotizacion-comite":
				$("#genericModal .modal-header h3").html("Elegir Cotizacion");
				break;
			case "actualizar-cotizacion":
				$("#genericModal .modal-header h3").html("Editar Cotizacion");
				break;
      default:
				$("#genericModal .modal-header h3").html("Nueva Cotizacion");
				break;
		}
	    $('#genericModal div.modal-body').html("");
	    nuevaCotizacion($(this).attr("href") || $(this).attr("data-url"));    
	    $('#genericModal').modal();

});

$(".agregar-asistente").live("click", function(e){
    e.preventDefault();
    agregarAsistente($(this).attr("href"));
  });

jQuery.ajax({'url':'/index.php/orden/cargarUltimosAsistentesComite/id/<?php echo $_GET["orden"]; ?>/comite/<?=$tipoComite;?>',
             'dataType':'json',
             'type':'post',
             'success': function(data){
              if(data.status == "success"){
                $('#asistentes-grid').yiiGridView.update('asistentes-grid');
              }
            },'cache':false});


});
 

</script>

<?php Yii::app()->clientScript->registerScript('register_static_css_js', "                                                                               
$(function() {                                                                                                                                         
     script_files = $('script[src]').map(function() { return $(this).attr('src'); }).get();                                                                                                                                          
     css_files = $('link[href]').map(function() { return $(this).attr('href'); }).get();                                                                                                                                        
});"); ?>

<?php Yii::app()->clientScript->registerScript('no_scripts_ajax_callback', "                                                                               

$(document).on('ready', syncFields2);


window.clean_response = function (titulo, data) {

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

            var content = reply.find('#content');
            //console.log(content);
            var target_dir = reply.find('div')[1];
            var id = $(target_dir).attr('id');
           
            target.append(content);                                                                                                      
            target.append(reply.filter('script:not([src])'));
            $('#genericModal .modal-header h3').html(titulo);
            $('#genericModal').modal();
}

"); ?>
