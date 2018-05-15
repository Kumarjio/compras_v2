<?php $this->menu_izquierdo=array(
	    array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico"), 'visible'=>array_intersect( array('CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>"Contrato", 'url'=>Yii::app()->createUrl("documentoProveedor/crearContratoConsulta",array("id_docpro"=>base64_encode($model[id_doc_pro_padre])))),
	    array( 'label'=>"Otrosi", 'url'=>'#', "active"=>true),
	); 
?>
<div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>

<div class='row'>
	<div class='span6'>
	<?php $this->renderPartial('_viewConsulta',array('data'=>$model_contrato,'model'=>$model)); ?>
	</div>
	<div class="span6">
	<?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
	</div>
</div>
<br>