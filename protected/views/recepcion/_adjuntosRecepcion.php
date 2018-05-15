<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'form-agregar-adjunto',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
));?>
<?php $this->widget('booster.widgets.TbGridView',array(
  'id'=>'adjuntos_recepcion-grid',
  //'ajaxType' => 'POST',
  'dataProvider'=>$modelAdjuntos->search(),
  'type' => 'bordered',
  //'responsiveTable' => true,
  'columns'=>array(
      array(
          'name'=>'archivo',
          'type'=>'raw',
          'htmlOptions'=>array('style'=>'text-align: center;','class'=>'col-md-1'),
          'value'=>'$data->extensionAdjunto($data->path)',
      ),
      array(
          'header'=>'Eliminar',
          'class'=>'booster.widgets.TbButtonColumn',
          'template'=>'{eliminar}',
          'htmlOptions'=>array('style'=>'text-align: center;','class'=>'col-md-1'),
          'buttons' => array(
            'eliminar' => array(
                'label'=>false,
                'url'=>'$data->id',
                'icon'=>'glyphicon glyphicon-trash',
                'options'=>array('style'=> 'font-size: 1.2em;','class'=>'eliminaAdRecepcion'),
            ),
          )
        ),
    ),
  ));
?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
$(document).ready(function(){
  $(".eliminaAdRecepcion").on("click",function(e){ 
    e.preventDefault();
    eliminar(this);
    return false;
  });
});
function eliminar(id) {
  var id = $(id).attr("href");
  bootbox.confirm({
    message: "<h4>¿Esta seguro que desea eliminar el adjunto?</h4><br><h5>- Si lo elimina, no podra recuperarlo.</h5>",
    buttons: {
        confirm: {
            label: 'Confirmar',
            className: 'btn-success'
        },
        cancel: {
            label: 'Cancelar',
            className: 'btn-default'
        }
    },
    callback: function (confirm) {
      if(confirm){
        <?php echo CHtml::ajax(
            array(
              'type' => 'POST',
              'data' => array('id' => 'js:id'),
              'url' => $this->createUrl("eliminarAdjunto"),
              'async'=>true,
              'success' => 'function(data){
                if(data){
                  adjuntosRecepcion(data);
                }
              }'
            )
        );?>
      }
    }
  });
  return false;
}
$( document ).ready(function() {
  $(".ficebox").attr("data-fancybox", "gallery");
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