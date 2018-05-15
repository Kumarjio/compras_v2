<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'active'=>true,'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
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
	<? $this->widget('bootstrap.widgets.BootGridView',array(
		'id'=>'documento-proveedor-grid',
		'dataProvider'=>$model->search_gestion(),
		'type'=>'striped bordered condensed',
		'filter'=>$model,
		'columns'=>array(
			array(
			'header'=>'Tipo Documento',
			'type'=>'raw',
			'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/update", array("id_docpro" => base64_encode($data->id_docpro))))'
			),
			array(
	            'name'=>'proveedor',
	            'type'=>'raw',
	            'value'=>'$data->traerNits()',
	            'filter'=>CHtml::textField('DocumentoProveedor[proveedor]', $model->proveedor, array('class'=>'form-control solo-numero'))
			),
			array(
	            'name'=>'name_proveedor',
	            'header'=>'Razón Social',
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
				'value'=>'$data->estado_rel->estado',
				'filter'=>CHtml::dropDownList('DocumentoProveedor[estado]', $model->estado, array(''=>'', '0'=>'Ingresado', '3'=>'Devuelto por Juridico'))
			),
			array(
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template' => '{delete}',
				'header' => 'Operaciones',
				'htmlOptions' => array('width' => '56px'),
				'buttons' => array(
					'delete' => array(
						//'url' => 'Yii::app()->createUrl("documentoProveedor/eliminarDocumento", array("id_d" => base64_encode($data->id_docpro)))',
						'url' => 'Yii::app()->createUrl("documentoProveedor/eliminaContrato", array("id" => $data->id_docpro))',
						'label' => 'Eliminar Documentos',
						'visible'=> '$data->estado==0'
					),
					/* 'update' => array(
						'url' => 'Yii::app()->createUrl("documentoProveedor/crearContrato", array("id_docpro" => $data->id_docpro))',
						'label' => 'Editar Contrato',
						'visible'=> '$data->terminado==0'
					) */
				)
			)
		)
	)); ?>
        
<h2>Contratos Solicitados </h2>
	<? $this->widget('bootstrap.widgets.BootGridView',array(
		'id'=>'documento-proveedor-grid2',
		'dataProvider'=>$model->search_gestion_solicitados(),
		'type'=>'striped bordered condensed',
		'filter'=>$model,
		'columns'=>array(
			array(
			'header'=>'Tipo Documento',
			'type'=>'raw',
			'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/update", array("id_docpro" => base64_encode($data->id_docpro))))'
			),
			array(
	            'name'=>'proveedor',
	            'type'=>'raw',
	            'filter'=>CHtml::textField('DocumentoProveedor[provaux]', $model->provaux, array('class'=>'form-control solo-numero'))
			),
			array(
				'name'=>'proveedor',
				'header'=>'Razón Social',
				'filter'=>$model->filtroProveedorSolicitados(),
				'value'=>'DocumentoProveedor::traerNombreProveedor($data->proveedor)'
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
			),
		)
	)); ?>
<script type="text/javascript">

	$(document).ready(function (){

        $('.solo-numero').keyup(function (){
           	this.value = (this.value + '').replace(/[^0-9]/g, '');
        });

    });

</script>