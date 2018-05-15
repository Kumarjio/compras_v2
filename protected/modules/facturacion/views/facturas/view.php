<?php
$this->breadcrumbs=array(
	'Facturas'=>array('consulta'),  
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


<script type="text/javascript">
 $(document).ready(function() {
 	$('input, textarea, select, [type="submit"]').attr('disabled','disabled');
  $(".ocultar_view").each(function( index ) {
    //alert($( this ).text());
    $( this ).before( "<p>"+$( this ).text()+"</p>" );
    $(this).remove();
    //texto = "";
  });
    $.ajaxSetup({ cache:false });
    $('#myModalOrden, #myModalModificarTipi, #myModalContable, #myModalCostos, #myModalAjax').on('hide.bs.modal', function (e) {
        $("#divCont").show();
    });
    $('#myModalOrden, #myModalModificarTipi, #myModalContable, #myModalCostos, #myModalAjax').on('show.bs.modal', function (e) {
        $("#divCont").hide();
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
    $(".adiccionar-contable").live("click", function(e){
        e.preventDefault();
        addContable($(this).attr("href"));
    });
    $(".adiccionar-centro-costos").live("click", function(e){
        e.preventDefault();
        addCostos($(this).attr("href"));
    });

    $('.valor_centro').blur(function(e){
        e.preventDefault();
        autoGuardarCentro(this);
    });
    
});
</script>	