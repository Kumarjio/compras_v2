<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico"), 'visible'=>array_intersect( array('CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Consulta Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC988'), Yii::app()->user->permisos )),
		array( 'label'=>'Eliminar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>'Contratos Eliminados', 'url'=>Yii::app()->createUrl("documentoProveedor/eliminados"), 'visible'=>array_intersect( array('CYC987'), Yii::app()->user->permisos )),
		array( 'label'=>"Contrato", 'url'=>'#', "active"=>true),
		array( 'label'=>"Trazabilidad", 'itemOptions'=>array('id'=>'trazabilidad','data-toggle'=>'modal',
        'data-target'=>'#myModal')),
    ); 
	
	?>
<div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
<div class='row'>
	<div class='span5'>
		<? echo CHtml::hiddenField("id_cont", $model->id_docpro, array("id"=>"id_cont") ); ?>
		<?php $this->widget('bootstrap.widgets.BootDetailView', array(
		    'data'=>$model,
		    'attributes'=>array(
	        'nombre_contrato',
			'oferta_mercantil',
			'fecha_inicio',
			'fecha_fin',
			'fecha_firma',
			'objeto',
			'valor',
			'valor_indefinido',
			//'id_orden',
			'responsable_proveedor',
			array(
				'name'=>'responsable_compras',
				'value'=>$model->responsable_compras_rel->responsable_compras
			),
			'proroga_automatica',
			'tiempo_proroga',
			'tiempo_preaviso',
			'cuerpo_contrato',
			'anexos',
			'polizas'
			))); ?>
		
		<div class="form-actions">
			<? if(array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )){ ?>
				<a href='<?php echo $this->createUrl('adjuntoDocumento',array('id_proveedor'=>base64_encode($model->proveedor),"id_docpro"=>base64_encode($model->id_docpro),"tipo_documento"=>base64_encode($model->tipo_documento), 'fn'=>true)); ?>' class="btn btn-primary agregar-pago">Agregar Anexo</a><br>
			<? } ?>
			<br>
			<?php
				if(array_intersect( array('CYC987'), Yii::app()->user->permisos) && $model->estado != '4'){ 
					$this->widget( 'bootstrap.widgets.BootButton',array(
	                    	'buttonType'=>'button', 
	                        'type'=>'danger', 
	                        'icon'=>'trash white',
	                        'label'=>'Eliminar Contrato',
	                        'htmlOptions'=>array(
								'id'=>'btnElim'
							),
	                    )						
					); 
                }  
             ?>
		</div>
	</div>
	<div class="span7" id="divCont">
		<?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo)); ?>
	</div>
</div>
<?php 
    $this->renderPartial('documento_detalle_consulta',array('model_detalle'=>$model_detalle,'model'=>$model));
    $this->renderPartial('_trazabilidad',array('model_traza'=>$model_traza,'model'=>$model));
 ?>
 <script>

 	$('#myModal').on('hide.bs.modal', function (e) {
	 	$("#divCont").show();
	});
	$('#myModal').on('show.bs.modal', function (e) {
	  	$("#divCont").hide();
	});

  	$('#btnElim').on('click', function(){
  		if(confirm("¿Esta seguro de Eliminar el contrato?, esta acción no tiene reversa.")){
  			var idCon = $("#id_cont").val();

	       	<?	echo CHtml::ajax(array(
	            'url'=>array('documentoProveedor/eliminaContrato'), 
	            'data'=>array('id'=>'js:idCon'), 
	            'dataType'=>'json',
	            'success'=> "function(data){
	            	if(data.save){
	            		alert('El contrato fue eliminado correctamente.');
	            		location.href='consulta';
	            	}else{
	            		alert('El contrato no pudo ser eliminado.');
	            	}
	            }"
	        ))
			?>;
		}

  	})
</script>