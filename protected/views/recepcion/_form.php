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
<?php /*$form=$this->beginWidget('CActiveForm', array(
  'id'=>'recepcion-form',
  'enableAjaxValidation'=>false,
)); */?>
<!-- form input knob -->
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
<div class='col-md-4'>
  Documento *
  <div class="form-group">
    <?php echo $form->textField($model,'documento',array('class'=>'form-control','maxlength'=>'10')); ?>
    <?php //echo $form->error($model, 'nit'); ?>
  </div>
</div>
<div class='col-md-4'>
  Área *
  <div class="form-group">
    <?php echo $form->dropDownList($model,'area', Areas::model()->cargaAreas(),array('class'=>'form-control',
    'ajax'=>array(
        'type'=>'POST',
        'url'=>$this->createUrl('tipologia'),
        'update'=>'#Recepcion_tipologia'
    ),'prompt'=>'...')); ?>
  </div>
</div>
<div class='col-md-4'>
  Tipología *
  <div class="form-group">
    <?php  echo $form->dropDownList($model,'tipologia',$tipologias,array('class'=>'form-control','prompt'=>'...')); ?>
  </div>
</div>
<div class='col-md-4'>
    Nombre/Razón Social *
    <div class="form-group">
      <?php echo $form->textField($empresa,'razon',array('class'=>'form-control inicial','maxlength'=>'60','onKeypress'=>'return soloLetras(event)')); ?>
    </div>
</div>
<div class='col-md-4'>
    Ciudad *
    <div class="form-group">
      <?php echo $form->dropDownList($model,'ciudad', Ciudades::model()->cargaCiudades(),array('class'=>'form-control', 'prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-4'>
    Póliza *
    <div class="form-group">
      <?php echo $form->textField($poliza,'poliza',array('class'=>'form-control','maxlength'=>'10')); ?>
    </div>
</div>
<div class='col-md-4'>
    Tipo Documento *
    <div class="form-group">
      <?php echo $form->dropDownList($model,'tipo_documento', TipoDocumento::model()->cargaDocumentos(),array('class'=>'form-control', 'prompt'=>'...')); ?>
    </div>
</div>
<div class='col-md-4'>
    Fecha *
    <div class="form-group">
      <div class='input-group date'>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
        ?>
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
         <?php echo $form->timeField($model, 'hora_entrega', array('class'=>'form-control')) ?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-time"></span>
        </span>
      </div>
    </div>
</div>
<div class='col-md-4 oculto' id="divLabel">
    Label *
    <div class="form-group">
      <?php echo $form->textField($sucursal,'label',array('class'=>'form-control','maxlength'=>'10')); ?>
    </div>
</div>
<div class='col-md-4 oculto' id="divFecha"">
    Fecha Sucursal *
    <div class="form-group">
      <div class='input-group date'>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
        ?>
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
        <?php echo $form->timeField($sucursal, 'hora_sucursal', array('class'=>'form-control')) ?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-time"></span>
        </span>
      </div>
    </div>
</div>
<div class='col-md-4 oculto' id="divDocumentos">
    No. Documentos *
    <div class="form-group">
      <?php echo $form->textField($sucursal,'no_documentos',array('class'=>'form-control', 'maxlength'=>'2')); ?>
    </div>
</div>
<div class="row">
</div>
<div class='col-md-4'>
      Observaciones
      <div class="form-group">
        <?php echo $form->textArea($observacion,'observacion',array('class'=>'form-control')); ?>
      </div>
</div>
<div class="row">
</div>
<div class='col-md-4'>
    <div class="form-group">
      <?php echo $form->fileField($adjuntos,'archivo') ; ?>
    </div>
</div>
<div class="row">
</div>
<br>
<div class='col-md-2'>
  <div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Save', array('class' => 'btn btn-lg btn-success btn-block')); ?>
  </div>
</div>
<script type="text/javascript">
  $( document ).ready(function() {
    if($("#Recepcion_tipo_documento").val() == 1){
      $("#divLabel").show();
      $("#divFecha").show();
      $("#divHora").show();
      $("#divDocumentos").show();
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
            js:$("#EmpresaPersona_razon").val(res.razon);
            js:$("#PolizaEmpresa_poliza").val(res.poliza);
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
      }else{
        $("#divLabel").hide();
        $("#divFecha").hide();
        $("#divHora").hide();
        $("#divDocumentos").hide();
      }
  });
function soloLetras(e) { // 1
  tecla = (document.all) ? e.keyCode : e.which; // 2
  if (tecla==8) return true; // 3
  patron =/[A-Za-z\s]/; // 4
  te = String.fromCharCode(tecla); // 5
  return patron.test(te); // 6
}
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