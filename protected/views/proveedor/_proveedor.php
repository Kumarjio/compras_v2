<div class="well" id="proveedor-<?php echo $model->nit; ?>">
	<h4>NIT: <?php echo $model->nit; ?></h4>
	<h4>Razón Social: <?php echo $model->razon_social; ?></h4>
	<br/>
	
	<?php 
	if($vpa->paso_wf == "swVinculacionProveedorAdministrativo/verificar_vinculacion"){$campos_desabilitados = false;}else{$campos_desabilitados = true;}
	if($vpa->paso_wf == "swVinculacionProveedorAdministrativo/verificar_vinculacion" and $vpj->paso_wf == "swVinculacionProveedorJuridico/verificar_vinculacion"){
	echo '<label for="vinculado">El proveedor se encuentra vinculado?</label>';
	echo CHtml::activeDropDownList($vpa,'vinculado', array("Si" => "Si", "No" => "No"), array('prompt' => 'Seleccione...', 'onChange' => 'if($("#proveedor-'.$model->nit.' #VinculacionProveedorAdministrativo_vinculado option:selected").val() == "No"){$("#paso-proveedor-'.$model->nit.' .boton").slideDown(); $("#proveedor-vinculado-'.$model->nit.'").slideUp();$("#vincular-proveedor-'.$model->nit.'").slideDown();}else{$("#paso-proveedor-'.$model->nit.' .boton").slideUp(); $("#vincular-proveedor-'.$model->nit.' input").attr("checked", false); $("#vincular-proveedor-'.$model->nit.'").slideUp(); $("#proveedor-vinculado-'.$model->nit.'").slideDown();}'));
	}else{
		if($vpa->paso_wf == "swVinculacionProveedorAdministrativo/listo_para_contrato" and $vpj->paso_wf == "swVinculacionProveedorJuridico/listo_para_contrato"){
			echo "<div style='display:none;'>";
		}
		echo '<label for="vinculado">El proveedor se encuentra vinculado?</label>';
		echo CHtml::activeDropDownList($vpa,'vinculado', array("Si" => "Si", "No" => "No"), array('disabled' => "disabled"));
		if($vpa->paso_wf == "swVinculacionProveedorAdministrativo/listo_para_contrato" and $vpj->paso_wf == "swVinculacionProveedorJuridico/listo_para_contrato"){
			echo "</div>";
		}
	}
	?>
	
	<div id="vincular-proveedor-<?php echo $model->nit; ?>" style="position:relative; <?php if($vpa->vinculado != "No"){ echo 'display:none'; } ?>" >
		<h4>Documentos para la vinculación</h4>
		<?php echo CHtml::errorSummary($dvpa, null, null, array('class' => 'alert alert-block alert-error')); ?>
		<label for="DocumentoVinculacionProveedorAdministrativo_persona">Persona: </label>
		<?php echo CHtml::activeDropDownList($dvpa, 'persona', array("Natural" => "Natural", "Juridica" => "Juridica"), array('onChange' => 'if($("#vincular-proveedor-'.$model->nit.' #DocumentacionVinculacionProveedorAdministrativo_persona option:selected").val() == "Natural"){$("#paso-proveedor-'.$model->nit.' .juridico-button").attr("disabled","disabled"); $("#vincular-proveedor-'.$model->nit.' .persona_juridica input").attr("disabled", "disabled"); $("#vincular-proveedor-'.$model->nit.' .persona_natural input").removeAttr("disabled"); $("#vincular-proveedor-'.$model->nit.' .persona_juridica").slideUp(); $("#vincular-proveedor-'.$model->nit.' .persona_natural").slideDown();}else{$("#paso-proveedor-'.$model->nit.' .juridico-button").removeAttr("disabled"); $("#vincular-proveedor-'.$model->nit.' .persona_natural input").attr("disabled", "disabled"); $("#vincular-proveedor-'.$model->nit.' .persona_juridica input").removeAttr("disabled"); $("#vincular-proveedor-'.$model->nit.' .persona_natural").slideUp(); $("#vincular-proveedor-'.$model->nit.' .persona_juridica").slideDown();}', 'disabled' => ($campos_desabilitados or $vpj->paso_wf != "swVinculacionProveedorJuridico/verificar_vinculacion"))); ?>
		<div class="persona_natural" style="<?php if(($dvpa->persona != "Natural") and ($dvpa->persona != null)){ echo 'display:none'; } ?>" >
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_formato_vinculacion">
				<?php echo CHtml::activeCheckBox($dvpa,'formato_vinculacion', array('disabled' => $campos_desabilitados)); ?>
				Formato de vinculación persona natural
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_formato_entrevista">
				<?php echo CHtml::activeCheckBox($dvpa,'formato_entrevista', array('disabled' => $campos_desabilitados)); ?>
				Formato de entrevista persona natural
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_rut">
				<?php echo CHtml::activeCheckBox($dvpa,'rut', array('disabled' => $campos_desabilitados)); ?>
				RUT
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_cedula_representante_legal">
				<?php echo CHtml::activeCheckBox($dvpa,'cedula_representante_legal', array('disabled' => $campos_desabilitados)); ?>
				Cedula persona
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_certificacion_bancaria">
				<?php echo CHtml::activeCheckBox($dvpa,'certificacion_bancaria', array('disabled' => $campos_desabilitados)); ?>
				Certificacion bancaria
			</label>
		</div>
		<div class="persona_juridica" style="<?php if($dvpa->persona != "Juridica"){ echo 'display:none'; } ?>" >
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_formato_vinculacion_persona_juridica">
				<?php echo CHtml::activeCheckBox($dvpa,'formato_vinculacion_persona_juridica', array('disabled' => $campos_desabilitados)); ?>
				Formato de vinculación de persona juridica
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_formato_entrevista_persona_juridica">
				<?php echo CHtml::activeCheckBox($dvpa,'formato_entrevista_persona_juridica', array('disabled' => $campos_desabilitados)); ?>
				Formato de entrevista de persona juridica
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_rut">
				<?php echo CHtml::activeCheckBox($dvpa,'rut', array('disabled' => $campos_desabilitados)); ?>
				RUT
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_camara_comercio">
				<?php echo CHtml::activeCheckBox($dvpa,'camara_comercio', array('disabled' => $campos_desabilitados)); ?>
				Camara de comercio
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_cedula_representante_legal">
				<?php echo CHtml::activeCheckBox($dvpa,'cedula_representante_legal', array('disabled' => $campos_desabilitados)); ?>
				Cedula representante legal
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_carta_relacion_socios">
				<?php echo CHtml::activeCheckBox($dvpa,'carta_relacion_socios', array('disabled' => $campos_desabilitados)); ?>
				Carta relacion socios
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_certificacion_bancaria">
				<?php echo CHtml::activeCheckBox($dvpa,'certificacion_bancaria', array('disabled' => $campos_desabilitados)); ?>
				Certificacion bancaria
			</label>
		</div>
		<?php
		$diferentes = array();
		if($vpa->devuelto == 1){
			$diferentes = $vpa->verificarDocumentacion();
		}
		if(count($diferentes) > 0){
			echo '<div class="alert alert-error" style="position:absolute; top:5px; right:5px;">';
			echo '<h4>Documentacion devuelta por: </h4></br><p>';
			foreach($diferentes as $d){
				echo '  - '.$d."</br>";
			}
			echo '</p></div>';
		}
		?>
	</div>
	<div id="paso-proveedor-<?php echo $model->nit; ?>" style="position:relative;">
	<div class="well">
		<center><h4>Administrativo</h4></center>
		</br>
		<h5>Estado Actual: <?php echo VinculacionProveedorAdministrativo::model()->labelEstado($vpa->paso_wf); ?></h5>
		<h5>Usuario Actual: <?php $e = Empleados::model()->findByPk($vpa->usuario_actual); echo $e->nombre_completo; ?></h5>
		<h5>Última Observación: <?php $o = ObservacionesWfs::model()->findAllByAttributes(array('model' => 'VinculacionProveedorAdministrativo', 'idmodel' => $vpa->id), array('order' => 'fecha desc', 'limit' => 1)); if(count($o) > 0){echo $o[0]['observacion'];}?></h5>
		</br>
	<?php 
	if($vpa->paso_wf == "swVinculacionProveedorAdministrativo/verificar_vinculacion"){
	echo ($vpa->vinculado != "No")?"<div class='boton' style='display:none;'>":"<div class='boton'>";
	$this->widget('bootstrap.widgets.BootButton', array(
		'buttonType'=>'button',
		'type'=>'primary',
		'label'=>'Enviar a Administrativo',
		'htmlOptions' => array(
			'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorAdministrativo/enviarDocumentacion/id/'.$vpa->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
				if(data.status == "success"){
					$("#proveedor-'.$model->nit.'").replaceWith(data.content);
				}
			},\'cache\':false});return false;'
				)
	)); 
	echo "</div>";
	}
	?>
	</div>
	<div class="well">
		<center><h4>Jurídico</h4></center>
		</br>
		<h5>Estado Actual: <?php echo VinculacionProveedorJuridico::model()->labelEstado($vpj->paso_wf); ?></h5>
		<h5>Usuario Actual: <?php if($vpj->usuario_actual == 0){}else{$e = Empleados::model()->findByPk($vpj->usuario_actual); echo $e->nombre_completo;} ?></h5>
		<h5>Última Observación: <?php $o = ObservacionesWfs::model()->findAllByAttributes(array('model' => 'VinculacionProveedorJuridico', 'idmodel' => $vpj->id), array('order' => 'fecha desc', 'limit' => 1)); if(count($o) > 0){echo $o[0]['observacion'];}?></h5>
		</br>
	<?php 
	echo ($vpa->vinculado != "No" and (!$vpj->requiereContrato()))?"<div class='boton' style='display:none;'>":"<div class='boton'>";
	if($dvpa->persona == "Juridica" or ($vpj->requiereContrato() and $vpa->paso_wf == 'swVinculacionProveedorAdministrativo/listo_para_contrato')){
		if($vpj->paso_wf == "swVinculacionProveedorJuridico/verificar_vinculacion"){
		$this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'button',
			'type'=>'success',
			'label'=>'Enviar Camara de Comercio a Juridico',
			'htmlOptions' => array(
				'class' => 'juridico-button',
				'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/enviarDocumentacion/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
					if(data.status == "success"){
						$("#proveedor-'.$model->nit.'").replaceWith(data.content);
					}
				},\'cache\':false});return false;'
					)
		));
		}
	}else{
		if($vpj->paso_wf == "swVinculacionProveedorJuridico/verificar_vinculacion"){
		$this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'button',
			'type'=>'success',
			'label'=>'Enviar Camara de Comercio a Juridico',
			'htmlOptions' => array(
				'disabled' => 'disabled',
				'class' => 'juridico-button',
				'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/enviarDocumentacion/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
					if(data.status == "success"){
						$("#proveedor-'.$model->nit.'").replaceWith(data.content);
					}
				},\'cache\':false});return false;'
					)
		));
		}
	}
	echo "</div>";
	?>
	</div>
	
	<?php if(($vpa->paso_wf == "swVinculacionProveedorAdministrativo/listo_para_contrato" and ($vpj->paso_wf == "swVinculacionProveedorJuridico/listo_para_contrato") or $vpj->paso_wf == "swVinculacionProveedorJuridico/revision_contrato" or $vpj->paso_wf == "swVinculacionProveedorJuridico/ajustes_contrato" or $vpj->paso_wf == "swVinculacionProveedorJuridico/enviar_firmas")){ ?>
	<div id="proveedor-vinculado-<?php echo $model->nit; ?>" >
		  <div class="well">
			<b>Archivos Adjuntos (Contrato)</b><br/><br/>
		  	<?php 
			$delete_visible = false;
			if($vpj->paso_wf == "swVinculacionProveedorJuridico/listo_para_contrato" or $vpj->paso_wf == "swVinculacionProveedorJuridico/ajustes_contrato"){
				$delete_visible = true;
			}
			$this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'adjuntos-vpj-grid-'.$model->nit,
			'dataProvider'=>$archivos->search($vpj->id),
		    //'ajaxUrl' => $this->createUrl("/adjuntosCotizacion/admin"),
			'type'=>'striped bordered condensed',
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
			
			<?php 
			$vpja = VinculacionProveedorJuridico::model()->findByPk($vpj->id);
				if($vpa->paso_wf == "swVinculacionProveedorAdministrativo/listo_para_contrato" and ($vpja->paso_wf == "swVinculacionProveedorJuridico/listo_para_contrato" or $vpja->paso_wf == "swVinculacionProveedorJuridico/ajustes_contrato" or $vpja->paso_wf == "swVinculacionProveedorJuridico/enviar_firmas")){ ?>
			    <div class="fieldset flash" id="file-uploader-vpj-<?php echo $model->nit ?>">
					<script type="text/javascript">
					var uploader = new qq.FileUploader({
					    // pass the dom node (ex. $(selector)[0] for jQuery users)
					    element: $('#file-uploader-vpj-'+<?php echo "'".$model->nit."'" ?>)[0],
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
					    	$('#adjuntos-vpj-grid-'+<?php echo "'".$model->nit."'" ?>).yiiGridView.update('adjuntos-vpj-grid-'+<?php echo "'".$model->nit."'" ?>); 
					    }
					});
					</script>
			    </div>
			</br>
				<div class="well">
					<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
					    'id'=>'documentos-vpj-form', 
					    'enableAjaxValidation'=>false, 
					)); ?>
					<?php echo $form->errorSummary($vpj); ?>
					<?php echo $form->textAreaRow($vpj,'observacion', array('rows'=>6, 'cols'=>40, 'class'=>'span7')); ?>
					<?php $this->endWidget(); ?>
				</div>
				</br>
				<?php if($vpa->paso_wf == "swVinculacionProveedorAdministrativo/listo_para_contrato" and ($vpja->paso_wf == "swVinculacionProveedorJuridico/enviar_firmas")){ 
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'danger',
						'label'=>'Devolver a Revisión',
						'htmlOptions' => array(
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/DevolverDocumentacionContrato/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(), \'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == "success"){
									$("#proveedor-'.$model->nit.'").replaceWith(data.content);
								}else{
									alert("Error.")
								}
							},\'cache\':false});return false;'
								)
					));
					?>
					&nbsp;	
					<?php
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'primary',
						'label'=>'Enviar a Revisión de Firmas',
						'htmlOptions' => array(
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/EnviarDocumentacionContrato/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(), \'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == "success"){
									$("#proveedor-'.$model->nit.'").replaceWith(data.content);
								}else{
									alert("Error.")
								}
							},\'cache\':false});return false;'
								)
					));
				}else{
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'primary',
						'label'=>'Enviar Documentación',
						'htmlOptions' => array(
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/EnviarDocumentacionContrato/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(), \'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == "success"){
									$("#proveedor-'.$model->nit.'").replaceWith(data.content);
								}else{
									alert("Error.")
								}
							},\'cache\':false});return false;'
							)
				));
				} ?>
			<?php } ?>
		  </div>
		</div>
		<?php } ?>
		
	<?php 
	$w = Willies::model()->findByAttributes(array('id_vpj' => $vpj->id));
	if($w != null){
		$dvpj = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $vpj->id));
	?>
	<?php if($w != null and $archivos_w != null){ ?>
	<div class="well">
		<center><h4>Willis</h4></center>
		</br>
		<h5>Estado Actual: <?php echo Willies::model()->labelEstado($w->paso_wf); ?></h5>
		<h5>Usuario Actual: <?php if($w->usuario_actual == 0){}else{$e = Empleados::model()->findByPk($w->usuario_actual); echo $e->nombre_completo;} ?></h5>
		<h5>Última Observación: <?php $o = ObservacionesWfs::model()->findAllByAttributes(array('model' => 'Willies', 'idmodel' => $w->id), array('order' => 'fecha desc', 'limit' => 1)); if(count($o) > 0){echo $o[0]['observacion'];}?></h5>
		<h5>Pólizas: </h5>
		<p><?php $d = $dvpj->polizas(); echo ($d == null or $d == '')?"No se seleccionó ninguna póliza.":$d; ?> </p>
		</br>
		<b>Archivos Adjuntos</b><br/><br/>
	  	<?php 
		$delete_visible_w = false;
		if($w->paso_wf == "swWillies/ajustes_contrato"){
			$delete_visible_w = true;
		}
		$this->widget('bootstrap.widgets.BootGridView',array(
		'id'=>'adjuntos-willies-grid-'.$model->nit,
		'dataProvider'=>$archivos_w->search($w->id),
	    //'ajaxUrl' => $this->createUrl("/adjuntosCotizacion/admin"),
		'type'=>'striped bordered condensed',
		'columns'=>array(
	        'nombre',
			'tipi',
			array(
				'class'=>'bootstrap.widgets.BootButtonColumn',
	            'template' => '{download}{delete}',
	            'deleteButtonUrl'=>'Yii::app()->createUrl("/adjuntosWillies/delete", array("id" =>  $data["id"], "ajax" => 1))',
	            'buttons' => array(
	                'download' => array(
	                  'icon'=>'arrow-down',
	                  'url'=>'Yii::app()->createUrl("/adjuntosWillies/download", array("id" =>  $data["id"]))',
	                  'options' => array(
	                      'target' => '_blank'
	                   )
	                ),
	                'delete' => array(
			                  'visible' => "$delete_visible_w",
	                 )
	            )
			),
		),
		)); ?>
	<?php 
	if($w->paso_wf == "swWillies/ajustes_contrato"){
	?>
	<div class="fieldset flash" id="file-uploader-w-<?php echo $model->nit; ?>">
		<script type="text/javascript">
		var uploader = new qq.FileUploader({
		    // pass the dom node (ex. $(selector)[0] for jQuery users)
		    element: $('#file-uploader-w-'+<?php echo "'".$model->nit."'" ?>)[0],
		    // path to server-side upload script
		    action: '<?php echo $this->createUrl("Willies/subirArch") ?>',
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
		     	this.params.id = <?php echo $w->id; ?>
		    },
		    onComplete: function(a,b,c){
		    	$('#adjuntos-willies-grid-'+<?php echo "'".$model->nit."'" ?>).yiiGridView.update('adjuntos-willies-grid-'+<?php echo "'".$model->nit."'" ?>); 
		    }
		});
		</script>
    </div>
	</br>
	<?php
	$this->widget('bootstrap.widgets.BootButton', array(
		'buttonType'=>'button',
		'type'=>'primary',
		'label'=>'Enviar a Willies',
		'htmlOptions' => array(
			'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/enviarAWillis/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
				if(data.status == "success"){
					$("#proveedor-'.$model->nit.'").replaceWith(data.content);
				}
			},\'cache\':false});return false;'
				)
	)); 
	}
	?>
	</div>
	<?php } ?>
	<?php } ?>
	</div>
	<div id="proveedor-vinculado-<?php echo $model->nit; ?>" <?php if($vpa->vinculado != "Si" or $vpa->paso_wf != "swVinculacionProveedorAdministrativo/verificar_vinculacion" or $vpj->paso_wf != "swVinculacionProveedorJuridico/verificar_vinculacion"){ echo 'style="display:none"'; } ?> >
		<?php 
		$this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
			'label'=>'Notificar Proveedor ya Vinculado',
			'htmlOptions' => array(
				'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorAdministrativo/listoParaContrato/id/'.$vpa->id.'\',\'async\':false, \'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
					if(data.status == "success"){
						$("#proveedor-'.$model->nit.'").replaceWith(data.content);
					}
				},\'cache\':false});return false;'
					)
		)); ?>
	</div>	
</div>
