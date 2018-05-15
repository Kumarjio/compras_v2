<?php $this->menu_izquierdo=array(
      array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
      array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
      array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico"), 'visible'=>array_intersect( array('CYC998'), Yii::app()->user->permisos )),
      array( 'label'=>"Contrato", 'url'=>Yii::app()->createUrl("documentoProveedor/crearContratoConsulta",array("id_docpro"=>base64_encode($model[id_doc_pro_padre])))),
      array( 'label'=>"Poliza", 'url'=>'#', "active"=>true),
  ); 
?>
<div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
<div class='row'>
  <div class='span5'>
    <? $this->widget('bootstrap.widgets.BootGridView',array(
      'id'=>'poliza-grid',
      'dataProvider'=> PolizaDocumento::model()->search($model->id_docpro),
      'type'=>'striped bordered condensed',
      'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
      'columns'=>array(
          'fecha_inicio',
          'fecha_fin',
          array(
              'name'=>'id_tipo_poliza',
              'value'=>'$data->tipoPoliza->tipo_poliza'
          ),
      ),
    )); ?>       
  </div>
  <div class="span7">
    <?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
  </div> 
</div> 
<br>