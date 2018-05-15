<div class="well" id="proveedor-<?php echo $model->nit; ?>">
	<h4>NIT: <?php echo $model->nit; ?></h4>
	<h4>Razón Social: <?php echo $model->razon_social; ?></h4>
	<br/>

	<div id="vincular-proveedor-<?php echo $model->nit; ?>">
		<h4>Documentos para la vinculación</h4>
		<?php if(($dvpa->persona == "Natural")){ ?>
		<div class="persona_natural">
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_formato_vinculacion">
				<?php echo CHtml::activeCheckBox($dvpa,'formato_vinculacion'); ?>
				Formato de vinculación persona natural
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_formato_entrevista">
				<?php echo CHtml::activeCheckBox($dvpa,'formato_entrevista'); ?>
				Formato de entrevista persona natural
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_rut">
				<?php echo CHtml::activeCheckBox($dvpa,'rut'); ?>
				RUT
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_cedula_representante_legal">
				<?php echo CHtml::activeCheckBox($dvpa,'cedula_representante_legal'); ?>
				Cedula persona
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_certificacion_bancaria">
				<?php echo CHtml::activeCheckBox($dvpa,'certificacion_bancaria'); ?>
				Certificacion bancaria
			</label>
		</div>
		<?php } ?>
		<?php if($dvpa->persona == "Juridica"){ ?>
		<div class="persona_juridica" >
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_formato_vinculacion_persona_juridica">
				<?php echo CHtml::activeCheckBox($dvpa,'formato_vinculacion_persona_juridica'); ?>
				Formato de vinculación de persona juridica
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_formato_entrevista_persona_juridica">
				<?php echo CHtml::activeCheckBox($dvpa,'formato_entrevista_persona_juridica'); ?>
				Formato de entrevista de persona juridica
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_rut">
				<?php echo CHtml::activeCheckBox($dvpa,'rut'); ?>
				RUT
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_camara_comercio">
				<?php echo CHtml::activeCheckBox($dvpa,'camara_comercio'); ?>
				Camara de comercio
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_cedula_representante_legal">
				<?php echo CHtml::activeCheckBox($dvpa,'cedula_representante_legal'); ?>
				Cedula representante legal
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_carta_relacion_socios">
				<?php echo CHtml::activeCheckBox($dvpa,'carta_relacion_socios'); ?>
				Carta relacion socios
			</label>
			<label class="checkbox" for="DocumentoVinculacionProveedorAdministrativo_certificacion_bancaria">
				<?php echo CHtml::activeCheckBox($dvpa,'certificacion_bancaria'); ?>
				Certificacion bancaria
			</label>
		</div>
		<?php } ?>
		</br>
		<div class="well">
		<?php 
		$this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'button',
			'type'=>'danger',
			'label'=>'Devolver Documentacion',
			'htmlOptions' => array(
				'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorAdministrativo/devolverDocumentacion/id/'.$vpa->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
					if(data.status == "success"){
						location.href="/index.php/vinculacionProveedorAdministrativo/admin";
					}else{
						return false;
					}
				},\'cache\':false});'
					)
		)); 
		?>
		<?php 
			$this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'button',
				'type'=>'primary',
				'label'=>'Continuar a vinculación',
				'htmlOptions' => array(
					'class' => 'juridico-button',
					'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorAdministrativo/aceptarDocumentacion/id/'.$vpa->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
						if(data.status == "success"){
							location.href="/index.php/vinculacionProveedorAdministrativo/admin";
						}else{
							alert("Los documentos recibidos no coinciden con los documentos enviados por el analista.")
							return false;
						}
					},\'cache\':false});'
						)
			));
		?>
		</div>
	</div>
</div>