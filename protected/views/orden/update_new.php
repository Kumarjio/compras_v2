<?php
$this->breadcrumbs=array(
	'Crear',
);

if($model->paso_wf == 'swOrden/analista_compras'){
	$this->menu=array(
	  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
	  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
	  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
	array('label'=>'Delegar Solicitud','url'=>array('delegar', 'id' => $model->id),'icon'=>'hand-right'),
	);
}else{
	$this->menu=array(
	  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
	  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
	  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','visible'=> $model->paso_wf == "swOrden/llenaroc",'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
	  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
	);
}


?>

<div class="subnav">
  <div class="subnav-inner">
    <ul class="nav nav-pills">
      <li ><a href="#general">General</a></li>
      <li><a href="#detalle">Detalle</a></li>
      <li><a onclick="<?php 

          echo CHtml::ajax(
                    array(
                      'type' => 'get',
                      'data' => array('model' => 'Orden', 'id' => $model->id),
                      'url' => $this->createUrl("trazabilidadWfs/index"),
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
                      'data' => array('model' => 'Orden', 'id' => $model->id),
                      'url' => $this->createUrl("observacionesWfs/index"),
                      'success' => 'function(data){
                          clean_response(\'Observaciones\', data); 
                      }'
                    )
                );

       ?>">Observaciones <?php if($model->observacionesCount[0]): ?><span class="badge badge-important"><?php echo $model->observacionesCount[0]; ?></span><?php endif ?></a></li>
       <!--<li><a onclick="<?php 

          echo CHtml::ajax(
                    array(
                      'type' => 'get',
                      'data' => array('model' => 'Orden', 'id' => $model->id),
                      'url' => $this->createUrl("activeRecordLog/index"),
                      'success' => 'function(data){
                          clean_response(\'Log de cambios\', data); 
                      }'
                    )
                );

       ?>">Log de cambios</a></li>-->
    </ul>
  </div>
 </div>



<?php echo $this->renderPartial('_form_steps',array('model'=>$model, 
			'paso_actual' => $paso_actual, 
			'observaciones' => $observacion_model,
      'reemplazos' => $reemplazos
			)); 
?>


<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModal', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
		      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar centro de costos</h3> 
  </div>

  <div id="modal-content" class="modal-body">

 <?php

		      $this->widget('bootstrap.widgets.BootGridView',array(
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
                                         $("#OrdenSolicitudCostos_id_centro_costos").val(arr[1]);
                                         $("#centro_costos").val(arr[2]);
										 resetGridView("centro-costos-grid");
                                         $("#myModal").modal("hide");
                                         $("#crearCostosModal").modal();
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
		      'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("centro-costos-grid"); $("#myModal").modal("hide");$("#crearCostosModal").modal();'),
		      )); ?>
  </div>


	    <?php $this->endWidget(); ?>


	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModal2', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar cuenta contable</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      
  <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'cuenta-contable-grid',
    'dataProvider'=>$cuenta_contable_model->search(),
    'type'=>'striped bordered condensed',
    'filter'=>$cuenta_contable_model,
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
                                  'url' => '"#".$data->id."#".$data->nombre',
                                  'options'=>array(
                                     'title' => 'Seleccionar',    
                                     "onClick"  => '(function(e, obj){ 
                                        var arr = $(obj).parent().find("a").attr("href").split("#");
                                        $("#OrdenSolicitudCostos_id_cuenta_contable").val(arr[1]);  
                                        $("#cuenta_contable").val(arr[2]);
										resetGridView("cuenta-contable-grid");
                                        $("#myModal2").modal("hide");
										$("#crearCostosModal").modal("show");
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
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("cuenta-contable-grid");$("#myModal2").modal("hide");$("#crearCostosModal").modal();'),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>


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

	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'crearCostosModal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Asignar centro de costos / cuenta contable</h3>
  </div>
   
  <div id="costos-modal-content" class="modal-body">

  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
      )); ?>
  </div>
<?php $this->endWidget(); ?>

	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'crearProveedorModal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Agregar Proveedor Recomendado</h3>
  </div>
  <div id="proveedor-modal-content" class="modal-body">
  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal'),
      )); ?>
  </div>
<?php $this->endWidget(); ?>

	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'crearDireccionModal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Agregar Dirección de Envío</h3>
  </div>
  <div id="direccion-modal-content" class="modal-body">
  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal'),
      )); ?>
  </div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'genericModal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


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
  'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
)); ?>
</div>


<?php $this->endWidget(); ?>


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

$(document).ready(function(){
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

	//alSalir();

	syncFields2();
	autoSaveSol(<?php echo $model->id; ?>);
	autoSaveProd();
	catchBackspace();
});

</script>

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


