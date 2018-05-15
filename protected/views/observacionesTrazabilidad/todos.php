<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
  $cs->scriptMap['jquery.yiigridview.js'] = false;
}?>
<?php $this->widget('booster.widgets.TbGridView',array(
      'id'=>'observaciones-trazabilidad-grid',
      'dataProvider'=>$model->search_todas($na),
      'type' => 'bordered',
      //'ajaxUpdate'=>false,
      'responsiveTable' => true,
      'columns'=>array(
        array(
          'header' => 'Actividad',
          'value' => '$data->idTrazabilidad->actividad0->idActividad->actividad',
          'htmlOptions'=>array('class'=>'col-md-2')
        ),
        array(
          'header' => 'Fecha',
          'value'=>'date("d/m/Y"." - "."h:i:s a", strtotime($data->fecha))',
          'htmlOptions'=>array('class'=>'col-md-2')
        ),
        array('name'=>'Usuario',
          'value'=>'ucwords(strtolower($data->usuario0->nombres." ".$data->usuario0->apellidos))',
          'htmlOptions'=>array('class'=>'col-md-2')
        ),
        array('name'=>'Observación',
          'value'=>'$data->observacion',
          'htmlOptions'=>array('class'=>'col-md-6')),
      ),
)); ?>