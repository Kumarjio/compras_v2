<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-observacion',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\''.Yii::app()->createUrl('trazabilidad/observacionesTrazabilidad').'\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#modal-observacion-trazabilidad\').modal(\'hide\');}else{	$(\'#body-observacion\').html(data.content);}},\'cache\':false});return false;'
	)
));

  $this->widget('booster.widgets.TbGridView',array(
  'id'=>'observaciones-grid',
  'dataProvider'=>$model->search_detalle(''),
  'template' => "{items}",
  'type' => 'bordered',
  'responsiveTable' => true,
  'columns'=>array(
      array('name'=>'fecha','value'=>'$data->fecha'),
      array('name'=>'usuario','value'=>'$data->usuario'),
      array('name'=>'observacion','value'=>'$data->observacion'),
    ),
  ));
$this->endWidget(); ?>

