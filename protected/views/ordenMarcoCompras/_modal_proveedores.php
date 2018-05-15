<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalProveedores')); ?>

  <div class="modal-header">
      <h3>Seleccionar Proveedor</h3>
  </div>

  <div id="modal-content" class="modal-body">

 <?php


$this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Agregar Nuevo Proveedor',
        'context' => 'info',
        'url'=>$this->createUrl('proveedor/createAjax'),
        'htmlOptions' => array(
            'href'=>$this->createUrl('proveedor/createAjax'),
            'id'=>'btn_crear_pro'
        ),
    )
);


 $this->widget('booster.widgets.TbGridView',array(
      'id'=>'proveedor-om-grid',
      'type'=>'striped bordered condensed',
      'dataProvider'=>$proveedores->search_2(),
      'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
      'filter'=>$proveedores,
      'rowCssClassExpression' => '($data->bloqueado == 1)?"proveedor_bloqueado":""',
      'pager'=>array(
              'class'=>'bootstrap.widgets.BootPager',
              'displayFirstAndLast'=>true,
      ),
      'columns'=>array(
      'nit',
      'razon_social',
      array(
          'class'=>'booster.widgets.TbButtonColumn',
          'template' => '{select}',
          'buttons'=>array
              (
                'select' => array
                (
                  'url' => '"#".$data->nit."#".$data->razon_social',
                  'label' => false,
                  'icon'=>'ok',
                  'options'=>array(
                      //'title' => 'seleccionar este proveedor', 
                      'onClick' => "
                          $('#modalProveedores').modal('hide');; 
                          setProveedor(this); 
                          resetGridView('proveedor-om-grid'); 
                          jQuery.ajax({'type':'post','dataType':'json','data':{'proveedor':$('#OmCotizacion_nit').val()},
                            'url':'".$this->createUrl('proveedor/contactos')."',
                            'success':function(data){
                              if(data.status == 'ok'){
                                $('#OmCotizacion_contacto').html(data.combo);
                                $('#crear_contacto').attr('href','".$this->createUrl('contactoProveedor/createContactoAjax')."?nit='+$('#OmCotizacion_nit').val());
                                //$('#crear_contacto_proveedor').slideDown();
                                $('#modalCotizacion').modal('show');
                              }else{
                                alert(data.mensaje);
                              }

                          },'cache':false});
                
                    "),
                ),
              ),
      ),
    ),
)); ?>
  </div>
  <div class="modal-footer">
		      <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
  		      'url'=>'#',
  		      'htmlOptions'=>array( 'id' => "cerrar_modal", 
  		      	'onClick' => '$("#modalProveedores").modal("hide");$("#modalCotizacion").modal("show");'
  		      ),
	      	)); ?>
  </div>


	    <?php $this->endWidget(); ?>