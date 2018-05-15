<?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'trazabilidad',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'clientOptions'=>array(
                        'validateOnChange'=>true,
                        'validateOnSubmit'=>true
))); ?>
<style type="text/css">
  .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>
<!--<div class="table-responsive">
  <table class="table table-bordered">
    <tr>
      <td colspan="3" align="center"><big><strong>Información De Recepción</strong></big></td>
      <td colspan="1" align="center"><?php echo Trazabilidad::model()->estadoCasoCliente($recepcion->na); ?></td>
    </tr>
    <tr class="active">
      <td><strong>No. Caso: </strong></td>
      <td><strong>Estado: </strong></td>
      <td><strong>Tipologia: </strong></td>
      <td><strong>Area: </strong></td>
    </tr>
    <tr align="center">
      <td><strong class="red"><?php echo $recepcion->na ?></strong></td>
      <td><?php echo Trazabilidad::estadoActual($recepcion->na); ?></td>
      <td><?php echo $recepcion->tipologia0->tipologia ?></td>
      <td><?php echo $recepcion->tipologia0->area0->area ?></td>
    </tr>
    <tr class="active">
      <td><strong>Tipo Documento</strong></td>
      <td><strong>Nit</strong></td>
      <td><strong>Empresa</strong></td>
      <td><strong>Poliza</strong></td>
    </tr>
    <tr align="center">
      <td><?php echo $recepcion->tipoDocumento->documento ?></td>
      <td><?php echo $recepcion->documento ?></td>
      <td><?php echo ucwords(strtolower($empresa->razon)) ?></td>
      <td><?php echo $poliza->poliza ?></td>
    </tr>
    <?php if(!empty($sucursal)){ ?>
    <tr class="active">
        <td><strong>Fecha Sucursal</strong></td>
        <td><strong>Hora Sucursal</strong></td>
        <td><strong>Label</strong></td>
        <td><strong>No. Documentos</strong></td>
    </tr>
    <tr align="center">
      <td><?php echo date("d/m/Y", strtotime($sucursal->fecha_sucursal)); ?></td>
      <td><?php echo date("h:i a", strtotime($sucursal->hora_sucursal)); ?></td>
      <td><?php echo $sucursal->label ?></td>
      <td><?php echo $sucursal->no_documentos ?></td>
    </tr>
    <?php } ?>
    <tr class="active">
      <td><strong>Fecha</strong></td>
      <td><strong>Hora</strong></td>
      <td><strong>Adjuntos</strong></td>
      <td><strong>Observaciones</strong></td>
    </tr>
    <tr align="center">
      <td><?php  echo date("d/m/Y", strtotime($recepcion->fecha_entrega)); ?></td>
      <td><?php echo date("h:i a", strtotime($recepcion->hora_entrega)); ?></td>
      <td><?php if(!empty($adjuntos)){  echo " - "; }else{ echo " - "; } ?></td>
      <td><?php if(!empty($adjuntos)){  echo " - "; }else{ echo " - "; } ?></td>
    </tr>
  </table>
</div>-->
<?php if(!empty($recepcion)){ ?>
<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading"><strong><big>Información De Recepción</big></strong></div>
    <div class="panel-body">
    <?php if($trazabilidad->user_asign != Yii::app()->user->usuario && $trazabilidad->user_asign != "1"){ ?>
      <!--<div class='col-md-10'>
      </div>
      <div class='col-md-2'>
        <h5 id="retomar" class="hand" align="right">[ <strong>Retomar</strong><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/retomar.png'); 
        echo CHtml::link($image); ?> ]</h5>
      </div>-->
    <?php } ?>  
      <div class='col-md-2'>
      	<h5><strong>No. Caso:</strong></h5>
      </div>
      <div class='col-md-1'>
      	<h5 class="red"><strong><?php echo $recepcion->na ?></strong></h5>
      </div>
      <div class='col-md-2'>
        <h5><strong>Estado:</strong></h5>
      </div>
      <div class='col-md-2'>
        <h5><?php echo Trazabilidad::estadoActual($recepcion->na); ?></h5>
      </div>
      <div class='col-md-2'>
        <h5><strong>No. Tipología</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo $recepcion->tipologia ?></h5>
      </div>
      <!--<div class='col-md-1'>
        <h5><?php //echo Trazabilidad::model()->estadoCasoInterna($recepcion->na); ?></h5>
      </div>-->
      <div class='col-md-1'>
        <h5><?php echo Trazabilidad::model()->estadoCasoCliente($recepcion->na); ?></h5>
      </div>
      <div class="row">
      </div>
      <div class='col-md-2'>
        <h5><strong>Tipología:</strong></h5>
      </div>
      <div class='col-md-6'>
        <h5><?php echo $recepcion->tipologia0->tipologia ?></h5>
      </div>
      <div class='col-md-2'>
        <h5><strong>Dirección:</strong></h5>
      </div>
      <div class='col-md-2'>
        <h5><?php echo $recepcion->tipologia0->area0->area ?></h5>
      </div>
      <div class="row">
      </div>
      <div class='col-md-1'>
        <h5><strong>Nit:</strong></h5>
      </div>
      <div class='col-md-2'>
        <h5><?php echo $recepcion->documento ?></h5>
      </div>
      <div class='col-md-2'>
        <h5><strong>Empresa:</strong></h5>
      </div>
      <div class='col-md-4'>
        <h5><?php echo ucwords(strtolower($empresa->razon)) ?></h5>
      </div>
      <div class='col-md-1'>
        <h5><strong>Póliza:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo $poliza->poliza ?></h5>
      </div>
      <div class='col-md-2'>
        <h5><strong>Tipo Documento:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo $recepcion->tipoDocumento->documento ?></h5>
      </div>
      <?php if(!empty($sucursal)){ ?>
      <div class='col-md-1'>
        <h5><strong>Label:</strong></h5>
      </div>
      <div class='col-md-2'>
        <h5><?php echo $sucursal->label ?></h5>
      </div>
      <div class='col-md-1'>
        <h5><strong>Fecha Sucursal:</strong></h5>
      </div>
      <div class='col-md-2'>
        <h5><?php echo date("d/m/Y", strtotime($sucursal->fecha_sucursal)); ?></h5>
      </div>
      <div class='col-md-2'>
        <h5><strong>Hora Sucursal:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo date("h:i a", strtotime($sucursal->hora_sucursal)); ?></h5>
      </div>
      <?php } ?>
      <div class="row">
      </div>
      <div class='col-md-1'>
        <h5><strong>Fecha:</strong></h5>
      </div>
      <div class='col-md-2'>
        <h5><?php  echo date("d/m/Y", strtotime($recepcion->fecha_entrega)); ?></h5>
      </div>
      <div class='col-md-1'>
        <h5><strong>Hora:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo date("h:i a", strtotime($recepcion->hora_entrega)); ?></h5>
      </div>
      <?php if(!empty($mail)){ ?>
      <div class='col-md-1'>
        <h5><strong>Mail:</strong></h5>
      </div>
      <div class='col-md-3'>
        <h5><?php echo $mail ?></h5>
      </div>
      <?php } ?>
      <?php if(!empty($sucursal)){ ?>
      <div class='col-md-2'>
        <h5><strong>No. Documentos:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo $sucursal->no_documentos ?></h5>
      </div>
      <?php } 
      //if(!empty($observacion)){?>
      <div class='col-md-2'>
        <h5><strong>Observaciones:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5 class="hand" id="observacion">>>Ver ...</h5>
      </div>
      <?php //} ?>
    </div>  
  </div>
</div>
<div>
  <br>
</div>  
<div class='col-md-13'>
  <?php
  $this->widget('booster.widgets.TbGridView',array(
  'id'=>'trazabilidad-grid',
  'dataProvider'=>$model->search_detalle(''),
  'template' => "{items}",
  'type' => 'bordered',
  'responsiveTable' => true,
  'columns'=>array(
      array('name'=>'Actividad','value'=>'$data->actividad0->idActividad->actividad'),
      array('name'=>'Usuario','value'=>'ucwords(strtolower($data->userAsign->nombres." ".$data->userAsign->apellidos))'),
      array('name'=>'Estado','value'=>'$data->estado0->estado'),
      array('name'=>'Fecha Asignación','value'=>'date("d/m/Y"." - "."h:i:s a", strtotime($data->fecha_asign))'),
      array('name'=>'Fecha Cierre','value'=>'(!empty($data->fecha_cierre)) ? date("d/m/Y"." - "."h:i:s a", strtotime($data->fecha_cierre)) : ""'),
      array(
        'header'=>'Gestionar',
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{gestion} {observaciones} {reasignar} {adjuntar} {retomar} {tipologia} {devolver}',
        'buttons' => array(
          'observaciones' => array(
              'label'=>'Observaciones',
              'url'=>'$data->id',
              //'icon'=>'glyphicon glyphicon-eye-open',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/observacion.png',
              //'visible' => '$data->actividad == 124',
              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
              'click'=> 'js:function(){return observaciones(this);}',
          ),
          'gestion' => array(
              'label'=>'Gestionar',
              'url'=>'$data->id',
              //'icon'=>'glyphicon glyphicon-ok',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok.png',
              'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario',
              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
              'click'=> 'js:function(){return gestion(this);}',
          ),
          'reasignar' => array(
              'label'=>'Reasignar',
              'url'=>'$data->id',
              //'icon'=>'glyphicon glyphicon-ok',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/reasignar.png',
              //'visible' => '$data->estado == 1 && Yii::app()->user->usuario == 1040742092 && $data->user_asign != 1',
              'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario && $data->validaReasignacion($data->id)',
              'click'=> 'js:function(){return reasignar(this);}',
          ),
          'adjuntar' => array(
              'label'=>'Adjuntar archivo',
              'url'=>'$data->id',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/adjunto.png',
              'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario',
              'click'=> 'js:function(){return adjuntar(this);}',
          ),
          'retomar' => array(
              'label'=>'Retomar',
              'url'=>'$data->id',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/retomar2.png',
              'visible' => '$data->estado == 1 && $data->user_asign != Yii::app()->user->usuario && $data->validaRetomar($data->actividad) && $data->user_asign != 1',
              'click'=> 'js:function(){return retomar(this);}',
          ),
          'tipologia' => array(
              'label'=>'Cambiar Tipologia',
              'url'=>'$data->id',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/atras.png',
              'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario && $data->actividad0->idActividad->id == 3',
              'click'=> 'js:function(){return cambiarTipologia(this);}',
          ),
          'devolver' => array(
              'label'=>'Devolver',
              'url'=>'$data->id',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/undo.png',
              'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario',
              'click'=> 'js:function(){return devolver(this);}',
          ),
        )
      ),
    ),
  )); ?>
</div> 
<script type="text/javascript">
  function observaciones(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id' => 'js:id'),
        'url' => $this->createUrl("observacionesTrazabilidad/index"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#body-observacion").html(data.content);
              $("#modal-observacion-trazabilidad").modal("show");
            }
        }'
      )
    );?>
    return false;
  }
  function gestion(id){
    var id_trazabilidad = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id_trazabilidad' => 'js:id_trazabilidad'),
        'url' => $this->createUrl("actividades/index"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#body-gestiontraza").html(data.content);
              $("#modal-gestiontraza").modal("show");
            }
        }'
      )
    );?>
    return false;
  }
  function devolver(id){
    var id_trazabilidad = $(id).attr("href");
    var title = '<h4>Devolución - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>';
    $("#modal-gestion .modal-header").html(title);
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id_trazabilidad' => 'js:id_trazabilidad'),
        'url' => $this->createUrl("actividadesJairo/devolver"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#body-gestion").html(data.content);
              $("#modal-gestion").modal("show");
            }
        }'
      )
    );?>
    return false;
  }
  function reasignar(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id' => 'js:id'),
        'url' => $this->createUrl("reasignar"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#body-gestion").html(data.content);
              $("#modal-gestion").modal("show");
            }
        }'
      )
    );?>
    return false;
  }
function retomar(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id' => 'js:id'),
        'url' => $this->createUrl("retomar"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              bootbox.alert({
                  message: data.content,
                  buttons: {
                    ok: {
                        label: "Aceptar",
                        className: "btn-success"
                    },
                  },
                  callback: function () {
                    parent.window.location.reload();
                  }
                }); 
            }else{
              $("#body-gestion").html(data.content);
              $("#modal-gestion").modal("show");
            }
        }'
      )
    );?>
    return false;
  }
  function adjuntar(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id' => 'js:id'),
        'url' => $this->createUrl("adjuntar"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#body-gestion").html(data.content);
              $("#modal-gestion").modal("show");
            }
        }'
      )
    );?>
    return false;
  }
  function cambiarTipologia(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id' => 'js:id'),
        'url' => $this->createUrl("cambiarTipologia"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#body-gestion").html(data.content);
              $("#modal-gestion").modal("show");
            }
        }'
      )
    );?>
    return false;
  }


</script>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-observacion')
); ?>
<div class="modal-header">
    <h4>Observación - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
</div>
<div class="modal-body" id="body-observacion-todos">
  <?php $this->renderPartial('/observacionesTrazabilidad/todos', array('model' => $obserTrazabilidad, 'na'=>$recepcion->na)) ?>
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<!--<div class="modal fade" id="modal-observacion" role="dialog">
   <div class="modal-dialog" style="width: 80%">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Observaciones - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
        </div>
        <div class="modal-body" id="body-observacion-todos"></div>
        <div class="modal-footer">
          <?php $this->widget(
              'booster.widgets.TbButton',
              array(
                  'label' => 'Cerrar',
                  'htmlOptions' => array('data-dismiss' => 'modal'),
              )
          ); ?>
       </div>
     </div>
   </div>
</div>-->
<div class="modal fade" id="modal-gestiontraza" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
              <h4>Gestión - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
          </div>
          <div class="modal-body" id="body-gestiontraza">
        </div>
          <div class="modal-footer">
              <?php $this->widget(
                  'booster.widgets.TbButton',
                  array(
                      'label' => 'Cerrar',
                      'htmlOptions' => array('data-dismiss' => 'modal'),
                  )
              ); ?>
          </div>
      </div>
    </div>
</div>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal_respuesta')
); ?>
<div class="modal-header">
    <h4>Información Destinatario</h4>
</div>
<div class="modal-body" id="body_respuesta"></div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('id' => 'btnCerrarRespuesta'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-observacion-trazabilidad')
); ?>
<div class="modal-header">
    <h4>Observaciones - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
</div>
<div class="modal-body body_observacion" id="body-observacion">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<!--<div class="modal fade" id="modal-observacion-trazabilidad" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h4>Observaciones - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
          </div>
         <div class="modal-body" id="body-observacion"></div>
         <div class="modal-footer">
          <?php $this->widget(
              'booster.widgets.TbButton',
              array(
                  'label' => 'Cerrar',
                  'htmlOptions' => array('data-dismiss' => 'modal'),
              )
          ); ?>
         </div>
      </div>
   </div>
</div>-->
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal_observacion_rta')
); ?>
<div class="modal-header">
    <h4>Observaciones - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
</div>
<div class="modal-body body_observacion" id="body_observacion_rta">
  
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('id' => 'btnObservacionRta'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array(
      'id' => 'modal-gestion',
    )
); ?>
<div class="modal-header">
    <h4>Gestión - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
</div>
<div class="modal-body" id="body-gestion">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-copias','htmlOptions' => array('data-keyboard'=>false))
); ?>
<div class="modal-header">
    <h4>Copias - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
</div>
<div class="modal-body" id="body-copias">
</div>
<div class="modal-footer">
    <?php echo CHtml::button('Cerrar', array('class' => 'btn btn-default', 'id'=>'cierre_copia')); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-fecha-cliente')
); ?>
<div class="modal-header">
    <h4>Fecha Cliente - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
</div>
<div class="modal-body" id="body-fecha-cliente">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-adjuntos',
        'htmlOptions' => array('data-dismiss' => 'modal'))
); ?>
<div class="modal-header">
    <h4>Adjuntos - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
</div>
<div class="modal-body" id="body-adjuntos">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-adjuntos-respuesta')
); ?>
<div class="modal-header">
    <h4>Adjuntos Respuesta</h4>
    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
</div>
<div class="modal-body" id="body-adjuntos-respuesta">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('id' => 'btnCerrarAdjuntos'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-imagen-tif')
); ?>
<div class="modal-header">
    <h4>Visor imagenes Tiff - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>
</div>
<div class="modal-body" id="body-imagen-tif">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal', 'id'=>'modal-imagen-tif'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<br>
<?php //if(!empty($adjuntos)){?>
<div align="left">
  <?php $this->widget(
    'booster.widgets.TbButton',
    array(
      'icon'=>'glyphicon glyphicon-paperclip',
        'label' => 'Adjuntos',
        'context' => 'success',
        'id'=>'adjuntosCaso'
    )
  );  ?>
</div>
<?php //}?>
<?php }else{ ?>
  <div class='col-md-12 ' align="center">
    <h3 class="red"><strong>No hay resultados para mostrar...</strong></h3>
  <div class='col-md-12' align="center">
    <br> 
  </div>
  <div class='col-md-12' align="center">
    <?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/stop.png'); 
    echo CHtml::link($image); ?>
  </div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php  
} ?>
<?php $this->endWidget(); ?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br> 
<script type="text/javascript">
$("#btnObservacionRta").click(function(){
  $("#modal_observacion_rta").modal("hide");
  $("#modal-gestiontraza").modal("show");
});
$("#btnCerrarRespuesta").click(function(){
  $("#modal_respuesta").modal("hide");
  $("#modal-gestiontraza").modal("show");
});
$("#btnCerrarAdjuntos").click(function(){
  $("#modal-adjuntos-respuesta").modal("hide");
  $("#modal-gestiontraza").modal("show");
});
$("#observacion").click(function(){
    //$("#modal-observacion").modal("show");
    $("#modal-observacion").modal("show");
    //var na = "<?= $recepcion->na; ?>";
    <?php /*echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('na' => 'js:na'),
        'url' => $this->createUrl("observacionesTrazabilidad/todos"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#body-observacion-todos").html(data.content);
            }
        }'
      )
  );*/?>
});
$("#fecha_cliente").click(function(){
    var na = "<?= $recepcion->na; ?>";
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('na' => 'js:na'),
        'url' => $this->createUrl("recepcion/fechaCliente"),
        'dataType'=>'json',
        'success' => 'function(data){
          if(data.status == "success"){
            $("#modal-fecha-cliente #body-fecha-cliente").html(data.content);
            $("#modal-fecha-cliente").modal("show");
          }
        }'
      )
  );?>
});
$("#retomar").click(function(){
  if(confirm("¿Desea retomar el caso?")){   
    var na = "<?= $recepcion->na; ?>";
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('na' => 'js:na'),
        'url' => $this->createUrl("retomarCaso"),
        'dataType'=>'json',
        'success' => 'function(data){
          parent.window.location.reload();
        }'
      )
    );?>
    return false;
  }
});
$("#adjuntosCaso").click(function(){
    var na = "<?= $recepcion->na; ?>";
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('na' => 'js:na'),
        'url' => $this->createUrl("adjuntosTrazabilidad/admin"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#modal-adjuntos #body-adjuntos").html(data.content);
              $("#modal-adjuntos").modal("show");
            }
        }'
      )
  );?>
});
$("#modal-imagen-tif").click(function(){
  $("#modal-adjuntos").modal("show");
});
$('#modal-gestion').on('hide.bs.modal', function (e) {
    var title = '<h4>Gestión - No. Caso <strong class="red"><?php echo $recepcion->na ?></strong></h4>';
    $("#modal-gestion .modal-header").html(title);
});
</script>