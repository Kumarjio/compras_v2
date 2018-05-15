<?php
$this->breadcrumbs=array(
	'Contrato No. '.$model->consecutivo_contrato
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'vista'=>$vista)); ?>