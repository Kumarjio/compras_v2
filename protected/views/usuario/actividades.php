<div class="x_title">
  <h2>Tipologias y Actividades de usuario <?php echo Usuario::nombreUsuario($usuario); ?></h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<br>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'usuario-grid',
	'dataProvider'=>$model->search_detalle(),
	'type' => 'striped',
	'afterAjaxUpdate' => 'reinstallDatePicker',
	'columns'=>array(
    array(
      'header'=>'Tipología',
      'value'=>'$data->idTipologia->tipologia',
    ),
    array(
      'header'=>'Actividades',
      'type'=>'raw',
      'value'=>'$data->getActividades($data->id_tipologia, '.$usuario.')',
    ),
  ),
));?>
<br>
<br>
<div class="form-actions"> 
  <?php $this->widget('bootstrap.widgets.BootButton', array(
    'buttonType'=>'button',
    'icon'=>'glyphicon glyphicon-arrow-left',
    'type'=>'success',
    'label'=>'Atras',
    'htmlOptions' => array('id'=>'atras_desde_actividadTipologia'), 
  )); ?>
</div>
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
<script type="text/javascript">
$("#atras_desde_actividadTipologia").click(function(){
  location.href="<?=Yii::app()->createUrl('/usuario/admin')?>";
  return false;
});
</script>