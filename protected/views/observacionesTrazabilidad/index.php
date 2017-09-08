<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-observacion',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\'/correspondencia/index.php/observacionesTrazabilidad/index\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#body-observacion\').html(data.content); $(\'#ObservacionesTrazabilidad_observacion\').val(\'\');}else{	$(\'#body-observacion\').html(data.content);}},\'cache\':false});return false;'
	)
)); ?>
<?php if($model->hasErrors()){ ?>
  <div class="bg-danger alertaImagine">
    <?php echo $form->errorSummary($model)  ?> 
  </div>
<?php } ?>
<div class='col-md-12'>
  <?php if(!empty($consulta)){
    $this->widget('booster.widgets.TbGridView',array(
        'id'=>'observaciones-grid',
        'dataProvider'=>$model->search_detalle(),
        'type' => 'bordered',
        'responsiveTable' => true,
        'columns'=>array(
            array('name'=>'Fecha','value'=>'$data->fecha'),
            array('name'=>'Usuario','value'=>'$data->usuario'),
            array('name'=>'Observación','value'=>'$data->observacion'),
          ),
        )); 
      } ?>
</div>
<div class='col-md-12 oculto'>
    <div class="form-group">
      <?php echo $form->textField($model,'na',array('class'=>'form-control')); ?>
    </div>
</div>
<div class='col-md-12 oculto'>
    <div class="form-group">
      <?php echo $form->textField($model,'id_trazabilidad',array('class'=>'form-control')); ?>
    </div>
</div>
<div class='col-md-12 oculto' id="agregarObs">
    <div class="form-group">
      <?php echo $form->textArea($model,'observacion',array('class'=>'form-control')); ?>
    </div>
</div>
<div class='col-md-7 oculto' align="right" id="block-agregar">    
  <?php echo CHtml::button('Agregar', array('class' => 'btn btn-success','value'=>'Agregar','id'=>'agregar')); ?>
</div>
<div class='col-md-7 oculto' align="right" id="block-guardar">    
  <?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-success','value'=>'Guardar','id'=>'guardar')); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#block-agregar").show();
  });
  $("#agregar").click(function(){
     $("#agregarObs").show();
     $("#block-agregar").hide();
     $("#block-guardar").show();
     $("#ObservacionesTrazabilidad_observacion").focus();
  });

</script>
