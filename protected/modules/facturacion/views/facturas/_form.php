<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'facturas-form',
	'enableAjaxValidation'=>false,
        'clientOptions'=>array(
            ''
        )
)); ?>
        <div class='row'>
            <div class='span5'>
                <?php if($alertas_nit): ?>
                    <?php if($alertas_nit->indicador1 == 2 || $alertas_nit->indicador2 == 1 || $alertas_nit->indicador3 == 2 || $alertas_nit->indicador4 == 2): ?>
                    <div class="alert alert-block alert-warning fade in">
                            <a class="close" data-dismiss="alert">×</a>
                            <strong>Alerta!</strong><br>
                            <?php if($alertas_nit->indicador1 == 2): ?>
                            El nit no existe en AS400<br>
                            <?php endif; ?>
                            <?php if($alertas_nit->indicador2 == 1): ?>
                                Este nit se encuentra en al menos una lista de clientes no deseables<br>
                            <?php endif; ?>
                            <?php if($alertas_nit->indicador3 == 2): ?>
                                El proveedor tiene documentos incompletos<br>
                            <?php endif; ?>
                            <?php if($alertas_nit->indicador4 == 2): ?>
                                El proveedor tiene documentos vencidos<br>
                            <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php echo $form->errorSummary($model); ?>
                
                    <?php //echo $form->textFieldRow($model,'id_orden',array('class'=>'span5','readonly'=>true)); ?>
                <?php
                $pasos =  array('swFacturas/aprobar_jefe', 'swFacturas/devolver_aprobar_jefe', 'swFacturas/aprobar_gerente','swFacturas/devolver_aprobar_gerente');
                $modificar_campos =($model->paso_actual == "")? (in_array($model->paso_wf, $pasos) ) : (in_array($model->paso_actual, $pasos) );?> 
                <?php if ($ver == 3)
                        echo $this->renderPartial('_form_index',array('form'=>$form,'model'=>$model,'readonly'=>$readonly,'modificar_campos'=>$modificar_campos));
                      if ($ver == 4)
                        echo $this->renderPartial('_form_resp',array('form'=>$form,'model'=>$model,'readonly'=>$readonly,'modificar_campos'=>$modificar_campos));  ?>
            
                    
                   
                   
                
            </div>
            
            <!--div class="visor-wrapper span7">
              
              
              <div id="visor_jpg" class="jpg">
                      <strong>Debe actualizar el Flash Player para visualizar las imágenes</strong><br><a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=shockwaveFlash"> Click para instalar la última versión</a>
                  
              </div>
              
              <div class="pdf">
               
               
             </div>
          


            </div-->
            <div class="span7" id="divCont">
                <?php  //echo CHtml::textField($name) ?>
                <?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_imagen));  ?>
            </div>
        </div>
<?php $this->endWidget(); ?>
        
<script type="text/javascript">
$(document).ready(function(){
   
});
</script>



<script>


/*
var visor_settings = {
    url : "https://<? //echo $_SERVER['HTTP_HOST'];?>",
    urlpdf : "https://<? //echo $_SERVER['HTTP_HOST'];?>"
};

jQuery(document).ready(function($) {
  jQuery('a[rel="tooltip"]').tooltip();

  //Consulta.init.setup("principales");
  var algo = new SWFObject("/swf/zoomtest.swf", "zoomFlash", "550", "289", "9", "#FFFFFF");
  algo.addParam("menu","false");
  algo.addParam("allowFullScreen","true");
  algo.addVariable("image","/forbidden.php/facturacion/facturas/imagenpermiso?path="+"<?php //echo $model->path_imagen;?>");
  //algo.addParam("wmode", "opaque");
  algo.write("visor_jpg");
});
*/
</script>



<?php /*$this->widget('application.extensions.SGenericWidget',array(
      'pluginName'=>'zoomfla',
      ));*/
  ?>

<?php /*$this->widget('application.extensions.SGenericWidget',array(
      'pluginName'=>'thick',
      ));*/
  ?>
