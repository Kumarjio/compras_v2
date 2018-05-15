<div class="x_title">
  <h2> Tipología </h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<div class='col-md-1'>
  <div class="form-actions"> 
    <?php $this->widget('bootstrap.widgets.BootButton', array( 
      'buttonType'=>'submit',
      'icon'=>'glyphicon glyphicon-file',
      'type'=>'warning',
      'label'=>'Nueva Tipología',
          'htmlOptions' => array('id'=>'crear_tipologia'), 
    )); ?>
  </div>
</div>

<div class="row">
</div>
<br>
<?php $this->widget('booster.widgets.TbGridView',array(
  'id'=>'tipologiaJ-grid',
  'dataProvider'=>$model->search(),
  'filter'=>$model,
  'ajaxType'=>'POST',
  'type' => 'striped',
  'columns'=>array(
    array('name'=>'tipologia','value'=>'ucwords(strtolower($data->tipologia))'),
    array('name'=>'area',
          'value'=>'$data->area0->area',
          'filter'=>CHtml::listData(Areas::model()->findAll(array('order'=>'area')), 'id', 'area'),),
    array(
        'header'=>'Modificar Tipologia',
        'htmlOptions'=>array('style'=> 'text-align:center'),
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{update}',
        'buttons' => array(
          'update' => array(
              'label'=>'Modificar',
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-pencil',
              'options'=>array('style'=> 'font-size: 1.3em;'),
              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
              'click'=> 'js:function(){return update(this);}',
          ),
        )
      ),
      array(
        'header'=>'Habilitar / Inhabilitar Tipologia',
        'htmlOptions'=>array('style'=> 'text-align:center'),
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{inhabilitar}{habilitarTipologia}',
        'buttons' => array(
          'inhabilitar' => array(
              'label'=>'Inhabilitar',
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-remove',
              'options'=>array('style'=> 'font-size: 1.3em;'),
              'visible' => '$data->activa',
              'click'=> 'js:function(){return inhabilitar(this);}',
          ),
          'habilitarTipologia' => array(
            'label'=>'Habilitar',
            'url'=>'$data->id',
            'visible' => '!$data->activo',
            'icon'=>'glyphicon glyphicon-ok',
            'options'=>array('style'=> 'font-size: 1.3em;'),
            'visible' => '!$data->activa',
            'click'=> 'js:function(){return habilitarTipologia(this);}'
          ),
        )
      ),
      array(
        'header'=>'Habilitar Flujo',
        'htmlOptions'=>array('style'=> 'text-align:center'),
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{habilitar}',
        'buttons' => array(
          'habilitar' => array(
              'label'=>'Habilitar',
              'url'=>'base64_encode($data->id)',
              'icon'=>'glyphicon glyphicon-ok',
              'options'=>array('style'=> 'font-size: 1.3em;'),
              'visible' => '!$data->operacion',
              'click'=> 'js:function(){return habilitar(this);}',
          ),
        )
      ),
      array(
        'header'=>'Acividades',
        'class'=>'booster.widgets.TbButtonColumn',
        'htmlOptions'=>array('style'=> 'text-align:center'),
        'template'=>'{actividades}',
        'buttons'=>array(
          'actividades' => array(
                'visible'=>'$data->operacion',
                'label'=>'Actividades',
                'url'=>'Yii::app()->createUrl("controlFlujo/usuariosFlujo", array("id"=>base64_encode($data->id)))',
                'icon'=>'glyphicon glyphicon-th-list',
                'options'=>array('style'=> 'font-size: 1.3em;'),
                //'options'=>array('class'=>'glyphicon glyphicon-user'),
            ),
        ),
      ),
  ),
)); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'dialogo-tipologiaJ')
); ?>

<!-- Modal -->
<div class="modal-header">
    <h4> Tipologías </h4>
</div>
<div class="modal-body" id="body-tipologiaJ">
</div>
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
$("#crear_tipologia").click(function(){
  <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'url' => $this->createUrl("agregarTipologia"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#dialogo-tipologiaJ #body-tipologiaJ").html(data.content);
              $("#dialogo-tipologiaJ").modal("show");
            }
        }'
      )
  );?>
});
function update(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id' => 'js:id'),
        'url' => $this->createUrl("updateTipologia"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#dialogo-tipologiaJ #body-tipologiaJ").html(data.content);
              $("#dialogo-tipologiaJ").modal("show");
            }
        }'
      )
  );?>
    return false;
}
function inhabilitar(id){
  var id = $(id).attr("href");
  bootbox.confirm({
    message: "<h4>¿Esta seguro de inhabilitar esta tipologia?</h4>",
    buttons: {
        confirm: {
            label: "Confirmar",
            className: "btn-warning"
        },
        cancel: {
            label: "Cancelar",
            className: "btn-default"
        }
    },
    callback: function (confirm) {
      if(confirm){
          <?php echo CHtml::ajax(
           array(
            'type' => 'POST',
            'data' => array('id' => 'js:id'),
            'url' => $this->createUrl("inhabilitarTipologia"),
            'dataType'=>'json',
            'success' => 'function(data){
                if(data.status == "success"){
                  $("#dialogo-tipologiaJ #body-tipologiaJ").html(data.content);
                  $("#dialogo-tipologiaJ").modal("show");
                  $("#tipologiaJ-grid").yiiGridView.update("tipologiaJ-grid");
                }else{
                  $("#dialogo-tipologiaJ #body-tipologiaJ").html(data.content);
                  $("#dialogo-tipologiaJ").modal("show");
                }
            }'
          )
        );?>
      }
    }
  });
    return false;
}
function habilitarTipologia(id){
  var id = $(id).attr("href");
  bootbox.confirm({
    message: "<h4>¿Esta seguro de Habilitar esta tipologia?</h4>",
    buttons: {
        confirm: {
            label: "Confirmar",
            className: "btn-warning"
        },
        cancel: {
            label: "Cancelar",
            className: "btn-default"
        }
    },
    callback: function (confirm) {
      if(confirm){
          <?php echo CHtml::ajax(
           array(
            'type' => 'POST',
            'data' => array('id' => 'js:id'),
            'url' => $this->createUrl("habilitarTipologia"),
            'dataType'=>'json',
            'success' => 'function(data){
                if(data.status == "success"){
                  $("#dialogo-tipologiaJ #body-tipologiaJ").html(data.content);
                  $("#dialogo-tipologiaJ").modal("show");
                  $("#tipologiaJ-grid").yiiGridView.update("tipologiaJ-grid");
                }else{
                  $("#dialogo-tipologiaJ #body-tipologiaJ").html(data.content);
                  $("#dialogo-tipologiaJ").modal("show");
                }
            }'
          )
        );?>
      }
    }
  });
  return false;
}
function habilitar(id){
    var id = $(id).attr("href");
    location.href="<?=Yii::app()->createUrl('/controlFlujo/establecerTipologia/?tipo')?>="+id;
    return false;
}
</script>
