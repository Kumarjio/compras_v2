<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico"), 'visible'=>array_intersect( array('CYC998'), Yii::app()->user->permisos )),
        array( 'label'=>'Anteriores y finalizados', 'url'=>Yii::app()->createUrl("documentoProveedor/finalizados"), 'visible'=>array_intersect( array('CYC989','CYC994','CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Todos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC989','CYC994','CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Consulta Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC988'), Yii::app()->user->permisos )),
		array( 'label'=>'Editar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC986'), Yii::app()->user->permisos )),
		array( 'label'=>'Eliminar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>'Contratos Eliminados', 'url'=>Yii::app()->createUrl("documentoProveedor/eliminados"), 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>'Crear Contrato', 'url'=>Yii::app()->createUrl("Proveedor/carga"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Informe', 'url'=>Yii::app()->createUrl("/documentoProveedor/informe"), 'active'=>true, 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
    ); ?>

<h2>Informe Contratos Próximos a Vencer</h2>
	<div class="form-group">
		<div style="text-align: right;">
			<?= CHtml::button('Informe Excel', array('name' => 'botonExcel', 'id' => 'botonExcel', 'class' => 'btn btn-primary', 'onClick'=>'js:exportExcel(1)'))?>
		</div>

		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'informe-proveedor-vence',
			'dataProvider'=>$model->search_informe(),
			'type'=>'striped bordered condensed',
			'filter'=>$model,
			'columns'=>array(
				array(
					'header'=>'Tipo Documento',
					'type'=>'raw',
					'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/print", array("id_docpro" => base64_encode($data->id_docpro))))',
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'5%')
				),	
				array(	
					'name'=>'proveedor',
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'10%')
				),	
				array(
					'header'=>'Proveedor',
					'value'=>'DocumentoProveedor::traerNombreProveedor($data->proveedor)',
					'htmlOptions'=>array('width'=>'20%')
				),
				array(	
					'name'=>'nombre_contrato',
					'htmlOptions'=>array('width'=>'14%')
				),	
				array(	
					'name'=>'objeto',
					'htmlOptions'=>array('width'=>'25%')
				),
				array(
					'name'=> 'fecha_inicio',
					'type'=> 'text',
					'value'=> '(strlen($data->fecha_inicio)>0) ? date("Y-m-d",strtotime($data->fecha_inicio) ) : ""',
					'filter' => false,
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'8%')
				),
				array(
					'header'=>'Fecha Fin',
					'type'=> 'text',
					'value'=> '$data->calculaFechaFin($data->id_docpro)',
					'filter' => false,
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'8%')
				),
				array(
					'name'=>'estado',
					'value'=>'$data->estado_rel->estado',
					'filter' => false,
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'10%')
				),
			),
		)); ?>	
	</div>
	<br>
<h2>Informe Contratos Próximos a Preaviso</h2>
	<div class="form-group">
		<div style="text-align: right;">
			<?= CHtml::button('Informe Excel', array('name' => 'botonExcel', 'id' => 'botonExcel', 'class' => 'btn btn-primary', 'onClick'=>'js:exportExcel(2)'))?>
		</div>

		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'informe-proveedor-preaviso',
			'dataProvider'=>$model->search_informe_preaviso(),
			'type'=>'striped bordered condensed',
			'filter'=>$model,
			'columns'=>array(
				array(
					'header'=>'Tipo Documento',
					'type'=>'raw',
					'value' => 'CHtml::link($data->tipo_documento_rel->tipo_documento, Yii::app()->createUrl("documentoProveedor/print", array("id_docpro" => base64_encode($data->id_docpro))))',
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'5%')
				),	
				array(	
					'name'=>'proveedor',
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'10%')
				),	
				array(
					'header'=>'Proveedor',
					'value'=>'DocumentoProveedor::traerNombreProveedor($data->proveedor)',
					'htmlOptions'=>array('width'=>'20%')
				),
				array(	
					'name'=>'nombre_contrato',
					'htmlOptions'=>array('width'=>'14%')
				),	
				array(	
					'name'=>'objeto',
					'htmlOptions'=>array('width'=>'25%')
				),
				array(
					'name'=> 'fecha_inicio',
					'type'=> 'text',
					'value'=> '(strlen($data->fecha_inicio)>0) ? date("Y-m-d",strtotime($data->fecha_inicio) ) : ""',
					'filter' => false,
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'8%')
				),
				array(
					'header'=>'Frecha Preaviso',
					'type'=> 'text',
					'value'=> '$data->calculaFechaFin($data->id_docpro,true)',
					'filter' => false,
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'8%')
				),
				array(
					'name'=>'estado',
					'value'=>'$data->estado_rel->estado',
					'filter' => false,
					'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'10%')
				),
			),
		)); ?>	
	</div>

<script type="text/javascript">

    function exportExcel(val){ 
        //alert();
        location.href = '<?=$this->createUrl("documentoProveedor/informeExcel/pre/'+val+'")?>?';  
    }
</script>