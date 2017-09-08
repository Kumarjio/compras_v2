<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$this->widget('booster.widgets.TbGridView',array(
    'id'=>'usuarios-flujo-grid',
    'dataProvider'=>$model->search_detalle(),
    'type' => 'bordered',
    'responsiveTable' => true,
    'columns'=>array(
        array('name'=>'Usuarios','value'=>'ucwords(strtolower($data->usuario0->nombres." ".$data->usuario0->apellidos))'),
      ),
));?>
