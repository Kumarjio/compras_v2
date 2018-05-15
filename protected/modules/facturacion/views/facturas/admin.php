<?php
$this->breadcrumbs=array(
	'Facturas'=>array('admin'),
	'Listar',
);

$this->menu=array(
	array('label'=>'Listar','url'=>array('admin'), 'icon'=>'home'),
	array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign','visible' => array_intersect(array('CYC403','NORMAL'), Yii::app()->user->permisos)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('facturas-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if( array_intersect(array('CYC401'), Yii::app()->user->permisos) ){ ?>
    <div class="tab-v1">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#causacion" data-toggle="tab">Causación</a></li>
          <li><a href="#tipificacion" data-toggle="tab">Tipificación Cuentas</a></li>
          <li><a href="#lote" data-toggle="tab">Generar Lote y Causar</a></li>
          <li><a href="#otros" data-toggle="tab">Otros</a></li>
        </ul>            
        <div class="tab-content">
            <div class="tab-pane active" id="causacion">
            <?php
            $this->widget('bootstrap.widgets.BootGridView',array(
                   'id'=>'facturas-grid-caus',
                   'dataProvider'=>$model->search('causacion'),
                   'type'=>'striped bordered condensed',
                   'filter'=>$model,
                   'columns'=>array(
                           array(
                                 'header' => 'Número de Factura',
                                 'name' => 'nro_factura',
                                 'type' => 'raw',
                                 'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/update", array("id"=>$data->id_factura)))'
                                 ),
                           'nit_proveedor',
                           array(
                                'name'=>'razon_social', 
                                'header'=>'Razón Social',
                                'value'=>'$data->nitProveedor->razon_social'
                           ),
                           array(
                               'name'=>'valor_productos',
                               'type'=>'number',
                           ),
                           array(
                               'name'=>'paso_wf',
                               'value'=>'$data->labelEstado($data->paso_wf)',
                               'filter'=>array('swFacturas/causacion'=>'Causación','swFacturas/devolver_causacion'=>'Devolver a Causación')
                           ),
                           array(
                               'name'=>'usuario_actual',
                               'value'=>'$data->usuarioActual->nombre_completo'
                           ),

                           array(
                               'class'=>'bootstrap.widgets.BootButtonColumn',
                               'template' => '{cambiar}',
                               'buttons' => array(
                                   'cambiar' => array(
                                            'url' => 'Yii::app()->createUrl(\'facturacion/facturas/devolverACauasacion/id/\'. $data->id_factura)',
                                            'label' => "<i class=\"icon-repeat\"></i>",
                                            'options'=>array('title' => 'Enviar a bandeja común', 'class'=>'devolverCaus'),
                                            'visible'=>'$data->paso_wf == \'swFacturas/causacion\''
                                       )
                                   )
                           ),
                   ),
           )); 
            ?>
            </div>
            <div class="tab-pane" id="tipificacion">
            <?php
            $this->widget('bootstrap.widgets.BootGridView',array(
                   'id'=>'facturas-grid-tipi',
                   'dataProvider'=>$model->search('tipificadas'),
                   'type'=>'striped bordered condensed',
                   'filter'=>$model,
                   'columns'=>array(
                           array(
                                 'header' => 'Número de Factura',
                                 'name' => 'nro_factura',
                                 'type' => 'raw',
                                 'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/update", array("id"=>$data->id_factura)))'
                                 ),
                           'nit_proveedor',
                           array(
                    'name'=>'razon_social',
                                'header'=>'Razón Social',
                               'value'=>'$data->nitProveedor->razon_social'
                           ),
                           array(
                               'name'=>'valor_productos',
                               'type'=>'number',
                           ),
                           array(
                               'name'=>'paso_wf',
                               'value'=>'$data->labelEstado($data->paso_wf)',
                               'filter'=>array('swFacturas/enviar_fra'=>'Tipificación Cuentas','swFacturas/devolver_enviar_fra'=>'Devolver Tipificación Cuentas')
                           ),
                           array(
                               'name'=>'usuario_actual',
                               'value'=>'$data->usuarioActual->nombre_completo'
                           ),

                           array(
                               'class'=>'bootstrap.widgets.BootButtonColumn',
                               'template' => '{delete}',
                               'buttons' => array(
                                   'delete' => array(
                                       'visible' => '$data->paso_wf == "swFacturas/indexacion"'
                                       )
                                   )
                           ),
                   ),
           )); 
            ?>
            </div>
            <div class="tab-pane" id="lote">
            <?php
            $this->widget('bootstrap.widgets.BootGridView',array(
                   'id'=>'facturas-grid-lote',
                   'dataProvider'=>$model->search('lote'),
                   'type'=>'striped bordered condensed',
                   'filter'=>$model,
                   'columns'=>array(
                           array(
                                 'header' => 'Número de Factura',
                                 'name' => 'nro_factura',
                                 'type' => 'raw',
                                 'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/update", array("id"=>$data->id_factura)))'
                                 ),
                           'nit_proveedor',
                           array(
                    'name'=>'razon_social',
                                'header'=>'Razón Social',
                               'value'=>'$data->nitProveedor->razon_social'
                           ),
                           array(
                               'name'=>'valor_productos',
                               'type'=>'number',
                           ),
                           array(
                               'name'=>'paso_wf',
                               'value'=>'$data->labelEstado($data->paso_wf)',
                               'filter'=>array('swFacturas/generacion_lote'=>'Generar Lote y Causar','swFacturas/generacion_devolver_lote'=>'Devolver a Generar Lote y Causar')
                           ),
                           array(
                               'name'=>'usuario_actual',
                               'value'=>'$data->usuarioActual->nombre_completo'
                           ),

                           array(
                               'class'=>'bootstrap.widgets.BootButtonColumn',
                               'template' => '{delete}',
                               'buttons' => array(
                                   'delete' => array(
                                       'visible' => '$data->paso_wf == "swFacturas/indexacion"'
                                       )
                                   )
                           ),
                   ),
           )); 
            ?>
            </div>
            <div class="tab-pane" id="otros">
            <?php
              $this->widget('bootstrap.widgets.BootGridView',array(
            'id'=>'facturas-grid',
            'dataProvider'=>$model->search(),
            'type'=>'striped bordered condensed',
            'filter'=>$model,
            'columns'=>array(
              array(
                    'header' => 'Número de Factura',
                    'name' => 'nro_factura',
                    'type' => 'raw',
                    'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/update", array("id"=>$data->id_factura)))'
                    ),
              'nit_proveedor',
                          array(
                    'name'=>'razon_social',
                              'header'=>'Razón Social',
                              'value'=>'$data->nitProveedor->razon_social'
                          ),
                          array(
                              'name'=>'valor_productos',
                              'type'=>'number',
                          ),
                          array(
                              'name'=>'paso_wf',
                              'value'=>'$data->labelEstado($data->paso_wf)'
                          ),
                          array(
                              'name'=>'usuario_actual',
                              'value'=>'$data->usuarioActual->nombre_completo'
                          ),
                      
                    array(
                              'class'=>'bootstrap.widgets.BootButtonColumn',
                              'template' => '{delete}',
                              'buttons' => array(
                                  'delete' => array(
                                      'visible' => '$data->paso_wf == "swFacturas/indexacion"'
                                      )
                                  )
                        ),
                      ),
                    )); 
            ?>
            </div>
        </div>
    </div>

<?php }

else {
    $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'facturas-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		array(
		      'header' => 'Número de Factura',
		      'name' => 'nro_factura',
		      'type' => 'raw',
		      'value' => 'CHtml::link(($data->nro_factura=="")?"No Asignado":$data->nro_factura,Yii::app()->createUrl("facturacion/facturas/update", array("id"=>$data->id_factura)))'
		      ),
		'nit_proveedor',
                array(
                    'name'=>'razon_social',
                    'header'=>'Razón Social',
                    'value'=>'$data->nitProveedor->razon_social'
                ),
                array(
                    'name'=>'valor_productos',
                    'type'=>'number',
                ),
                array(
                    'name'=>'paso_wf',
                    'value'=>'$data->labelEstado($data->paso_wf)'
                ),
                array(
                    'name'=>'usuario_actual',
                    'value'=>'$data->usuarioActual->nombre_completo'
                ),
            
		            array(
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                    'template' => '{delete}  {cambiar}',
                    'buttons' => array(
                        'delete' => array(
                            'visible' => '$data->paso_wf == "swFacturas/indexacion"'
                        ),
                        'cambiar' => array(
                                'url' => 'Yii::app()->createUrl(\'facturacion/facturas/devolverAAdministrativo/id/\'. $data->id_factura)',
                                'label' => "<i class=\"icon-repeat\"></i>",
                                'options'=>array('title' => 'Enviar a bandeja común', 'class'=>'devolverAAdministrativo'),
                                'visible'=>'$data->paso_wf == \'swFacturas/jefatura\''
                        )
                    ),
  		),
  	),
  )); 
} 
 ?>

<script type="text/javascript">
  $('#facturas-grid-caus').find(".devolverCaus").live("click", function(e){
      e.preventDefault();
      if(confirm('¿Está seguro que desea devolver esta factura a la bandeja común?'))
          devolverABandeja(this);
  });

  $('#facturas-grid').find(".devolverAAdministrativo").live("click", function(e){
      e.preventDefault();
      if(confirm('¿Está seguro que desea devolver esta factura a la bandeja común?'))
          devolverAAdministrativo(this);
  });


  function devolverAAdministrativo(el){
      var myOktrans = function(data){
          alert(data.content);
          $('#facturas-grid').yiiGridView.update('facturas-grid');
      };
      doReq(extractUrl(el), myOktrans, null);
  }

  function devolverABandeja(el){
      var myOktrans = function(data){
          alert(data.content);
          $('#facturas-grid-caus').yiiGridView.update('facturas-grid-caus');
      };
      doReq(extractUrl(el), myOktrans, null);
  }
  

  function doReq(url, ok, fail){
        
      jQuery.ajax(
          {'url':url,
          'dataType':'json',
          'type':'post',
          'success': ok,
          'cache':false}  
      );
  } 

  function extractUrl(el){
      return $(el).attr("href");
  }
</script>