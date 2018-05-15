<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = true;
}?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array( 
	'id'=>'form-generaRespuesta',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> "jQuery.ajax({
      'url':'".Yii::app()->createUrl('actividades/index')."',
      'dataType':'json',
      'data':$(this).serialize(),
      'type':'post',
      'success':function(data){
        if(data.status == 'success'){
          $('#modal-gestiontraza').modal('hide'); 
          $('#trazabilidad-grid').yiiGridView.update('trazabilidad-grid');
        }else{	
          $('#body-gestiontraza').html(data.content);
        }
      },
      'cache':false
    });
    return false;",
		'enctype' => 'multipart/form-data',
	),
));?>
<?php echo $form->errorSummary($model)  ?> 
<?= $form->hiddenField($model, 'id_traza')?>
<?= $form->textArea($model,'carta',array('class'=>'form-control oculto')); ?>
<div class="row">
  <div class='col-md-4'>
    <?php echo $form->labelEx($model,'plantilla'); ?>
    <div class="form-group">
      <?php echo $form->dropDownList($model,'plantilla', PlantillasCartas::cargaPlantillas($recepcion->tipologia),array('class'=>'form-control', 
    'prompt'=>'...')); ?>
    </div>
  </div>
  <div class='col-md-3'></div>
  <div class='col-md-3' align="right">
    <div class="btn-group btn-group-md" role="group" aria-label="">
      <button type="button" id="btnObsRespuesta" class="btn btn-success oculto">
        <i class="glyphicon glyphicon-comment"></i> Agregar Observación
      </button>
    </div>
  </div>
  <div class='col-md-2' align="right">
    <div class="btn-group btn-group-md" role="group" aria-label="">
      <button type="button" id="creaRespuesta" class="btn btn-success oculto">
        <i class="glyphicon glyphicon-envelope"></i> Crear Copia
      </button>
    </div>
  </div>
</div>
<div class="row">
  <div class='col-md-8 oculto' id="editor">
      <div class="form-group">
        <?php $this->widget(
          'booster.widgets.TbCKEditor',
          array(
          	'model' => $model,
          	'attribute'=>'texto',
            'editorOptions' => array(
                'plugins' => 'basicstyles,toolbar,enterkey,entities,floatingspace,wysiwygarea,indentlist,link,list,dialog,dialogui,button,indent,fakeobjects'
            ),
            'value'=>$model->texto,
          )
        );?>
      </div>
  </div>
  <div class='col-md-4 oculto' id="adjuntos">
    <div class="btn-group btn-group-md" role="group" aria-label="">
      <button type="button" id="btnAdjunto" class="btn btn-success">
        <i class="glyphicon glyphicon-paperclip"></i> Adjuntar Documentos
      </button>
    </div>
    <br>
    <div id="gridViewAdjunto"></div>
  </div>
</div>
<div class="row">
  <div class="col-md-12" id="gridViewRespuestas"></div>
</div>
<div class="row"></div>
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit', 
			'type'=>'success',
			'label'=>'Guardar',
      'htmlOptions' => array('id'=>'gestion_carta'), 
		)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
  $( document ).ready(function() {
    $('#gestion_carta').val('Guardar').attr('disabled', false);

    $("#gestion_carta").click(function(){
      var carta = CKEDITOR.instances.CartaPlantilla_texto.getData();
      $("#CartaPlantilla_carta").val(carta);
    });
    $('#form-generaRespuesta').on('submit', function(e){
      $('#gestion_carta').html('Espere...').attr('disabled', 'disabled');
    });
    var id_plantilla = "<?=$model->plantilla ?>";
    if(id_plantilla != ""){
      $('#creaRespuesta').show();
      $('#btnObsRespuesta').show();
      $('#gridViewRespuestas').show();
      $("#editor").show();
      $("#adjuntos").show();
    }
    cartasRespuesta("<?=$recepcion->na ?>", "<?=$id_traza ?>");
    adjuntosRespuesta("<?=$id_traza ?>");
  });
  $("#CartaPlantilla_plantilla").change(function(){
    var id_carta = $('#CartaPlantilla_plantilla').val();
      if(id_carta != ""){
        $('#creaRespuesta').show();
        $('#btnObsRespuesta').show();
        $('#gridViewRespuestas').show();
        $("#editor").show();
        $("#adjuntos").show();
        CKEDITOR.instances.CartaPlantilla_texto.editable().setHtml('<br>');
        <?php echo CHtml::ajax(          
          array(
            'type' => 'POST',
            'data' => array('id_carta' => 'js:id_carta'),
            'url' => $this->createUrl("carta"),
            'success' => 'function(res){              
              js:CKEDITOR.instances.CartaPlantilla_texto.editable().setHtml(res);
            }'
          )
        );?>
        CKEDITOR.instances.CartaPlantilla_texto.focus();       
      }else{
        $('#creaRespuesta').hide();
        $('#btnObsRespuesta').hide();
        $('#gridViewRespuestas').hide();
        $("#editor").hide();    
        $("#adjuntos").hide();
        CKEDITOR.instances.CartaPlantilla_texto.editable().setHtml('<br>');        
      }
  });
  $("#creaRespuesta").click(function(){
    var na = "<?=$recepcion->na ?>";
    var id_traza = "<?=$id_traza ?>";
    var carta = CKEDITOR.instances.CartaPlantilla_texto.getData();
    var id_plantilla = $("#CartaPlantilla_plantilla").val();
    <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'url' => $this->createUrl("cartas/creaRespuesta"),
          'data' => array(
            'na'=>'js:na', 
            'id_traza'=>'js:id_traza',
            'carta'=>'js:carta',
            'id_plantilla'=>'js:id_plantilla',
          ),
          'dataType'=>'json',
          'success' => 'function(data){
              if(data.status == "success"){
                $(".modal").modal("hide");
                $("#body_respuesta").html(data.content);
                $("#modal_respuesta").modal("show");
              }
          }'
        )
    );?>
  });
  $("#btnObsRespuesta").click(function(){
    observacionRespuesta();
  });
  $("#btnAdjunto").click(function(){
        var id_trazabilidad = "<?=$id_traza ?>";
        <?php echo CHtml::ajax(
          array(
            'type' => 'POST',
            'data' => array('id_trazabilidad' => 'js:id_trazabilidad'),
            'url' => $this->createUrl("cargarDocumento"),
            'dataType'=>'json',
            'success' => 'function(data){
                if(data.status == "success"){
                  $(".modal").modal("hide");
                  $("#body-adjuntos-respuesta").html(data.content);
                  $("#modal-adjuntos-respuesta").modal("show");
                }
            }'
          )
      );?>
    });
  function cartasRespuesta(na, id_traza){
      <?php echo CHtml::ajax(
        array(
            'type' => 'POST',
            'data' => array(
              'na' => 'js:na',
              'id_traza' => 'js:id_traza'
            ),
            'dataType'=>'json',
            'url' => $this->createUrl("cartasRespuesta"),
            'success' => 'function(res){
              if(res.status == "success"){
                js:$("#gridViewRespuestas").html(res.content);
              }else{
                js:$("#gridViewRespuestas").html("");
              }
            }'
        )
      );?>
  }
  function editar(id) {
    var id = $(id).attr("href");
    var id_traza = "<?=$id_traza ?>";
    var carta = CKEDITOR.instances.CartaPlantilla_texto.getData();
     var id_plantilla = $("#CartaPlantilla_plantilla").val();
    <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'url' => $this->createUrl("cartas/editaRespuesta"),
          'data' => array(
            'id' => 'js:id',
            'carta' => 'js:carta',
            'id_plantilla'=>'js:id_plantilla',
          ),
          'dataType'=>'json',
          'success' => 'function(data){
            if(data.status == "success"){
              $(".modal").modal("hide");            
              $("#body_respuesta").html(data.content);
              $("#modal_respuesta").modal("show");
            }
          }'
        )
    );?>      
    return false;
  }
  function eliminar(id) {
    var id = $(id).attr("href");
    var na = "<?=$recepcion->na ?>";
    var id_trazabilidad = "<?=$id_traza ?>";

    bootbox.confirm({
      message: "<h4>¿Esta seguro que desea eliminar la respuesta?</h4><br><h5> - Si lo elimina, no podra recuperarlo.</h5>",
      buttons: {
          confirm: {
              label: 'Confirmar',
              className: 'btn-success'
          },
          cancel: {
              label: 'Cancelar',
              className: 'btn-default'
          }
      },
      callback: function (confirm) {
        if(confirm){
          <?php echo CHtml::ajax(
              array(
                'type' => 'POST',
                'data' => array('id' => 'js:id'),
                'url' => $this->createUrl("eliminarCarta"),
                'async'=>true,
                'success' => 'function(data){
                  cartasRespuesta(na, id_trazabilidad);
                }'
              )
          );?>
        }
      }
    });
    return false;
  }
  function adjuntosRespuesta(id_trazabilidad){
      <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'data' => array('id_trazabilidad' => 'js:id_trazabilidad'),
          'dataType'=>'json',
          'url' => $this->createUrl("adjuntosRespuesta"),
          'success' => 'function(res){
            if(res.status == "success"){
              js:$("#gridViewAdjunto").html(res.content);
            }else{
              js:$("#gridViewAdjunto").html("");
            }
          }'
        )
      );?>
  }
  function eliminarAdj(id){
    var id = $(id).attr("href");
    var id_trazabilidad = "<?=$id_traza ?>";
    bootbox.confirm({
      message: "<h4>¿Esta seguro que desea eliminar el adjunto?</h4><br><h5>- Si lo elimina, no podrá recuperarlo.</h5>",
      buttons: {
          confirm: {
              label: 'Confirmar',
              className: 'btn-success'
          },
          cancel: {
              label: 'Cancelar',
              className: 'btn-default'
          }
      },
      callback: function (confirm) {
        if(confirm){
          <?php echo CHtml::ajax(
              array(
                'type' => 'POST',
                'data' => array('id' => 'js:id'),
                'url' => $this->createUrl("eliminarAdjunto"),
                'async'=>true,
                'success' => 'function(data){
                  if(data){
                    adjuntosRespuesta(id_trazabilidad);
                  }
                }'
              )
          );?>
        }
      }
    });
    return false;
  }
  function observacionRespuesta(){
    var id_traza = "<?=$id_traza ?>";
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id' => 'js:id_traza'),
        'url' => $this->createUrl("observacionesTrazabilidad/index"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $(".modal").modal("hide");
              $("#body_observacion_rta").html(data.content);
              $("#modal_observacion_rta").modal("show");
            }
        }'
      )
    );?>
    return false;
  }
</script>