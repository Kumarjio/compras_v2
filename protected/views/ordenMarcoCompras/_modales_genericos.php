<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalCotizacion')); ?>


  <div class="modal-header">
		      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Cotización</h3> 
  </div>

  <div id="modal-content" class="modal-body">

  </div>
  <div class="modal-footer">
		      <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
  		      'url'=>'#',
  		      'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_cotizacion", 
  		      	//'onClick' => 'resetGridView("centro-costos-grid"); $("#myModal").modal("hide");$("#crearCostosModal").modal();'
  		      ),
	      	)); ?>
  </div>


<?php $this->endWidget(); ?>


<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalContacto')); ?>


  <div class="modal-header">
      <h3>Crear Contacto</h3> 
  </div>

  <div id="modal-content" class="modal-body scrollmovil">

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_contacto", 
              'onClick' => '$("#modalContacto").modal("hide");$("#modalCotizacion").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>


<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalNuevoProveedor')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Crear Proveedor</h3> 
  </div>

  <div id="modal-content" class="modal-body">

  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('id' => "cerrar_modal_proveedor", 
              'onClick' => '$("#modalNuevoProveedor").modal("hide");$("#modalProveedores").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalPagos')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>Agregar Pagos y Seleccionar</h3> 
  </div>

  <div class="modal-body">


  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal','id' => "cerrar_modal_pagos", 
              //'onClick' => '$("#modalNuevoProveedor").modal("hide");$("#modalProveedores").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'agregarPago')); ?>


  <div class="modal-header">
      <h3>Agregar Pagos y Seleccionar</h3> 
  </div>

  <div class="modal-body">
      
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('id' => "cerrar_modal_agregar_pagos", 
              'onClick' => '$("#agregarPago").modal("hide");$("#modalPagos").modal("show");'
            ),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'elegirCotizacion')); ?>


  <div class="modal-header">
      <h3>Elegir Cotización</h3> 
  </div>

  <div class="modal-body">
      
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_elegir_cotizacion"),
          )); ?>
  </div>


<?php $this->endWidget(); ?>



<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'razonEleccion')); ?>


  <div class="modal-header">
      <h3>Razon de Elección</h3> 
  </div>

  <div class="modal-body">
      
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_razon_eleccion"),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'genericModal','htmlOptions' => array('data-backdrop' => 'static'))); ?>


  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>Adjuntos</h3> 
  </div>

  <div id="modal-content" class="modal-body">
      
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal_generic"),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

