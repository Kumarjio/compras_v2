<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
}
 Yii::app()->clientScript->registerCoreScript('yiiactiveform'); ?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'form-adjunto-respuesta',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> "jQuery.ajax({
        'url':'".Yii::app()->createUrl('actividades/CargarDocumento')."',
        'dataType':'json',
        'data':$(this).serialize(),
        'type':'post',
        'success':function(data){
          if(data.status == 'success'){
            adjuntosRespuesta('".$model->id_trazabilidad."');
            $('#modal-adjuntos-respuesta').modal('hide');
            $('#modal-gestiontraza').modal('show');
          }else{
            $('#body-adjuntos-respuesta').html(data.content);
          }
        },
        'cache':false
      });
    return false;",
		'enctype'=>'multipart/form-data'
	),
	'clientOptions' => array(
		'validateOnSubmit'=>true,
        'validateOnSubmit' => true
    ),
));?>
<?php echo $form->errorSummary($model) ?>
<?= $form->hiddenField($model, 'id_trazabilidad')?>
<?= $form->hiddenField($model, 'nombre_adjunto')?>
<?= $form->hiddenField($model, 'archivo')?>
<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4" align="center">
  	<div class="form-group">
      <?php $this->widget('ext.EFineUploader.EFineUploader',
        array(
           'id'=>'carga_archivo',
           'config'=>array(
               'autoUpload'=>true,
               'request'=>array(
                  'endpoint'=>$this->createUrl('upload'),
                  'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                ),
               'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
               'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
               'callbacks'=>array(
                                  'onComplete'=>'js:function(id, name, response){
                                      document.getElementById("AdjuntosRespuesta_archivo").value =  response.ruta;
                                      document.getElementById("AdjuntosRespuesta_nombre_adjunto").value =  response.archivo;
                                    }',
                                ),
               'validation'=>array(
                 'allowedExtensions'=>array('jpg','jpeg','png','pdf','xls','csv','msg','tif','xlsx','msg'),
                   'sizeLimit'=>2 * 1024 * 1024,
                ),
              )
        )); 
      ?>
  	</div>
  </div>
  <div class="col-md-4"></div>
</div>
<br>
<div class="row">
  <div class="col-md-10"></div>
  <div class="col-md-2">
    <?php $this->widget('bootstrap.widgets.BootButton', array( 
      'buttonType'=>'submit', 
      'type'=>'success', 
      'label'=>'Guardar',
      )); ?>
  </div>
</div>
<br>
<?php $this->endWidget(); ?>