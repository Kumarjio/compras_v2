<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
  $cs->scriptMap['jquery.yiigridview.js'] = false;
}
?>
<?php $this->widget('booster.widgets.TbGridView',array(
  'id'=>'adjuntos_respuesta-grid',
  //'ajaxType' => 'POST',
  'dataProvider'=>$modelAdjuntos->search(),
  'type' => 'bordered',
  'columns'=>array(
      array(
          'header'=>'Nombre',
          'htmlOptions'=>array('style'=>'text-align: center;','class'=>'col-md-1'),
          'value'=>'$data->nombre_adjunto',
      ),
      array(
          'header'=>'Archivo',
          'type'=>'raw',
          'htmlOptions'=>array('style'=>'text-align: center;','class'=>'col-md-1'),
          'value'=>'$data->cargaLink($data->path_web)',
      ),
      array(
          'header'=>'Eliminar',
          'class'=>'booster.widgets.TbButtonColumn',
          'template'=>'{eliminar}',
          'htmlOptions'=>array('style'=>'text-align: center;','class'=>'col-md-1'),
          'buttons' => array(
            'eliminar' => array(
                'label'=>false,
                'url'=>'$data->id_adjunto',
                'icon'=>'glyphicon glyphicon-trash',
                'options'=>array('style'=> 'font-size: 1.2em;','class'=>'eliminaAdjunto'),
            ),
          )
        ),
    ),
  ));
?>
<script type="text/javascript">
$(document).ready(function(){
  $(".ficebox").attr("data-fancybox", "gallery");
  $(".eliminaAdjunto").on("click",function(e){ 
    e.preventDefault();
    eliminarAdj(this);
    return false;
  });
});
$(".imagenTiff").click(function(){  
    var path = $(this).attr("href");   
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('path' => 'js:path'),
        'url' => $this->createUrl("trazabilidad/visorImagenesTif"),
        'dataType'=>'json',
        'async'=>true,
        'success' => 'function(data){
            if(data.status == "success"){
              $("#modal-visor_tif_recepcion #body-visor_tif_recepcion").html(data.content);
              $("#modal-visor_tif_recepcion").modal("show");
            }
        }'
      )
  );?>
  return false;
});
</script>