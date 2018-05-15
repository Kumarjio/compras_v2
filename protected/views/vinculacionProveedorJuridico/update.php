<?php
$this->breadcrumbs=array(
	'Vinculacion Proveedor Juridico'=>array('admin'),
);


$this->menu=array(
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>