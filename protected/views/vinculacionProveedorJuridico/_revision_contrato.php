<div class="well" id="proveedor-<?php echo $model->nit; ?>">
	<h4>Orden: <?php echo $vpj->orden->id; ?></h4>
	<h4>NIT: <?php echo $model->nit; ?></h4>
	<h4>Razón Social: <?php echo $model->razon_social; ?></h4>
	<h4>Última Observación: <?php $o = ObservacionesWfs::model()->findAllByAttributes(array('model' => 'VinculacionProveedorJuridico', 'idmodel' => $vpj->id), array('order' => 'fecha desc', 'limit' => 1)); if(count($o) > 0){echo $o[0]['observacion'];}?></h4>
	<br/>
	<div id="proveedor-vinculado-<?php echo $model->nit; ?>" >
		  <div class="well">
			<b>Archivos Adjuntos</b><br/><br/>
		  	<?php 
			$delete_visible = false;
			if($vpj->paso_wf == "swVinculacionProveedorJuridico/revision_contrato"){
				$delete_visible = true;
			}
			$this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'adjuntos-vpj-grid',
			'dataProvider'=>$archivos->search($vpj->id),
		    //'ajaxUrl' => $this->createUrl("/adjuntosCotizacion/admin"),
			'type'=>'striped bordered condensed',
			'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
			'columns'=>array(
		        'nombre',
				'tipi',
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
		            'template' => '{download}{delete}',
		            'deleteButtonUrl'=>'Yii::app()->createUrl("/adjuntosVpj/delete", array("id" =>  $data["id"], "ajax" => 1))',
		            'buttons' => array(
		                'download' => array(
		                  'icon'=>'arrow-down',
		                  'url'=>'Yii::app()->createUrl("/adjuntosVpj/download", array("id" =>  $data["id"]))',
		                  'options' => array(
		                      'target' => '_blank'
		                   )
		                ),
		                'delete' => array(
		                  'visible' => "$delete_visible",
		                 )
		            )
				),
			),
			)); ?>
			
			<?php if($vpj->paso_wf == "swVinculacionProveedorJuridico/revision_contrato" and $vpj->usuario_actual == Yii::app()->user->id_empleado){ ?>
			    <div class="fieldset flash" id="file-uploader">
					<script type="text/javascript">
					var uploader = new qq.FileUploader({
					    // pass the dom node (ex. $(selector)[0] for jQuery users)
					    element: $('#file-uploader')[0],
					    // path to server-side upload script
					    action: '<?php echo $this->createUrl("VinculacionProveedorJuridico/subirArch") ?>',
					    sizeLimit: 3145728,
					    messages: {
					        typeError: "Solo puede adjuntar archivos .zip",
					        sizeError: "{file} es muy grande, suba máximo {sizeLimit}.",
					        emptyError: "{file} está vacío. Seleccione de nuevo los archivos",
					        onLeave: "Se están subiendo archivos. Si abandona la página se perderá el progreso"
					    },
					    uploadButtonText: 'Adjuntar archivos',
					    cancelButtonText: 'Cancelar',
					    failUploadText: 'El archivo NO subió',
					    onSubmit: function(id, fileName){
					     	this.params.id = <?php echo $vpj->id; ?>
					    },
					    onComplete: function(a,b,c){
					    	$('#adjuntos-vpj-grid').yiiGridView.update('adjuntos-vpj-grid'); 
					    }
					});
					</script>
			    </div>
			<?php } ?>
		  </div>
		</div>
	<div id="vincular-proveedor-<?php echo $model->nit; ?>">
		
		<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
		    'id'=>'documentos-vpj-form', 
		    'enableAjaxValidation'=>false, 
		)); ?>
		<div class="well">
		    <?php echo $form->errorSummary($vpj); ?>

			<?php 
			$w = Willies::model()->findByAttributes(array('id_vpj' => $vpj->id));
			if($w == null){
			?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_acuerdo_servicios',array('disabled'=>$vpj->requierePoliza('acuerdo_servicios'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_contrato',array('disabled'=>$vpj->requierePoliza('contrato'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_acuerdo_confidencialidad',array('disabled'=>$vpj->requierePoliza('acuerdo_confidencialidad'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_polizas_cumplimiento',array('disabled'=>$vpj->requierePoliza('polizas_cumplimiento'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_seriedad_oferta',array('disabled'=>$vpj->requierePoliza('seriedad_oferta'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_buen_manejo_anticipo',array('disabled'=>$vpj->requierePoliza('buen_manejo_anticipo'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_calidad_suministro',array('disabled'=>$vpj->requierePoliza('calidad_suministro'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_calidad_correcto_funcionamiento',array('disabled'=>$vpj->requierePoliza('calidad_correcto_funcionamiento'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_pago_salario_prestaciones',array('disabled'=>$vpj->requierePoliza('pago_salario_prestaciones'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_estabilidad_oferta',array('disabled'=>$vpj->requierePoliza('estabilidad_oferta'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_responsabilidad_civil_extracontractual',array('disabled'=>$vpj->requierePoliza('responsabilidad_civil_extracontractual'))); ?>

		    <?php echo $form->checkBoxRow($dvpj,'requiere_calidad_obra',array('disabled'=>$vpj->requierePoliza('calidad_obra'))); ?>
		
		<?php } ?>
	
			</br>
			<div class="alert alert-block alert-warning fade in">
			<?php echo $form->textAreaRow($vpj,'observacion', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
			</div>
	</div>
		    <div class="form-actions"> 
		        <?php 
				$vpja = VinculacionProveedorJuridico::model()->findByPk($vpj->id);
				if($vpja->paso_wf != 'swVinculacionProveedorJuridico/revision_contrato_firmado'){
				$this->widget('bootstrap.widgets.BootButton', array(
					'buttonType'=>'button',
					'type'=>'warning',
					'label'=>'Enviar Ajustes del Contrato y Pólizas Requeridas',
					'htmlOptions' => array(
						'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/enviarRevisionDocumentacion/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
							if(data.status == "success"){
								location.href="/index.php/vinculacionProveedorJuridico/admin";
							}else{
								$("#proveedor-'.$model->nit.'").replaceWith(data.content);
								return false;
							}
						},\'cache\':false});'
							)
				)); 

				
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'primary',
						'label'=>'No requiere contrato',
						'htmlOptions' => array(
							'class' => 'juridico-button',
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/aceptarDocumentacion/sincontrato/1/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == "success"){
									location.href="/index.php/vinculacionProveedorJuridico/admin";
								}else{
									alert("Ha ocurrido un error.");
									return false;
								}
							},\'cache\':false});'
								)
					));
				}else{
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'danger',
						'label'=>'Devolver Contrato Firmado',
						'htmlOptions' => array(
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/enviarRevisionDocumentacion/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == "success"){
									location.href="/index.php/vinculacionProveedorJuridico/admin";
								}else{
									$("#proveedor-'.$model->nit.'").replaceWith(data.content);
									return false;
								}
							},\'cache\':false});'
								)
					));
				}
				?>
				
				<?php 
				if($w != null){
					
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'primary',
						'label'=>($vpj->paso_wf == 'swVinculacionProveedorJuridico/revision_contrato_firmado')?"Enviar a Thomas":'Enviar a Firmas',
						'htmlOptions' => array(
							'class' => 'juridico-button',
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/aceptarDocumentacion/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == "success"){
									location.href="/index.php/vinculacionProveedorJuridico/admin";
								}else{
									alert("Ha ocurrido un error.");
									return false;
								}
							},\'cache\':false});'
								)
					));
				}
				?>
		    </div> 

		<?php $this->endWidget(); ?>

	</div>
</div>