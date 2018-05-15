<?php //$form=$this->beginWidget('booster.widgets.TbActiveForm',array('id'=>'form-bandeja_pendientes'));?>
<div class="x_title">
  <div class='col-md-12'>
    <h2>Bandeja de Casos pendientes</h2>
  </div>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<div class='col-md-10'></div>
<div class='col-md-2'>
  <?php echo CHtml::activeTextField($model,'buscar',array('class'=>'form-control','maxlength'=>'24','placeholder'=>'Consulta caso...')); ?>
</div>
<br>
<br>
<div class='col-md-12'>
  <?php
  $this->widget('booster.widgets.TbGridView',array(
  'id'=>'pendientes-grid',
  'dataProvider'=>$model->search_pendientes(''),
  //'filter'=>$model,
  'ajaxType'=>'POST',
  'filterSelector'=>'{filter}, #Trazabilidad_buscar, select',
  'type' => 'bordered',
  'responsiveTable' => true,
  'columns'=>array(
        /*array(
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
      ),*/
      //array('name'=>'na','value'=>'$data->na'),
      array(
          'header'=>'Caso',
          'name'=>'na',
          'type'=>'raw',
          'value'=>'$data->linkCaso($data->na)',
          'htmlOptions'=>array('style'=>'text-align: center;')
      ),  
      /*array(
            'header'=>'Prioridad',
            'type'=>'html',
            'value'=>'$data->estado($data->id, $data->actividad)',
            'htmlOptions'=>array('style'=>'text-align: center;')
        ),
      array(
            'header'=>'Dias De Plazo',
            'type'=>'html',
            'value'=>'$data->estadoUsuario($data->id, $data->actividad)',
            'htmlOptions'=>array('style'=>'text-align: center;')
      ),*/
      array(
            'header'=>'Fecha De Plazo',
            'type'=>'html',
            'value'=>'$data->estadoActividad($data->id, $data->actividad)',
            'htmlOptions'=>array('style'=>'text-align: center;')
      ),
      array('name'=>'actividad','value'=>'$data->actividad0->idActividad->actividad'),
      array('header'=>'Tipologia','value'=>'$data->na0->tipologia0->tipologia'),
      array('header'=>'Fecha Asignación','name'=>'fecha_asign','value'=>'date("d/m/Y"." - "."h:i:s a", strtotime($data->fecha_asign))'),
      array('header'=>'Fecha Recepción','value'=>'date("d/m/Y"." - "."h:i:s a", strtotime($data->na0->fecha_recepcion))'),
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
<?php //$this->endWidget(); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#Trazabilidad_buscar').keyup(function (){
          this.value = (this.value + '').replace(/[^0-9]/g, '');
      });
  });
  function gestion(id){
    var na = $(id).attr("href");
    location.href="<?=Yii::app()->createUrl('/trazabilidad/index/?na')?>="+na;
    return false;
  }
</script>