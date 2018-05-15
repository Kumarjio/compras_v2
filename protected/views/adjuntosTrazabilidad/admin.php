<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
  $cs->scriptMap['jquery.yiigridview.js'] = false;
} ?>
<div class='col-md-12'>
  <?php $this->widget('booster.widgets.TbGridView',array(
      'id'=>'adjuntos-grid',
      'dataProvider'=>$model->search_adjuntos(),
      'type' => 'bordered',
      'responsiveTable' => true,
      'columns'=>array(
      	array(
  	      'header' => 'Actividad',
  	      'value'=>'ucwords(strtolower($data->idTrazabilidad->actividad0->idActividad->actividad))',
      	),	
      	array(
  	      'header' => 'Fecha',
  	      'value'=>'date("d/m/Y"." - "."h:i:s a", strtotime($data->fecha))',
      	),
      	array(
              'header'=>'Usuario',
              'value'=>'ucwords(strtolower($data->usuario0->nombres." ".$data->usuario0->apellidos))',
          ),
        	array(
              'header'=>'Archivo',
              'type'=>'raw',
              'value'=>'$data->extensionAdjunto($data->path)',
              'htmlOptions'=>array('style'=>'text-align: center;')
          ),
     	), 	
  ));?>
</div>
<br>
<br>
<div class="x_title">
  <h2>Adjuntos Respuesta</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class='col-md-12'>
  <?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>'grid_adjuntos_rta',
    'dataProvider'=>$modelRta->search_adjuntos(),
    'type' => 'bordered',
    'template' => "{items}",
    'columns'=>array(
        array(
            'header'=>'Actividad',
            //'htmlOptions'=>array('width'=>'30%'),
            'value'=>'$data->idTrazabilidad->actividad0->idActividad->actividad',
            //'headerHtmlOptions'=>array("class"=>"hand green"),
        ),
        array(
            'header'=>'Fecha',
            //'htmlOptions'=>array('width'=>'30%'),
            'value'=>'date("d/m/Y"." - "."h:i:s a", strtotime($data->fecha))',
            //'headerHtmlOptions'=>array("class"=>"hand green"),
        ),
        array(
            'header'=>'Usuario',
            //'htmlOptions'=>array('width'=>'30%'),
            'value'=>'ucwords(strtolower($data->usuario0->nombres." ".$data->usuario0->apellidos))',
            //'headerHtmlOptions'=>array("class"=>"hand green"),
        ),
        array(
            'header'=>'Archivo',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align: center;'),
            'value'=>'$data->cargaLink($data->path_web)',
            //'headerHtmlOptions'=>array("class"=>"hand green"),
        ),
      ),
    ));
  ?>
</div>
<script type="text/javascript">
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
              $("#modal-adjuntos").modal("hide");
              $("#modal-imagen-tif #body-imagen-tif").html(data.content);
              $("#modal-imagen-tif").modal("show");
            }
        }'
      )
  );?>
  return false;
});
</script>
