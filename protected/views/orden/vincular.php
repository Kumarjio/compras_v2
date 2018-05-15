<?php
$this->breadcrumbs=array(
	'Crear',
);


$this->menu=array(
  array('label'=>'Ver Orden','url'=>array('/orden/print', 'orden' => $orden->id), 'icon'=>'eye-open'),
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Editar','url'=>array('update','id'=>$orden->id),'icon'=>'edit'),
  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','visible'=> $orden->paso_wf == "swOrden/llenaroc",'linkOptions'=>array('submit'=>array('delete','id'=>$orden->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
array('label'=>'Delegar Solicitud','url'=>array('delegar', 'id' => $orden->id),'icon'=>'hand-right','visible'=> $orden->paso_wf == "swOrden/analista_compras"),
  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
);


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
                      'data' => array('model' => 'Orden', 'id' => $orden->id),
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
                      'data' => array('model' => 'Orden', 'id' => $orden->id),
                      'url' => $this->createUrl("observacionesWfs/index"),
                      'success' => 'function(data){
                          clean_response(\'Observaciones\', data); 
                      }'
                    )
                );

       ?>">Observaciones <?php if($orden->observacionesCount[0]): ?><span class="badge badge-important"><?php echo $orden->observacionesCount[0]; ?></span><?php endif ?></a></li>
       <li><a onclick="<?php 

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
    </ul>
  </div>
 </div>

<div class="alert alert-block alert-warning fade in">

		<h2>Solicitud de Compra No. <b><?php echo $orden->id; ?></b></h2> 

</div>



<div class="well">
	<h3>Información de la Aprobación:</h3>
	<?php
	if($orden->paso_wf == "swOrden/aprobado_por_comite" or $orden->paso_wf == "swOrden/aprobado_por_presidencia"){
		echo ($orden->paso_wf = "swOrden/aprobado_por_comite")?"<h4>Aprobado por comité de compras.</h4>":"<h4>Aprobado por comité de presidencia.</h4>";
		$asistentes_model = new AsistenteComite;
		$this->widget('bootstrap.widgets.BootGridView',array( 
		    'id'=>'asistentes-grid', 
		    'dataProvider'=>$asistentes_model->search($orden->id), 
		    'type'=>'striped bordered condensed', 
		    'columns'=>array( 
				array('name'=>'empleado.nombre', 'value'=>'$data->empleado->nombre_completo', 'header'=>'Nombre'),
				array('name'=>'empleado.tipo_documento', 'value'=>'$data->empleado->tipo_documento', 'header'=>'Tipo Documento'),
				array('name'=>'empleado.numero_identificacion', 'value'=>'$data->empleado->numero_identificacion', 'header'=>'Numero de Identificacion'),
				array('type' => 'raw', 'value' => '"<span class=\"label label-success\">Aprobó</span>"')
		    ), 
		));
	}else{
		echo "<h4>Aprobado por Atribuciones</h4>";
	}
	
	?>
</div>
<h3>Proveedores:</h3>
<?php
foreach($proveedores as $p){
  $vpaq = VinculacionProveedorAdministrativo::model()->findAllByAttributes(array('id_orden' => $orden->id, 'id_proveedor' => $p->nit), array('order' => 'creacion DESC', 'limit' => 1));
  $vpjq = VinculacionProveedorJuridico::model()->findAllByAttributes(array('id_orden' => $orden->id, 'id_proveedor' => $p->nit), array('order' => 'creacion DESC', 'limit' => 1));
  if(count($vpaq) > 0 and count($vpjq) > 0){
    $vpa = $vpaq[0];
    $vpj = $vpjq[0];
    $diferentes = array();
    if($vpa->devuelto == 1){
      $diferentes = $vpa->verificarDocumentacion();
    }
    if($vpa->paso_wf == 'swVinculacionProveedorAdministrativo/verificar_vinculacion' or Yii::app()->user->id_empleado != $vpa->usuario_actual){
      $dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $vpa->id, 'analista_o_administrativo' => 'Analista'));
    }else{
      $dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $vpa->id, 'analista_o_administrativo' => 'Administrativo'));
    }
    $arch=new AdjuntosVpj('search');
    $arch->unsetAttributes();  // clear any default values
    if(isset($_GET['AdjuntosVpj'])){
      $arch->attributes=$_GET['AdjuntosVpj'];
    }
    $arch2=new AdjuntosWillies('search');
    $arch2->unsetAttributes();  // clear any default values
    if(isset($_GET['AdjuntosWillies'])){
      $arch2->attributes=$_GET['AdjuntosWillies'];
    }
    echo $this->renderPartial('/proveedor/_proveedor', array('model' => $p, 'vpa' => $vpa, 'vpj' => $vpj, 'dvpa' => $dvpa, 'archivos' => $arch, 'archivos_w' => $arch2), true);
  }
}
?>

<?php 
/*if(Yii::app()->params->development==1){
      var_dump($orden->sePuedeEnviarAUsuario());
      foreach($proveedores as $p){

      var_dump($p->nit);
      }
      die('llega en mantenimiento');
    } */
if($orden->sePuedeEnviarAUsuario()){
 ?>
<div class="alert alert-block alert-warning fade in">
  <a href="/index.php/orden/enviarAUsuario/id/<?php echo $orden->id; ?>" class="btn btn-primary">Enviar a Usuario</a>
</div>
<?php } ?>

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

<?php Yii::app()->clientScript->registerScript('register_static_css_js', "                                                                               
$(function() {                                                                                                                                         
     script_files = $('script[src]').map(function() { return $(this).attr('src'); }).get();                                                                                                                                          
     css_files = $('link[href]').map(function() { return $(this).attr('href'); }).get();                                                                                                                                          
});"); ?>

<?php Yii::app()->clientScript->registerScript('no_scripts_ajax_callback', "                                                                               



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
