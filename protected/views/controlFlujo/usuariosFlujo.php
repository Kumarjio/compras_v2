<div class="x_title">
  <h2> <i class="glyphicon glyphicon-bookmark"></i> Actividades: <?php echo $model->tipologia; ?></h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<div class='col-md-9'></div>
<div class='col-md-3'>
  <?php echo CHtml::activeDropDownList($modelFlujo,'buscar',CHtml::listData(Actividades::model()->findAll(array("condition"=>"\"actividadTipologias\".\"id_tipologia\" = ".$model->id, 'order' => 't.actividad', 'with'=>'actividadTipologias')), 'id', 'actividad'),array('class'=>'form-control','prompt'=>'Actividades ...')); ?>
</div>
<br>
<br>
<br>
<?php $this->widget('booster.widgets.TbGridView',array(
  'id'=>'gridActividades',
  'dataProvider'=>$modelFlujo->search(),
  //'filter'=>$modelFlujo,
  'ajaxType'=>'POST',
  'filterSelector'=>'{filter}, #ActividadTipologia_buscar, select',
  'type' => 'striped',
  'responsiveTable' => true,
  'columns'=>array(
    array(
      'header'=>'Actividad',
      'name'=>'id_actividad',
      'value'=>'$data->idActividad->actividad',
      'filter'=>CHtml::listData(Actividades::model()->findAll(array("condition"=>"\"actividadTipologias\".\"id_tipologia\" = ".$model->id, 'order' => 't.actividad', 'with'=>'actividadTipologias')), 'id', 'actividad'),
      'htmlOptions'=>array('class'=>'col-md-2')
    ),
    array(
      'header'=>'Usuarios Gestión Actividad',
      'type'=>'raw',
      'value'=>'$data->getUsuariosActividad()',
      'htmlOptions'=>array('class'=>'col-md-5')
    ),
    array(
      'header'=>'Nro. Usuarios',
      'value'=>'$data->getCantidadUsuarios()',
      'htmlOptions'=>array('class'=>'col-md-1','style'=>'text-align: center;')
    ),
    array(
      'header'=>'Modificar Usuarios Actividad',
      'class'=>'booster.widgets.TbButtonColumn',
      'htmlOptions'=>array('class'=> 'col-md-2','style'=>'text-align: center;'),
      'template'=>'{usuarios}',
      'buttons' => array(
        'usuarios' => array(
            'label'=>'Usuarios',
            'url'=>'$data->id',
            'icon'=>'glyphicon glyphicon-user',
            'options'=>array('style'=> 'font-size: 1.3em;'),
            'click'=> 'js:function(){return validaActividad(this);}',
        ),
      )
    ),
    array(
      'header'=>'Tiempos',
      'class'=>'booster.widgets.TbButtonColumn',
      'htmlOptions'=>array('class'=> 'col-md-1','style'=>'text-align: center;'),
      'template'=>'{tiempo}',
      'buttons' => array(
        'tiempo' => array(
            'label'=>'Tiempo',
            'url'=>'$data->id',
            'icon'=>'glyphicon glyphicon-time',
            'options'=>array('style'=> 'font-size: 1.3em;'),
            'click'=> 'js:function(){return validaActividadTiempo(this);}',
        ),
      )
    ),
  ),
)); ?>
<div class='col-md-1'>
  <div class="form-actions"> 
    <?php $this->widget('bootstrap.widgets.BootButton', array(
      'buttonType'=>'button',
      'icon'=>'glyphicon glyphicon-arrow-left',
      'type'=>'warning',
      'label'=>'Atras',
      'htmlOptions' => array('id'=>'atras_tipologias'), 
    )); ?>
  </div>
</div>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal_usuarios')
); ?>
<!-- Modal -->
<div class="modal-header">
    <h4><i class="glyphicon glyphicon-user"></i> Asignación de Usuarios </h4>
</div>
<div class="modal-body" id="body_usuarios"></div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal_tiempo')
); ?>
<!-- Modal -->
<div class="modal-header">
    <h4><i class="glyphicon glyphicon-time"></i> Asignación de Tiempo </h4>
</div>
<div class="modal-body" id="body_tiempo"></div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
function validaActividad(id){
  var id = $(id).attr("href"); 
    <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'data' => array('id' => 'js:id'),
          'url' => $this->createUrl("validaIdActividad"),
          'dataType'=>'json',
          'success' => 'function(data){
              if(data.status == "success"){
                usuarios(id);
              }else{
                $("#modal_usuarios #body_usuarios").html(data.content);
                $("#modal_usuarios").modal("show");
              }  
          }'
        )
    );?> 
  return false;
}
function usuarios(id){
  <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id' => 'js:id'),
        'url' => $this->createUrl("asignaUsuarios"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#modal_usuarios #body_usuarios").html(data.content);
              $("#modal_usuarios").modal("show");
            }
        }'
      )
  );?> 
}
function validaActividadTiempo(id){
  var id = $(id).attr("href"); 
    <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'data' => array('id' => 'js:id'),
          'url' => $this->createUrl("validaTiempo"),
          'dataType'=>'json',
          'success' => 'function(data){
              if(data.status == "success"){
                tiempo(id);
              }else{
                $("#modal_tiempo #body_tiempo").html(data.content);
                $("#modal_tiempo").modal("show");
              }  
          }'
        )
    );?> 
  return false;
}
function tiempo(id){
    <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'data' => array('id' => 'js:id'),
          'url' => $this->createUrl("tiempoActividad"),
          'dataType'=>'json',
          'success' => 'function(data){
              if(data.status == "success"){
                $("#modal_tiempo #body_tiempo").html(data.content);
                $("#modal_tiempo").modal("show");
              } 
          }'
        )
    );?> 
}
$("#atras_tipologias").click(function(){
  location.href="<?=Yii::app()->createUrl('/controlFlujo/createTipologia')?>";
  return false;
});
</script>
