<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$this->widget('booster.widgets.TbGridView',array(
    'id'=>'observacion-recepcion-grid',
    'dataProvider'=>$model->search_detalle(),
    'type' => 'bordered',
    'responsiveTable' => true,
    'columns'=>array(
        array('name'=>'Fecha','value'=>'$data->na0->fecha_recepcion'),
        array('name'=>'Usuario','value'=>'ucwords(strtolower($data->na0->userRecepcion->nombres." ".$data->na0->userRecepcion->apellidos))'),
        array('name'=>'Observación','value'=>'$data->observacion'),
      ),
));?>
