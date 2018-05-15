
<?php $this->widget('booster.widgets.TbGridView', array(
	'id'=>'recepcion-grid',
	'dataProvider'=>$model->search($documento),
	'filter'=>$model,
	'columns'=>array(
        array(
	        'header'=>'Ver',
	        'class'=>'booster.widgets.TbButtonColumn',
	        'template'=>'{gestion}',
	        'buttons' => array(
	          'gestion' => array(
	              'label'=>'Ver Detalle',
	              'url'=>'base64_encode($data->na)',
	              'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok.png',
	              'visible' => 'true',
	              'click'=> 'js:function(){return ver(this);}',
	          ),
	        )
    	),
    	array(
    		'name'=>'na',
    		'header'=>'Caso'
    	),
		'documento',
		'tipologia',
		'ciudad',
		'tipo_documento',
	),
)); ?>
<script type="text/javascript">
  function ver(id){
    var na = $(id).attr("href");
    location.href="<?=Yii::app()->createUrl("trazabilidad/index")?>/na/"+na;
    return false;
  }
</script>