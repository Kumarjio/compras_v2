<?php 
if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
?>
<div class="alert alert-success">
  <strong>Correcto!</strong> Usuario Inhabilitado con éxito.
</div>
