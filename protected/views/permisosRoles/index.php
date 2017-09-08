<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$this->widget('booster.widgets.TbGridView',array(
    'id'=>'permisos-grid',
    'dataProvider'=>$model->search_detalle(),
    'type' => 'bordered',
    'responsiveTable' => true,
    'columns'=>array(
        array('name'=>'nombre','value'=>'$data->idPermiso->nombre'),
      ),
)); 