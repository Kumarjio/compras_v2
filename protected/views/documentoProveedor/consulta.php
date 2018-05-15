<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico"), 'visible'=>array_intersect( array('CYC998'), Yii::app()->user->permisos )),
        array( 'label'=>'Anteriores y finalizados', 'url'=>Yii::app()->createUrl("documentoProveedor/finalizados"), 'visible'=>array_intersect( array('CYC989','CYC994','CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Todos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'active'=>true, 'visible'=>array_intersect( array('CYC989','CYC994','CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Consulta Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'active'=>true, 'visible'=>array_intersect( array('CYC988'), Yii::app()->user->permisos )),
		array( 'label'=>'Editar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'active'=>true, 'visible'=>array_intersect( array('CYC986'), Yii::app()->user->permisos )),
		array( 'label'=>'Eliminar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'active'=>true, 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>'Contratos Eliminados', 'url'=>Yii::app()->createUrl("documentoProveedor/eliminados"), 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>'Crear Contrato', 'url'=>Yii::app()->createUrl("Proveedor/carga"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Informe', 'url'=>Yii::app()->createUrl("/documentoProveedor/informe"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
    ); ?>
<h2>Contratos</h2>
	<div class="form-group">
		<div style="text-align: right;">
			<?= CHtml::button('Informe Excel', array('name' => 'botonExcel', 'id' => 'botonExcel', 'class' => 'btn btn-primary', 'onClick'=>'js:exportExcel()'))?>
		</div>
	<?php $this->widget('bootstrap.widgets.BootGridView',array(
		'id'=>'documento-proveedor-grid',
		'dataProvider'=>$model->search(),
		'type'=>'striped bordered condensed',
		'filter'=>$model,
		'columns'=>array(
			'consecutivo_contrato',
			array(
			'header'=>'Tipo Documento',
			'type'=>'raw',
			'value' => '(in_array("CYC986", Yii::app()->user->permisos)) ? CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/update", array("id_docpro" => base64_encode($data->id_docpro)))) : CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/print", array("id_docpro" => base64_encode($data->id_docpro))))'
			),		
			'proveedor',
			array(
			'header'=>'Proveedor',
			'value'=>'DocumentoProveedor::traerNombreProveedor($data->proveedor)'
			),
			'nombre_contrato',
			//	'objeto',
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
				'name'=> 'fecha_firma',
				'type'=> 'text',
				'value'=> '(strlen($data->fecha_firma)>0) ? date("Y-m-d",strtotime($data->fecha_firma) ) : ""'
			),

			array(
				'name'=>'estado',
				'value'=>'$data->estado_rel->estado',
				'filter'=>CHtml::dropDownList('DocumentoProveedor[estado]', $model->estado, array(''=>'', '2'=>'Aprobado por Juridico', '7'=>'Finalizado', '8'=>'Reemplazado'))
			),
		),
	)); ?>	

	</div>

<script type="text/javascript">

    function exportExcel(){ 
        //alert();
        location.href = '<?=$this->createUrl("documentoProveedor/todosExcel")?>?';  
    }
</script>