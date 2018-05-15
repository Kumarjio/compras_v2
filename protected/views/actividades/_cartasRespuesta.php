<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
  $cs->scriptMap['jquery.yiigridview.js'] = false;
}?>

<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong class="hand green">
        <big>Copias</big>
      </strong>
    </div>
    <br>
    <div class='col-md-13'>      
      <?php $this->widget('booster.widgets.TbGridView',array(
        'id'=>'cartasRespuesta-grid',
        'ajaxType' => 'POST',
        'dataProvider'=>$modelCartas->search(),
        'type' => 'bordered',
        'columns'=>array(
          array(
            'header'=>'Destinatario',
            'value'=>'$data->nombre_destinatario',
            'headerHtmlOptions'=>array("class"=>"hand green"),
          ),
          array(
            'header'=>'Tipo Entrega',
            'value'=>'$data->idTipoEntrega->entrega',
            'headerHtmlOptions'=>array("class"=>"hand green"),
          ),
          array(
            'header'=>'Proveedor',
            'value'=>'$data->idProveedor->proveedor',
            'headerHtmlOptions'=>array("class"=>"hand green"),
          ),
          array(
            'header'=>'Principal',
            'value'=>'$data->principal',
            'headerHtmlOptions'=>array("class"=>"hand green"),
          ),
          array(
            'header'=>'Archivo',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align: center;','class'=>'col-md-1'),
            'value'=>'$data->creaPdf()',
            'headerHtmlOptions'=>array("class"=>"hand green"),
          ),
          array(
            'header'=>'Editar',
            'class'=>'booster.widgets.TbButtonColumn',
            'template'=>'{editar}',
            'htmlOptions'=>array('style'=>'text-align: center;','class'=>'col-md-1'),
            'headerHtmlOptions'=>array("class"=>"hand green"),
            'buttons' => array(
              'editar' => array(
                  'label'=>false,
                  'url'=>'$data->id',
                  'icon'=>'glyphicon glyphicon-pencil',
                  'options'=>array('style'=> 'font-size: 1.6em;','class'=>'editaRta'),
              ),
            )
          ),
          array(
            'header'=>'Eliminar',
            'class'=>'booster.widgets.TbButtonColumn',
            'template'=>'{eliminar}',
            'htmlOptions'=>array('style'=>'text-align: center;','class'=>'col-md-1'),
            'headerHtmlOptions'=>array("class"=>"hand green"),
            'buttons' => array(
              'eliminar' => array(
                  'label'=>false,
                  'url'=>'$data->id',
                  'icon'=>'glyphicon glyphicon-trash',
                  'visible' => '$data->principal == "No"',
                  'options'=>array('style'=> 'font-size: 1.6em;','class'=>'eliminaRta'),
              ),
            )
          ),
        ),
      ));
      ?>
     
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $(".ficebox").attr("data-fancybox", "gallery");

  $(".eliminaRta").on("click",function(e){ 
    e.preventDefault();
    eliminar(this);
    return false;
  });
  $(".editaRta").on("click",function(e){ 
    e.preventDefault();
    editar(this);
    return false;
  });
  $(".verRta").on("click",function(e){ 
    e.preventDefault();
    consultar(this);
    return false;
  });
});
</script>