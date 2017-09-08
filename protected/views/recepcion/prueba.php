<div class="col-md-3">
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
	                              'onComplete'=>"js:function(id, name, response){ $('li.qq-upload-success').remove(); alert(name);}",
	                              'onError'=>"js:function(id, name, errorReason){ }",
	                            ),
	           'validation'=>array(
		           'allowedExtensions'=>array('jpg','jpeg'),
	               'sizeLimit'=>2 * 1024 * 1024,//maximum file size in bytes
	               //'minSizeLimit'=>2*1024*1024,// minimum file size in bytes
	            ),
	          )
	)); ?>
	</div>
</div>

  