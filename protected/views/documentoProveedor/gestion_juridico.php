<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico"), 'active'=>true),
		array( 'label'=>'Anteriores y finalizados', 'url'=>Yii::app()->createUrl("documentoProveedor/finalizados"), 'visible'=>array_intersect( array('CYC989','CYC994','CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Todos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC989','CYC994','CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Consulta Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC988'), Yii::app()->user->permisos )),
		array( 'label'=>'Editar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC986'), Yii::app()->user->permisos )),
		array( 'label'=>'Eliminar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>'Contratos Eliminados', 'url'=>Yii::app()->createUrl("documentoProveedor/eliminados"), 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>'Crear Contrato', 'url'=>Yii::app()->createUrl("Proveedor/carga"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Informe', 'url'=>Yii::app()->createUrl("/documentoProveedor/informe"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
    ); ?>
	<h2>Contratos Asignados </h2>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'documento-proveedor-grid',
	'dataProvider'=>$model->search_gestionJuridico(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		array(
		'header'=>'Tipo Documento',
		'type'=>'raw',
		'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/updateJuridico", array("id_docpro" => base64_encode($data->id_docpro))))'
		),
		array(
            'name'=>'proveedor',
            'type'=>'raw',
            'value'=>'$data->traerNits()',
            'filter'=>CHtml::textField('DocumentoProveedor[proveedor]', $model->proveedor, array('class'=>'form-control solo-numero'))
		),
		array(
            'name'=>'name_proveedor',
            'header'=>'Razon Social',
            'type'=>'raw',
            'value'=>'$data->traerRazonSocial()'
		),
		'nombre_contrato',
		'objeto',
		array(
			'name'=> 'fecha_inicio',
			'type'=> 'text',
			'value'=> '(strlen($data->fecha_inicio)>0) ? date("Y-m-d",strtotime($data->fecha_inicio) ) : ""'
		),
		array(
			'name'=> 'fecha_fin',
			'type'=> 'text',
			'value'=> '(strlen($data->fecha_fin)>0) ? date("Y-m-d",strtotime($data->fecha_fin) ) : ""'
		),
		array(
			'header'=>'No. Documentos',
			'value'=>'DocumentoProveedor::numDocs($data->id_docpro)'
		),
    array(
			'header'=>'Estado',
			'value'=>'$data->estado_rel->estado'
		)
	),
)); ?>

<script type="text/javascript">

	$(document).ready(function (){

        $('.solo-numero').keyup(function (){
           	this.value = (this.value + '').replace(/[^0-9]/g, '');
        });

    });

</script>