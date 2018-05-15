<?php 
$this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Nuevo Producto',
        'context' => 'warning',
        'id'=>'btn_crear_producto',
        'url'=>$this->createUrl("orden/createSolicitud", array('id_orden'=>$orden->id)),
        'htmlOptions' => array(
            'href'=>$this->createUrl("orden/createSolicitud", array('id_orden'=>$orden->id)),
        ),
    )
);

$this->widget('booster.widgets.TbGridView',array( 
                'id'=>'orden-solicitud-grid', 
                'dataProvider'=>$model->search($orden->id), 
                //'filter'=>$model_orden_solicitud_costos,
                'type'=>'striped bordered condensed',
                //'htmlOptions' => array('style' => 'width:758px;'),
                'columns'=>array( 
                  'nombre',
                  'cantidad',
                  'detalle',
                  array( 
                    'htmlOptions' => array('nowrap'=>'nowrap', 'class'=>'grid-solicitud-orden'),
                    'class'=>'booster.widgets.TbButtonColumn', 
                    'template' => '{update} {eliminar}',
                    'buttons'=>array(
                      'eliminar' => array(
                        'label'=>'<i class="glyphicon glyphicon-trash"></i>',
                        'url'=>'Yii::app()->createUrl("orden/deleteSolicitud", array("id"=>$data->id))',
                        'options'=>array('class'=>'delete'),
                      ),
                    ),
                    'updateButtonUrl'=>'CController::createUrl("/orden/updateSolicitud", array("id_orden_solicitud"=>$data->id, "actualizar_modal" => true))',
                  ), 
                ), 
                )); 

/*$this->widget('booster.widgets.TbGridView', array(
  'id'=>'agregar-producto',
    'filter'=>$detalle,
    'type'=>'striped bordered',
    'dataProvider' => $detalle->search_om($om),
    //'afterAjaxUpdate' => "function(id,data){console.log(id); console.log(data);}",
    'template' => "{items}",
    'columns' => array(

    ),
));

    if($paso_actual != "swOrden/en_negociacion" and $paso_actual != "swOrden/analista_compras"){
    $this->widget('bootstrap.widgets.BootButton', array(
      'type'=>'warning',
      'label'=>'Nuevo Producto',
      'htmlOptions' => array(
        'onclick'=>CHtml::ajax(array(
          'url' => '/index.php/orden/createSolicitud/id_orden/'.$model->id,
          'success' => 'function(data){
              $(".accordion-body.collapse.in").collapse("hide");
              clean_response_generic("#accordion2", data, "append");
              updateProductNumber();
          }'
        )),
        'style' => 'margin-bottom:15px;'
      )
    )); 
    }else{ ?>
      
      <script type="text/javascript">
        $(function(){
          $('#info-orden-id input, #info-orden-id textarea, #info-orden-id select').attr('disabled', 'disabled');
        });
      </script>
      
    <?php }
    ?>
    <div id="detalle"></div>
    
    <div id="solicitudes-container">
      
      <div class="accordion" id="accordion2">
      
      <?php
        $solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $model->id), array('order' => 'id ASC'));
        if(count($solicitudes) > 0){
          foreach($solicitudes as $s){
            $model_orden_solicitud_costos=new OrdenSolicitudCostos('search');
            $model_orden_solicitud_costos->unsetAttributes();  // clear any default values
            if(isset($_GET['OrdenSolicitudCostos'])){
              $model_orden_solicitud_costos->attributes=$_GET['OrdenSolicitudCostos'];
            }
            
            $model_orden_solicitud_proveedor=new OrdenSolicitudProveedor('search');
            $model_orden_solicitud_proveedor->unsetAttributes();  // clear any default values
            if(isset($_GET['OrdenSolicitudProveedor'])){
              $model_orden_solicitud_proveedor->attributes=$_GET['OrdenSolicitudProveedor'];
            }
            
            $model_orden_solicitud_direccion=new OrdenSolicitudDireccion('search');
            $model_orden_solicitud_direccion->unsetAttributes();  // clear any default values
            if(isset($_GET['OrdenSolicitudDireccion'])){
              $model_orden_solicitud_direccion->attributes=$_GET['OrdenSolicitudDireccion'];
            }
            
            $arch=new AdjuntosOrden('search');
            $arch->unsetAttributes();  // clear any default values
            if(isset($_GET['AdjuntosOrden'])){
              $arch->attributes=$_GET['AdjuntosOrden'];
            }
            ?>
            
                  
          <?php
            if($paso_actual == "swOrden/en_negociacion" or $paso_actual == "swOrden/analista_compras"){
              echo $this->renderPartial('_orden_solicitud_readonly', array('model' => $s, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'divid' => $s->id, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
            }else{
              echo $this->renderPartial('_orden_solicitud_form', array('model' => $s, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'divid' => $s->id, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
            }
            ?>
            <?php
          }
        }
    </div>
  </div>
      */
      ?>