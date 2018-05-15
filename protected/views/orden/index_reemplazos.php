<div id="content">
<?php 
$this->widget('bootstrap.widgets.BootGridView',array(
  'id'=>'reemp-grid',
  'dataProvider'=>$dataProvider,
  'type'=>'striped bordered condensed',
  'columns'=>array(
    array(
          'header' => 'Orden Vieja',
          'name' => 'id',
          'type' => 'raw',
          'value' => 'CHtml::link($data->orden_vieja, Yii::app()->createUrl("orden/print", array("orden"=>$data->orden_vieja)), array("target" => "_blank"))'
        ),
      array(
        'name' => 'nombre_compra',
        'value' => '$data->orden->nombre_compra',
        'filter' => false
      ),
  )
)); ?>
</div>