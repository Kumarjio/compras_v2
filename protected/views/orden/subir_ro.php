  <div class="well">

  	<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'adjuntos-proveedor-recomendado-grid',
	'dataProvider'=>$archivos->search($_GET['orden_solicitud_proveedor']),
    //'ajaxUrl' => $this->createUrl("/adjuntosCotizacion/admin"),
	'type'=>'striped bordered condensed',
	'filter'=>$archivos,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
        'nombre',
		'tipi',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
            'template' => '{download}',
            'buttons' => array(
                'download' => array(
                  'icon'=>'arrow-down',
                  'url'=>'Yii::app()->createUrl("/adjuntosProveedorRecomendado/download", array("id" =>  $data["id"]))',
                  'options' => array(
                      'target' => '_blank'
                   )
                )
            )
		),
	),
	)); ?>
	
  </div>