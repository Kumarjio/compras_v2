<?php
$this->setPageTitle('Impresion Imagine');
?>
<div class="x_title">
  <h2>Bandeja de impresión Imagine</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class="col-md-1">
	<?php $this->widget(
    'booster.widgets.TbButton',
    array(
      'icon'=>'glyphicon glyphicon-list-alt',
      'label' => 'Excel',
      'context' => 'success',
      'id'=>'btnExcel'
    )
);  ?>
</div>
<div class="col-md-1">
  <?php $this->widget(
    'booster.widgets.TbButton',
    array(
      'icon'=>'glyphicon glyphicon-print',
      'label' => 'Impresión',
      'context' => 'primary',
      'id'=>'btnImprimir'
    )
);  ?>
</div>
<div class='col-md-8'></div>
<div class='col-md-2'>
  <?php echo CHtml::activeTextField($model,'buscar',array('class'=>'form-control','maxlength'=>'24','placeholder'=>'Consulta caso...')); ?>
</div> 
<br>
<br>
<br>
<br>
<div class='col-md-12'>
  <?php
  $this->widget('booster.widgets.TbGridView',array(
  'id'=>'pendientes-grid',
  'dataProvider'=>$model->search_impresion(''),
  'ajaxType'=>'POST',
  'filterSelector'=>'{filter}, #Cartas_buscar, select',
  'type' => 'striped',
  'afterAjaxUpdate'=>'function(id, data){$(\'.checkImpresion\').on(\'change\',function(e){actualizar(this);});}',
  'responsiveTable' => true,
  'columns'=>array(
      array(
        'header'=>'Imprimir', 
        'visible'=>'false', 
        'value'=>'($data->impreso == 0) ? CHtml::checkBox("chk_".$data->id, false, array("value"=>$data->id, "id"=>"chk_".$data->id, "class"=>"checkImpresion")) : ""',
        'type'=>'raw',
      ),
    	array(
        'name'=>'caso',
        'value'=>'$data->na'
      ),
    	array(
        'name'=>'destinatario',
        'value'=>'$data->nombre_destinatario'
      ),
    	array(
        'name'=>'principal',
        'value'=>'$data->principal'
      ),
    	array(
        'name'=>'courrier',
        'value'=>'$data->idProveedor->proveedor'
      ),
    	array(
        'name'=>'tipología',
        'value'=>'$data->na0->tipologia0->tipologia'
      ),
    	array(
        'name'=>'impreso',
        'value'=>'( $data->impreso == 1 ) ? "SI" : "NO"'
      ),
    ),
  )); ?>
</div>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-alerta')
); ?>
<div class="modal-header">
    <h4 align="center"> Alerta! </h4>
</div>
<div class="modal-body" id="body-alerta">
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
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-pre-excel')
); ?>
<div class="modal-header">
    <h4 align="center"><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/warning.png','this is alt tag of image',
        array('width'=>'20','height'=>'20','title'=>'Usuario')); 
        echo CHtml::link($image); ?> Atención</h4>
</div>
<div class="modal-body">
  <h5 align="center " class="red">Debe puntear para generar registros.</h5 align="center">
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
<iframe id="impexcel1" class="oculto"></iframe>
<iframe id="impexcel2" class="oculto">></iframe>
<script type="text/javascript">
  $(document).ready(function(){
    $('.checkImpresion').on('change',function(e){
      actualizar(this);
    });
    $('#Cartas_buscar').keyup(function (){
      this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    $("#btnImprimir").click(function(){
      <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'url' => $this->createUrl("generaImpresion"),
          'success' => 'function(res){
            $("#pendientes-grid").yiiGridView.update("pendientes-grid");  
            $("#body-alerta").html(res);
            $("#modal-alerta").modal("show");
          }'
        )
      );?>
    });

    $("#btnExcel").click(function(){
      <?php echo CHtml::ajax(
          array(
            'type' => 'POST',
            'url' => $this->createUrl("consultaRegistrosImp"),
            'success' => 'function(res){
              if(res != ""){
                if(confirm("¿Desea descargar informe punteados?")){
                  $("#impexcel1").attr("src", \''.$this->createUrl("punteoExcelImp").'\').load();
                  $("#impexcel2").attr("src", \''.$this->createUrl("punteoExcel472Imp").'\').load();
                }
              }else{
                $("#modal-pre-excel").modal("show");
              }
            }'
          )
        );?>
    });

  });

  function actualizar(selector){
    var id_carta = selector.value;
      <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'data' => array('id_carta' => 'js:id_carta'),
          'url' => $this->createUrl("activaImpresion"),
          'success' => 'function(res){
            $("#pendientes-grid").yiiGridView.update("pendientes-grid");  
            $("#body-alerta").html(res);
            $("#modal-alerta").modal("show");
          }'
        )
      );?>
  }
</script>