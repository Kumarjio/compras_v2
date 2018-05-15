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
            'template' => '{download}{delete}',
            'deleteButtonUrl'=>'Yii::app()->createUrl("/adjuntosProveedorRecomendado/delete", array("id" =>  $data["id"], "ajax" => 1))',
            'buttons' => array(
                'download' => array(
                  'icon'=>'arrow-down',
                  'url'=>'Yii::app()->createUrl("/adjuntosProveedorRecomendado/download", array("id" =>  $data["id"]))',
                  'options' => array(
                      'target' => '_blank'
                   )
                ),
                'delete' => array(
                  'visible' => 'true',
                 )
            )
		),
	),
	)); ?>

    <div class="fieldset flash" id="file-uploader-<?php echo $_GET['orden_solicitud_proveedor']; ?>">
      
    </div>
  </div>

<script type="text/javascript">

var uploader = new qq.FileUploader({
    // pass the dom node (ex. $(selector)[0] for jQuery users)
    element: $('#file-uploader-<?php echo $_GET['orden_solicitud_proveedor']; ?>')[0],
    // path to server-side upload script
    action: '<?php echo $this->createUrl("orden/subirarch") ?>',

    sizeLimit: 3145728,

    
    messages: {
        typeError: "Solo puede adjuntar archivos .zip",
        sizeError: "{file} es muy grande, suba máximo {sizeLimit}.",
        emptyError: "{file} está vacío. Seleccione de nuevo los archivos",
        onLeave: "Se están subiendo archivos. Si abandona la página se perderá el progreso"
    },

    uploadButtonText: 'Adjuntar archivos',
    cancelButtonText: 'Cancelar',
    failUploadText: 'El archivo NO subió',

    onSubmit: function(id, fileName){
     	this.params.orden_solicitud_proveedor = <?php echo $_GET['orden_solicitud_proveedor']; ?>
    },

    onComplete: function(a,b,c){
    	$('#adjuntos-proveedor-recomendado-grid').yiiGridView.update('adjuntos-proveedor-recomendado-grid'); 
    }

    

   
});

</script>