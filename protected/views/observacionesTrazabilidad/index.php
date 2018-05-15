<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
  $cs->scriptMap['jquery.yiigridview.js'] = false;
}
$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
  'id'=>'form-observacionTraza',
  'enableAjaxValidation'=>false,
  'htmlOptions' => array(
    'onsubmit'=> "jQuery.ajax({
                    'url':'".Yii::app()->createUrl('observacionesTrazabilidad/index')."',
                    'dataType':'json',
                    'data':$(this).serialize(),
                    'type':'POST',
                    'success':function(data){
                      if(data.status == 'success'){
                        $('.body_observacion').html(data.content);                        
                      }else{  
                        $('.body_observacion').html(data.content);
                      }
                    },
                    'cache':false
                  });
                  return false;"
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
            array('name' => 'Fecha',
                  'value'=>'date("d/m/Y"." - "."h:i:s a", strtotime($data->fecha))',
                  'htmlOptions'=>array('class'=>'col-md-3')
            ),
            array('name'=>'Usuario',
                  'value'=>'ucwords(strtolower($data->usuario0->nombres." ".$data->usuario0->apellidos))',
                  'htmlOptions'=>array('class'=>'col-md-3')
            ),
            array('name'=>'Observación','value'=>'$data->observacion',
                  'htmlOptions'=>array('class'=>'col-md-6')
            ),
          ),
        )); 
      } ?>
</div>
<?= $form->hiddenField($model, 'na')?>
<?= $form->hiddenField($model, 'id_trazabilidad')?>

<div class='col-md-12'>
    <div class="form-group">
      <?php echo $form->textArea($model,'observacion',array('class'=>'form-control')); ?>
    </div>
</div>
<div class='col-md-7' align="right">    
  <?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-success','value'=>'Guardar','id'=>'guardar')); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#ObservacionesTrazabilidad_observacion").focus();
  });
</script>
