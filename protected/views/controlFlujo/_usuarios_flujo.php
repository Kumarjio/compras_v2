<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
  'id'=>'asignacion',
  'enableAjaxValidation'=>false,
  'enableClientValidation' => true,
  'htmlOptions' => array(
    'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('controlFlujo/asignaUsuarios').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal_usuarios\').modal(\'hide\'); $(\'#gridActividades\').yiiGridView.update(\'gridActividades\');}else{$(\'#body_usuarios\').html(data.content);}},\'cache\':false});return false;'
  ),
  'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model)  ?>
<?= $form->hiddenField($model, 'actividad_tipologia')?>
<div class='col-md-12'>
  <?php echo $form->labelEx($model,'usuarios'); ?>
    <div class="form-group">
      <?php $this->widget('ext.select2.ESelect2',array(
      'model'=>$model,
      'attribute'=>'usuarios',
      'data'=>Usuario::model()->cargarUsuarios(),
      'htmlOptions'=>array(
        'options'=>array('selected'=>true),
        'multiple'=>'multiple',
        'style'=>'width:548px',
      ),
    ));?>
    </div>
</div>
<div class='col-md-1'>
  <div class="form-actions"> 
  <?php $this->widget('bootstrap.widgets.BootButton', array( 
    'buttonType'=>'submit', 
    'type'=>'warning', 
    'label'=>'Guardar', 
  )); ?>
  </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">

</script>