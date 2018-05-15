<?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'recepcion-form-cargue',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'clientOptions'=>array(
                        'validateOnChange'=>true,
                        'validateOnSubmit'=>true
))); ?>
<div class="x_title">
    <div class='col-md-1'>
        <div class="form-actions"> 
            <?php $this->widget('bootstrap.widgets.BootButton', array(
                'buttonType'=>'button',
                'icon'=>'glyphicon glyphicon-arrow-left',
                'type'=>'primary',
                'label'=>'Atras',
                'htmlOptions' => array(
                    'id'=>'atras_desde_recepcion'
                ), 
            )); ?>
        </div>
    </div>
    <div class='col-md-11'>
        <h2>Recepción - Codigo de barras No. <?php echo $cargue->codigo_barras; ?></h2>
    </div>
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
<?php if($empresa->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($empresa)  ?> 
  </div>
<?php } ?>
<div class='col-md-6'>
    <div class='col-md-6'>
      Documento *
      <div class="form-group">
        <?php echo $form->textField($model,'documento',array('class'=>'form-control','maxlength'=>'10','onkeypress'=>'return tabular(event,this);')); ?>
      </div>
    </div>
    <div class="row">
    </div>
    <div class='col-md-6'>
      Área *
      <div class="form-group">
        <?php echo $form->dropDownList($model,'area', Areas::model()->cargaAreas(),array('class'=>'form-control',
        'ajax'=>array(
            'type'=>'POST',
            'url'=>$this->createUrl('recepcion/tipologia'),
            'update'=>'#Recepcion_tipologia'
        ),'prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
      </div>
    </div>
    <div class='col-md-6'>
        Nombre/Razón Social *
        <div class="form-group">
          <?php echo $form->textField($empresa,'razon',array('class'=>'form-control inicial','maxlength'=>'50','onkeypress'=>'return tabular(event,this);')); ?>
        </div>
    </div>
    <div class='col-md-6'>
      Tipología *
      <div class="form-group">
        <?php  echo $form->dropDownList($model,'tipologia',$tipologias,array('class'=>'form-control','prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
      </div>
    </div>
    <div class='col-md-6'>
      Departamento *
      <div class="form-group">
        <?php echo $form->dropDownList($model,'departamento', Departamento::model()->cargarDepartamentos(),array('class'=>'form-control',
        'ajax'=>array(
            'type'=>'POST',
            'url'=>$this->createUrl('recepcion/ciudades'),
            'update'=>'#Recepcion_ciudad'
        ),'prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
      </div>
    </div>
    <div class='col-md-6'>
        Póliza
        <div class="form-group">
          <?php echo $form->textField($poliza,'poliza',array('class'=>'form-control','maxlength'=>'10','onkeypress'=>'return tabular(event,this);')); ?>
        </div>
    </div>
    <div class='col-md-6'>
        Ciudad *
        <div class="form-group">
          <?php echo $form->dropDownList($model,'ciudad',$ciudades,array('class'=>'form-control','prompt'=>'...','onkeypress'=>'return tabular(event,this);')); ?>
        </div>
    </div>
    <div class='col-md-4'>
        Tipo Documento *
        <div class="form-group">
          <?php echo $form->dropDownList($model,'tipo_documento', TipoDocumento::model()->cargaDocumentoExcel(),array('class'=>'form-control','onkeypress'=>'return tabular(event,this);')); ?>
        </div>
    </div>
    <div class='col-md-4'>
        Fecha *
        <div class="form-group">
          <div class='input-group date'>
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
    <div class='col-md-8'>
      Observaciones
      <div class="form-group">
        <?php echo $form->textArea($observacion,'observacion',array('class'=>'form-control','onkeypress'=>'return tabular(event,this);')); ?>
      </div>
    </div>
    <div class="row">
    </div>
    <br>
    <div class='col-md-2'>
      <div class="form-group">
        <?php $this->widget('bootstrap.widgets.BootButton', array( 
            'buttonType'=>'submit', 
            'type'=>'success', 
            'label'=>'Guardar', 
        )); ?>
      </div>
    </div>
</div>
<div class="col-md-6 embed-container">
    <iframe src="<?php echo CargueMasivo::direccionWeb($_GET["rcp"]); ?>" width="560" height="315" frameborder="0" allowfullscreen></iframe>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        $('#Recepcion_documento, #PolizaEmpresa_poliza').keyup(function (){
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
              'url' => $this->createUrl("recepcion/razon"),
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
    $("#atras_desde_recepcion").click(function(){
      location.href="<?=Yii::app()->createUrl('/cargueMasivo/admin')?>";
      return false;
    });
</script>
<?php $this->endWidget(); ?>
