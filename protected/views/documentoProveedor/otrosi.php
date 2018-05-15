<?php
$volver= ($fn)? 'crearContratoConsulta':(($tipo_documento_p==1 or $tipo_documento_p==2 ) ? 'crearContrato' : 'CrearTemporal');
$this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/view",array("id_proveedor"=>base64_encode($model[proveedor]))), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>"Principal", 'url'=>Yii::app()->createUrl("documentoProveedor/".$volver,array("id_docpro"=>base64_encode($model[id_doc_pro_padre]), 'fn'=>$fn))),
		array( 'label'=>"Agregar Documentos", 'url'=>Yii::app()->createUrl("documentoProveedor/adjuntoDocumento",
			array(	"id_proveedor"=>base64_encode($model[proveedor]),
					"id_docpro"=>base64_encode($model[id_doc_pro_padre]),
					"tipo_documento"=>base64_encode($tipo_documento_p),
                                        'fn'=>$fn
				))),
		array( 'label'=>"Otrosi", 'url'=>'#', "active"=>true),
    ); ?>
<div class="row"><div class='span5' id='nomProvOtrosi'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>

<div class='row'>
	<div class='span6'>
	<?php $this->renderPartial('_view',array('data'=>$model_contrato,'model'=>$model,'edita'=>true,'proveedores'=>$proveedores)); ?>
	</div>
	<div class="span6">
	<?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
	</div>
</div>
<br/>