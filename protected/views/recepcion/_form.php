<?php Yii::app()->clientScript->registerCoreScript('yiiactiveform'); ?>
<?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'recepcion-form',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'clientOptions'=>array(
                        'validateOnChange'=>true,
                        'validateOnSubmit'=>true
))); ?>
<div class="x_title">
  <h2>Recepción</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<?php if($model->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($model)  ?> 
  </div>
<?php } ?>
<?php if($sucursal->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($sucursal)  ?> 
  </div>
<?php } ?>
<?php if($empresa->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($empresa)  ?> 
  </div>
<?php } ?>
<?php if($mail->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($mail)  ?> 
  </div>
<?php } ?>
<?php echo $form->hiddenField($model,'na',array('class'=>'form-control')); ?>
<div class='col-md-4'>
  Documento *
  <div class="form-group">
    <?php echo $form->textField($model,'documento',array('class'=>'form-control','maxlength'=>'10','onkeypress'=>'return tabular(event,this);')); ?>
    <?php //echo $form->error($model, 'nit'); ?>
  </div>
</div>
<div class="row">
</div>
<div class='col-md-4'>
  Área *
  <div class="form-group">
    <?php echo $form->dropDownList($model,'area', Areas::model()->cargaAreas(),array('class'=>'form-control',
    'ajax'=>array(
        'type'=>'POST',
        'url'=>$this->createUrl('tipologia'),
        'update'=>'#Recepcion_tipologia'
    ),'prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
  </div>
</div>
<div class='col-md-4'>
  Tipología *
  <div class="form-group">
    <?php  echo $form->dropDownList($model,'tipologia',$tipologias,array('class'=>'form-control','prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
  </div>
</div>
<div class='col-md-4'>
    Nombre/Razón Social *
    <div class="form-group">
      <?php echo $form->textField($empresa,'razon',array('class'=>'form-control inicial','maxlength'=>'50','onkeypress'=>'return tabular(event,this);')); ?>
    </div>
</div>
<div class='col-md-4'>
  Departamento *
  <div class="form-group">
    <?php echo $form->dropDownList($model,'departamento', Departamento::model()->cargarDepartamentos(),array('class'=>'form-control',
    'ajax'=>array(
        'type'=>'POST',
        'url'=>$this->createUrl('ciudades'),
        'update'=>'#Recepcion_ciudad'
    ),'prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
  </div>
</div>
<div class='col-md-4'>
    Ciudad *
    <div class="form-group">
      <?php echo $form->dropDownList($model,'ciudad',$ciudades,array('class'=>'form-control','prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
    </div>
</div>
<div class='col-md-4'>
    Póliza
    <div class="form-group">
      <?php echo $form->textField($poliza,'poliza',array('class'=>'form-control','maxlength'=>'10','onkeypress'=>'return tabular(event,this);')); ?>
    </div>
</div>
<div class='col-md-4'>
    Tipo Documento *
    <div class="form-group">
      <?php echo $form->dropDownList($model,'tipo_documento', TipoDocumento::model()->cargaDocumentos(),array('class'=>'form-control', 'prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
    </div>
</div>
<div class='col-md-4'>
    Fecha *
    <div class="form-group">
      <div class='input-group date'>
        <?php
        /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model'=>$model,
        'attribute'=>'fecha_entrega',
        'language' => "es",
        'options' => array(
        'autoclose'=>true,
        'dateFormat' => "yymmdd",
        'maxDate' => "yymmdd",
        ),
        'htmlOptions' => array('class'=>'form-control'),
        ));
        */?>
        <?php $this->widget('booster.widgets.TbDatePicker',   
          array(
            'model'=>$model,
            'attribute'=>'fecha_entrega',
            'options' => array(
              'language' => "es",
              'autoclose'=>true,
              'dateFormat' => date("Ymd"),
              'endDate' => date("Ymd"),
            ),
            'htmlOptions' => array(
                  'class'=>'form-control','onkeypress'=>'return tabular(event,this);'
              ),
          )
        );?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>         
    </div>
</div>
<div class='col-md-4'>
    Hora *
    <div class="form-group">
      <div class='input-group date'>
         <?php echo $form->timeField($model, 'hora_entrega', array('class'=>'form-control','onkeypress'=>'return tabular(event,this);')) ?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-time"></span>
        </span>
      </div>
    </div>
</div>
<div class='col-md-4 oculto' id="mail_recepcion">
    Mail *
    <div class="form-group">
      <?php echo $form->textField($mail,'mail',array('class'=>'form-control','maxlength'=>'40','onkeypress'=>'return tabular(event,this);')); ?>
    </div>
</div>
<div class='col-md-4 oculto' id="divLabel">
    Label *
    <div class="form-group">
      <?php echo $form->textField($sucursal,'label',array('class'=>'form-control','maxlength'=>'10','onkeypress'=>'return tabular(event,this);')); ?>
    </div>
</div>
<div class='col-md-4 oculto' id="divFecha"">
    Fecha Sucursal *
    <div class="form-group">
      <div class='input-group date'>
        <?php
        /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model'=>$sucursal,
        'attribute'=>'fecha_sucursal',
        'language' => "es",
        'options' => array(
        'autoclose'=>true,
        'dateFormat' => "yymmdd",
        'maxDate' => "yymmdd",
        ),
        'htmlOptions' => array('class'=>'form-control'),
        ));
        */?>
        <?php $this->widget('booster.widgets.TbDatePicker',   
          array(
            'model'=>$sucursal,
            'attribute'=>'fecha_sucursal',
            'options' => array(
              'language' => "es",
              'autoclose'=>true,
              'dateFormat' => date("Ymd"),
              'endDate' => date("Ymd"),
            ),
            'htmlOptions' => array(
                  'class'=>'form-control','onkeypress'=>'return tabular(event,this);'
            ),
          )
        );?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>         
    </div>
</div>
<div class='col-md-4 oculto' id="divHora">
    Hora Sucursal *
    <div class="form-group">
      <div class='input-group date'>
        <?php echo $form->timeField($sucursal, 'hora_sucursal', array('class'=>'form-control','onkeypress'=>'return tabular(event,this);')) ?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-time"></span>
        </span>
      </div>
    </div>
</div>
<div class='col-md-4 oculto' id="divDocumentos">
    No. Documentos *
    <div class="form-group">
      <?php echo $form->textField($sucursal,'no_documentos',array('class'=>'form-control', 'maxlength'=>'2','onkeypress'=>'return tabular(event,this);')); ?>
    </div>
</div>
<div class="row">
</div>
<div class='col-md-4'>
      Observaciones
      <div class="form-group">
        <?php echo $form->textArea($observacion,'observacion',array('class'=>'form-control','onkeypress'=>'return tabular(event,this);')); ?>
      </div>
</div>
<div class='col-md-2'>
<br>
  <?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/adjuntos_recepcion2.png','this is alt tag of image',
        array('height'=>'45','title'=>'Adjuntar archivo','id'=>'adjuntos_recepcion_imagen')); 
        echo CHtml::link($image); ?>
</div>
<div class="row">
</div>
<div class='col-md-4'>
    <div class="form-group">
      <?php //echo $form->fileField($adjuntos,'archivo',array('onkeypress'=>'return tabular(event,this);')) ; ?>
      <?//php echo $form->fileField($adjuntos,'archivo', array('multiple'=>true)) ; ?>
    </div>
</div>
<div class="row">
</div>
<div class="col-md-2" id="gridViewAdjuntos">
</div>
<br>
<div class="row">
</div>
<div class='col-md-2'>
  <div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', array('class' => 'btn btn-lg btn-success btn-block')); ?>
  </div>
</div>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-adjuntos-recepcion')
); ?>
<div class="modal-header">
    <h4>Adjuntos</h4>
</div>
<div class="modal-body" id="body-adjuntos-recepcion">
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
<div class="modal fade" id="modal-visor_tif_recepcion" role="dialog">
    <!--<div class="modal-dialog" style="width: 80%">-->
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="col-md-11"><h4>Visor</h4></div>
          <div class="col-md-1"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></div>
        </div>
        <div class="modal-body" id="body-visor_tif_recepcion" style="max-height: calc(100vh - 210px); overflow-y: auto;"></div>
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
<script type="text/javascript">
  $( document ).ready(function() {
    adjuntosRecepcion("<?=$model->na ?>");
    if($("#Recepcion_tipo_documento").val() == 1){
      $("#divLabel").show();
      $("#divFecha").show();
      $("#divHora").show();
      $("#divDocumentos").show();
    }
    if($("#Recepcion_tipo_documento").val() == 2){
      $("#mail_recepcion").show();
    }
    $('#Recepcion_documento, #PolizaEmpresa_poliza, #SucursalRecepcion_label, #SucursalRecepcion_no_documentos').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    
  });
  $("#Recepcion_documento").blur(function(){
    var nit = $('#Recepcion_documento').val();
    if(nit != ""){
      <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'data' => array('nit' => 'js:nit'),
          'dataType'=>'json',
          'url' => $this->createUrl("razon"),
          'success' => 'function(res){
            if(res != null){
              if(res.razon != null){
                js:$("#EmpresaPersona_razon").val(res.razon);
                $("#EmpresaPersona_razon").attr("readonly", "true");
              }
              if(res.poliza != null){
                js:$("#PolizaEmpresa_poliza").val(res.poliza);
                $("#PolizaEmpresa_poliza").attr("readonly", "true");
              }
            }else{
                js:$("#EmpresaPersona_razon").val("");
                $("#EmpresaPersona_razon").removeAttr("readonly");
                js:$("#PolizaEmpresa_poliza").val("");
                $("#PolizaEmpresa_poliza").removeAttr("readonly");
            }
          }'
        )
      );?>
    }
  });
  $("#Recepcion_tipo_documento").change(function(){
      var tipo_doc = $("#Recepcion_tipo_documento").val();
      if(tipo_doc == 1){
        $("#divLabel").show();
        $("#divFecha").show();
        $("#divHora").show();
        $("#divDocumentos").show();
        $("#mail_recepcion").hide();
        $("#MailRecepcion_mail").val("");
      }else if(tipo_doc == 2){
        $("#mail_recepcion").show();
        $("#divLabel").hide();
        $("#divFecha").hide();
        $("#divHora").hide();
        $("#divDocumentos").hide();
        $("#SucursalRecepcion_label").val("");
        $("#SucursalRecepcion_fecha_sucursal").val("");
        $("#SucursalRecepcion_hora_sucursal").val("");
        $("#SucursalRecepcion_no_documentos").val("");
      }else{
        $("#divLabel").hide();
        $("#divFecha").hide();
        $("#divHora").hide();
        $("#divDocumentos").hide();
        $("#mail_recepcion").hide();
        $("#MailRecepcion_mail").val("");
        $("#SucursalRecepcion_label").val("");
        $("#SucursalRecepcion_fecha_sucursal").val("");
        $("#SucursalRecepcion_hora_sucursal").val("");
        $("#SucursalRecepcion_no_documentos").val("");
      }
  });

function adjuntosRecepcion(na){
  <?php echo CHtml::ajax(
    array(
      'type' => 'POST',
      'data' => array('na' => 'js:na'),
      'dataType'=>'json',
      'url' => $this->createUrl("adjuntosRecepcion"),
      'success' => 'function(res){
        if(res.status == "success"){
          js:$("#gridViewAdjuntos").html(res.content);
        }else{
          js:$("#gridViewAdjuntos").html("");
        }
      }'
    )
  );?>
}
function soloLetras(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==8) return true;
  patron =/[A-Za-z-ñ\s]/;
  te = String.fromCharCode(tecla);
  return patron.test(te);
}
function tabular(e,obj) {
  tecla=(document.all) ? e.keyCode : e.which; 
  if(tecla!=13) return; 
  frm=obj.form; 
  for(i=0;i<frm.elements.length;i++)  
    if(frm.elements[i]==obj) {  
      if (i==frm.elements.length-1) i=-1; 
      break } 
  frm.elements[i+1].focus(); 
  return false; 
}
$("#adjuntos_recepcion_imagen").click(function(){
    var na = $("#Recepcion_na").val();
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('na' => 'js:na'),
        'url' => $this->createUrl("cargarDocumento"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#modal-adjuntos-recepcion #body-adjuntos-recepcion").html(data.content);
              $("#modal-adjuntos-recepcion").modal("show");
            }
        }'
      )
  );?>
});
</script>
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