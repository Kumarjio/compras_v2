<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
}
 Yii::app()->clientScript->registerCoreScript('yiiactiveform'); ?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'form-agregar-adjunto',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({
        \'url\':\''.Yii::app()->createUrl('recepcion/CargarDocumento').'\',
        \'dataType\':\'json\',
        \'data\':$(this).serialize(),
        \'type\':\'post\',
        \'success\':function(data){
          if(data.status == \'success\'){
            //$("#adjuntos_recepcion-grid").yiiGridView.update("adjuntos_recepcion-grid");
            adjuntosRecepcion('.$model->na.');
            $(\'#modal-adjuntos-recepcion\').modal(\'hide\'); 
          }else{
            $(\'#body-adjuntos-recepcion\').html(data.content);
          }
        },
        \'cache\':false
      });
    return false;',
		'enctype'=>'multipart/form-data'
	),
	'clientOptions' => array(
		'validateOnSubmit'=>true,
        'validateOnSubmit' => true
    ),
));?>
<?php echo $form->errorSummary($model) ?>
<div class='col-md-12 oculto'>
  <div class="form-group">
    <?php echo $form->textField($model,'na',array('class'=>'form-control')); ?>
  </div>
</div>
<div class='col-md-12 oculto'>
  <div class="form-group">
    <?php echo $form->textField($model,'archivo',array('class'=>'form-control')); ?>
  </div>
</div>
<div class="col-md-6">
	<div class="form-group">
  <?php $this->widget('ext.EFineUploader.EFineUploader',
   array(
     'id'=>'carga_archivos',
     'config'=>array(
         'autoUpload'=>true,
         'request'=>array(
            'endpoint'=>$this->createUrl('upload'),
            'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
          ),
         'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
         'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
         'callbacks'=>array(
                            'onComplete'=>'js:function(id, name, response){document.getElementById("AdjuntosRecepcion_archivo").value =  response.ruta;}',
                          ),
         'validation'=>array(
           'allowedExtensions'=>array('jpg','jpeg','png','pdf','xls','csv','msg','tif','xlsx','msg'),
             'sizeLimit'=>2 * 1024 * 1024,
          ),
        )
  )); 
  //'onError'=>"js:function(id, name, errorReason){ }",
  //$('li.qq-upload-success').remove();
?>
	</div>
</div>
<div class="row">
</div>
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit', 
			'type'=>'primary', 
			'label'=>'Guardar',
			)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>