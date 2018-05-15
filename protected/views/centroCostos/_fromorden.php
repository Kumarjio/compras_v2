

<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModal')); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar empleado</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      
  
  <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'centro-costos-grid',
    'dataProvider'=>$model->search(),
    'type'=>'striped bordered condensed',
    'updateSelector'=>'{page}',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'filter'=>$model,
    'columns'=>array(
      'codigo',
      'id_jefatura',
      'nombre',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
      ),
    ),
  )); ?>

  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>



