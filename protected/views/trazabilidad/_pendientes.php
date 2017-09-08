<?php
$this->setPageTitle('Punteo Cartas Firma Fisica');
?>
<div class="x_title">
  <h2>Bandeja de Casos pendientes</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<div class='col-md-12'>
  <?php
  $this->widget('booster.widgets.TbGridView',array(
  'id'=>'pendientes-grid',
  'dataProvider'=>$model->search_pendientes(''),
  'type' => 'bordered',
  'responsiveTable' => true,
  'columns'=>array(
        array(
        'header'=>'Gestión',
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{gestion}',
        'buttons' => array(
          'gestion' => array(
              'label'=>'Gestionar',
              'url'=>'base64_encode($data->na)',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok.png',
              'visible' => 'true',
              'click'=> 'js:function(){return gestion(this);}',
          ),
        )
      ),
      array(
            'name'=>'Prioridad',
            'type'=>'html',
            'value'=>'$data->estado($data->id)',
            'htmlOptions'=>array('style'=>'text-align: center;')
        ),
      array('name'=>'na','value'=>'$data->na'),
      array('name'=>'actividad','value'=>'$data->actividad0->actividad0->actividad'),
      array('name'=>'tipologia','value'=>'$data->na0->tipologia0->tipologia'),
      array('name'=>'fecha_asign','value'=>'$data->fecha_asign'),
      array('name'=>'Fecha Recepción','value'=>'$data->na0->fecha_recepcion'),
    ),
  )); ?>
</div>
<div class='col-md-12'>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>
<script type="text/javascript">
  function gestion(id){
    var na = $(id).attr("href");
    location.href="<?=Yii::app()->createUrl('/trazabilidad/index/?na')?>="+na;
    return false;
  }
</script>