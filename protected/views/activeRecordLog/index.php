<div id="content">
<?php 
$this->widget('bootstrap.widgets.BootGridView',array(
  'id'=>'informe-efectividad-grid',
  'dataProvider'=>$dataProvider,
  'type'=>'striped bordered condensed',
  'columns'=>array(
    'action',
    'iduser',
    'field',
    'username',
    'description',
    'description_new',
    'fecha',
  )
)); ?>
</div>