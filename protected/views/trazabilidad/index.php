<?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'trazabilidad',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'clientOptions'=>array(
                        'validateOnChange'=>true,
                        'validateOnSubmit'=>true
))); 
/*$imagesDir = dirname(__FILE__).'/../../images/'; 
echo CHtml::image(Yii::app()->assetManager->publish($imagesDir.'circle_green.png'),"",array("style"=>"width:20px;height:20px;"));
*/?>

<style type="text/css">
  .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>
<?php if(!empty($recepcion)){ ?>
<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading"><strong><big>Información De Recepción</big></strong></div>
    <div class="panel-body">
    <?php if($trazabilidad->user_asign != Yii::app()->user->usuario && $trazabilidad->user_asign != "1"){ ?>
      <div class='col-md-12'>
        <h5 id="retomar" class="hand" align="right">[ <strong>Retomar</strong><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/retomar.png'); 
        echo CHtml::link($image); ?> ]</h5>
      </div>
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
        <h5><?php echo $trazabilidad->estado0->estado ?></h5>
      </div>
      <div class='col-md-3'>
        <h5><strong>No. Tipología</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo $recepcion->tipologia ?></h5>
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
        <h5><?php echo $tipologia->area0->area ?></h5>
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
        <h5><?php echo $sucursal->fecha_sucursal ?></h5>
      </div>
      <div class='col-md-2'>
        <h5><strong>Hora Sucursal:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo $sucursal->hora_sucursal ?></h5>
      </div>
      <?php } ?>
      <div class="row">
      </div>
      <div class='col-md-1'>
        <h5><strong>Fecha:</strong></h5>
      </div>
      <div class='col-md-2'>
        <h5><?php echo $recepcion->fecha_entrega ?></h5>
      </div>
      <div class='col-md-1'>
        <h5><strong>Hora:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo $recepcion->hora_entrega ?></h5>
      </div>
      <?php if(!empty($sucursal)){ ?>
      <div class='col-md-3'>
        <h5><strong>No. Documentos:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5><?php echo $sucursal->no_documentos ?></h5>
      </div>
      <?php } ?>
      <?php if(!empty($observacion)){ ?>
      <div class='col-md-2'>
        <h5><strong>Observación:</strong></h5>
      </div>
      <div class='col-md-1'>
        <h5 class="hand" id="observacion">>>Ver ...</h5>
      </div>
      <?php } ?>
    </div>  
  </div>
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
      /*array(
            'name'=>'Prioridad',
            'type'=>'html',
            'value'=>'$data->estado()',
            'htmlOptions'=>array('style'=>'text-align: center;')
        ),*/
      array('name'=>'Actividad','value'=>'$data->actividad0->actividad0->actividad'),
      array('name'=>'Usuario','value'=>'ucwords(strtolower($data->user_asign0->nombres." ".$data->user_asign0->apellidos))'),
      array('name'=>'Estado','value'=>'$data->estado0->estado'),
      array('name'=>'Fecha Asignación','value'=>'$data->fecha_asign'),
      array('name'=>'Fecha Cierre','value'=>'$data->fecha_cierre'),
      array(
        'header'=>'Gestionar',
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{gestion} {observaciones} {reasignar} {adjuntar}',
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
              'visible' => '$data->estado == 1 && Yii::app()->user->usuario == 1040742092 && $data->user_asign != 1',
              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
              'click'=> 'js:function(){return reasignar(this);}',
          ),
          'adjuntar' => array(
              'label'=>'Adjuntar archivo',
              'url'=>'$data->id',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/adjunto.png',
              'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario',
              'click'=> 'js:function(){return adjuntar(this);}',
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
              $("#modal-observacion-trazabilidad #body-observacion").html(data.content);
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
              $("#modal-gestion #body-gestion").html(data.content);
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
              $("#modal-gestion #body-gestion").html(data.content);
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
              $("#modal-gestion #body-gestion").html(data.content);
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
    <h4>Observación</h4>
</div>
<div class="modal-body">
  <h5><?php echo $observacion->observacion ?></h5>
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
    array('id' => 'modal-observacion-trazabilidad')
); ?>
<div class="modal-header">
    <h4>Observaciones</h4>
</div>
<div class="modal-body" id="body-observacion">
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
    array('id' => 'modal-gestion')
); ?>
<div class="modal-header">
    <h4>Gestión</h4>
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
    array('id' => 'modal-copias')
); ?>
<div class="modal-header">
    <h4>Copias</h4>
</div>
<div class="modal-body" id="body-copias">
</div>
<div class="modal-footer">
    <?php echo CHtml::button('Cerrar', array('class' => 'btn btn-default', 'id'=>'cierre_copia')); ?>
</div>
<?php $this->endWidget(); ?>
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
$("#observacion").click(function(){
    //$("#modal-observacion").modal("show");
    var na = "<?= $recepcion->na; ?>";
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('na' => 'js:na'),
        'url' => $this->createUrl("observacionRecepcion/index"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#modal-observacion-trazabilidad #body-observacion").html(data.content);
              $("#modal-observacion-trazabilidad").modal("show");
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
</script>