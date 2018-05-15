<?php $this->beginWidget(
  'booster.widgets.TbModal', 
    array(
      'id'=>'modalNuevoProducto',
      'large'=>true,
      'htmlOptions' => array(
          //'class' => 'bd-example-modal-lg',
    ),
    
)); ?>

  <div class="modal-header">
      <h3>Diligenciar Formulario</h3> 
  </div>

  <div id="modal-content" class="modal-body">
    
  </div>
  <div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
  		      'url'=>'#',
  		      'htmlOptions'=>array('id' => "cerrar_modal", 
  		      	'onClick' => '$("#orden-solicitud-grid").yiiGridView.update("orden-solicitud-grid"); $("#modalNuevoProducto").modal("hide"); $(".stepContainer").height($(".stepContainer").height() + 25);'//resetGridView("centro-costos-grid"); 
		      ),
  	)); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget(
  'booster.widgets.TbModal', 
    array(
      'id'=>'modalNuevoProductoTabla',
      'large'=>true,
      'htmlOptions' => array(
          //'class' => 'bd-example-modal-lg',
    ),
    
)); ?>

  <div class="modal-header">
      <h3>Diligenciar Formulario</h3> 
  </div>

  <div id="modal-content" class="modal-body">
    
  </div>
  <div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('id' => "cerrar_modal", 
              'onClick' => '$("#modalNuevoProductoTabla").modal("hide");  $("#modalProductos").modal("show");resetGridView("productos-om-grid");'// 
          ),
    )); ?>
  </div>


<?php $this->endWidget(); ?>