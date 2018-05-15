
<div class="x_title">

    <div class="row">
        <div class="col-md-6">
          <h2>Miembros de <?php $proveedor = Proveedor::model()->findByPk($_GET['id']); echo $proveedor->razon_social;  ?></h2>
        
        </div>
        <div class="col-md-6">
        
          <div align="right">
          
            <?php
            $this->widget(
                    'booster.widgets.TbButtonGroup',
                    array(    
                        'size' => 'large',
                        'buttons' => array(array(
                          'label'=>'Acciones',
                          'items'=>
                            array(
                                  array('label'=>'Crear','url'=>array('create'), 'icon'=>'fa fa-plus'),
                                  array('label'=>'Listar Productos','url'=>array('admin'), 'icon'=>'fa fa-folder-open'),
                            ),  
                          )
                      )
                    )
                );
            ?>
          </div>
        </div>
    </div>
  <div class="clearfix"></div>
</div>
<div class="x_content">
    <div class="row">
        <div class="col-md-12">
                <?php $this->widget('bootstrap.widgets.BootButton', array(
                    'type'=>'warning',
                    'label'=>'Nuevo Miembro',
                    'htmlOptions' => array(
                      'class'=>"crear-cotizacion",
                      'data-url' => $this->createUrl('proveedorMiembros/create', array('nit' => $_GET['id']))
                     )
                  )); ?>
              
              <?php $this->widget('booster.widgets.TbGridView',array(
                'id'=>'proveedor-miembros-grid',
                'dataProvider'=>$miembros->search($_GET['id']),
                'type'=>'striped bordered condensed',
                'filter'=>$miembros,
                'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                'columns'=>array(
                  'id',
                  'nit',
                  'tipo_documento',
                  'documento_identidad',
                  'nombre_completo',
                  'participacion',
                  'porcentaje_participacion',
                  array(
                    'class'=>'booster.widgets.TbButtonColumn',
                    'template' => '{update} {delete}',
                    'buttons' => array(
                      'update' => array(
                        'url' => 'Yii::app()->createUrl("proveedorMiembros/update", array("id" => $data->id))',
                        'icon' => 'pencil',
                        'options' => array(
                          'class' => 'update-member' 
                        ),
                      ),
                      'delete' => array(
                            'url'=>'Yii::app()->createUrl("proveedorMiembros/delete", array("id"=>$data->id))',
                        'options'=>array('class'=>'delete')
                        ),
                    )
                  ),
                ),
              )); ?>
        </div>
    </div>
</div>


<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'genericModal')); ?>


  <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
      <h3>&nbsp;</h3> 
  </div>

  <div id="modal-content" class="modal-body">
       Cargando...
  </div>
  <div class="modal-footer">
          <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
          )); ?>
  </div>


<?php $this->endWidget(); ?>

<script type="text/javascript">
function nuevoRegistro(url)
{
    
    jQuery.ajax({'url':url,'data':$('#genericModal div.modal-body form').serialize(),'type':'post','dataType':'json','success':function(data)
            {
                if (data.status == 'failure')
                {
                    $('#genericModal div.modal-body').html("");
                    $('#genericModal div.modal-body').html(data.div);
                    $('#genericModal div.modal-body form').submit(function(e){ e.preventDefault(); nuevoRegistro(url); });
                }
                else
                {
                    //$('#cotizacion-grid_'+ producto_orden).yiiGridView.update('cotizacion-grid_'+ producto_orden);
                    $("#"+data.grid).yiiGridView.update(data.grid);
                    $('#genericModal div.modal-body').html("");
                    $('#genericModal').modal('hide');
                }
 
            } ,'cache':false});

    
    return false; 
 
}

$(document).ready(function(){
	

  $(".crear-cotizacion, .update-member").live("click", function(e){
    e.preventDefault();
    //$('#genericModal').modal('hide');
    jQuery('.tooltip').remove();
    $('#genericModal div.modal-body').html("");
    nuevoRegistro($(this).attr("href") || $(this).attr("data-url"));    
    $('#genericModal').modal('show');
  });


});
 
</script>