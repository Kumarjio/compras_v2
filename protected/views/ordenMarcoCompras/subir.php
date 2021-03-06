 

  <div class="well">

  	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
      	'id'=>'adjuntos-cotizacion-grid',
      	'dataProvider'=>$archivos->search($_GET['id']),
        'template' => "{items}",
        'type'=>'striped bordered',
          //'ajaxUrl' => $this->createUrl("/adjuntosCotizacion/admin"),
      	'filter'=>$archivos,
      	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
      	'columns'=>array(
                'nombre',
          		  'tipi',
          		  array(
      			      'class'=>'booster.widgets.TbButtonColumn',
                  'template' => '{download} {delete}',
                  'deleteButtonUrl'=>'Yii::app()->createUrl("/ordenMarcoCompras/deleteAdjunto", array("id" =>  $data["id"], "ajax" => 1))',
                  'buttons' => array(
                      'download' => array(
                        'icon'=>'arrow-down',
                        'url'=>'Yii::app()->createUrl("/ordenMarcoCompras/downloadAdjunto", array("id" =>  $data["id"]))',
                        'options' => array(
                            'target' => '_blank'
                         )
                      ),
                      /*'delete' => array(
                        'visible' => (Yii::app()->user->getState('analista_compras'))?'true':'false',
                       )*/
                  )
      		      ),
      	),
      	)); ?>

    <div class="fieldset flash" id="file-uploader">
      
    </div>
  </div>

<?php if(Yii::app()->user->getState('analista_compras') || Yii::app()->user->getState('jefe_compras')): ?>

<script type="text/javascript">

var uploader = new qq.FileUploader({
    // pass the dom node (ex. $(selector)[0] for jQuery users)
    element: $('#file-uploader')[0],
    // path to server-side upload script
    action: '<?php echo $this->createUrl("ordenMarcoCompras/subirarch") ?>',

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
     	this.params.cotizacion = <?php echo $_GET['id']; ?>
    },

    onComplete: function(a,b,c){
    	//$('#adjuntos-cotizacion-grid').yiiGridView.update('adjuntos-cotizacion-grid'); 
    }

    

   
});

</script>

<?php endif ?>