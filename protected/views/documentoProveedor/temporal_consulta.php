<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico"), 'visible'=>array_intersect( array('CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/view",array("id_proveedor"=>base64_encode($model[proveedor]))), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Consulta Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC988'), Yii::app()->user->permisos )),
		array( 'label'=>'Eliminar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>"Documento Temporal", 'url'=>'#', "active"=>true),
		array( 'label'=>"Trazabilidad", 'itemOptions'=>array('id'=>'trazabilidad','data-toggle'=>'modal',
        'data-target'=>'#myModal')),
    ); ?>
<div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
<div class='row'>
	<div class='span5'>

<?php $this->widget('bootstrap.widgets.BootDetailView', array(
    'data'=>$model,
    'attributes'=>array(
	'objeto',

	'responsable_proveedor',
    array(
		'name'=>'responsable_compras',
		'value'=>$model->responsable_compras_rel->responsable_compras
		),
	'id_orden'
		))); ?>

	</div>
</div>
<?php 
if($model->id_docpro>0){
	$this->renderPartial('documento_detalle_consulta',array('model_detalle'=>$model_detalle,'model'=>$model));
}
	$this->renderPartial('_trazabilidad',array('model_traza'=>$model_traza,'model'=>$model));

	?>