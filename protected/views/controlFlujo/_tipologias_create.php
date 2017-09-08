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
      'label'=>$model->isNewRecord ? 'Nueva Tipología' : 'Guardar',
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
  'type' => 'striped',
  'columns'=>array(
    array('name'=>'id','value'=>'$data->id'),
    array('name'=>'tipología','value'=>'ucwords(strtolower($data->tipologia))'),
    array('name'=>'Área','value'=>'$data->area0->area'),
    array(
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{update}',
        'buttons' => array(
          'update' => array(
              'label'=>'Actualizar',
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-pencil',
              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
              'click'=> 'js:function(){return update(this);}',
          ),
        )
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
</script>
