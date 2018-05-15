<div class="well" id="proveedor-<?php echo $model->nit; ?>">
	<h4>NIT: <?php echo $model->nit; ?></h4>
	<h4>Razón Social: <?php echo $model->razon_social; ?></h4>
	<br/>

	<div id="vincular-proveedor-<?php echo $model->nit; ?>">
		<?php echo CHtml::errorSummary($vpj, null, null, array('class' => 'alert alert-block alert-error')); ?>
		<div class="alert alert-block alert-warning fade in">
			<label for="DocumentoVinculacionProveedorJuridico_observacion">Observacion: </label>
			<?php echo CHtml::activeTextArea($vpj,'observacion', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
		</div>
		<div class="well">
		<?php 
		$this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'button',
			'type'=>'danger',
			'label'=>'Devolver Documentacion',
			'htmlOptions' => array(
				'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/vinculacionProveedorJuridico/devolverDocumentacion/id/'.$vpj->id.'\',\'async\':false, \'data\':$(\'#proveedor-'.$model->nit.' :input\').serialize(),\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
					if(data.status == "success"){
						location.href="/index.php/vinculacionProveedorJuridico/admin";
					}else{
						$("#proveedor-'.$model->nit.'").replaceWith(data.content);
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
				'label'=>'Documentación Lista',
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
		?>

		<?php 
			$this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'button',
				'type'=>'primary',
				'label'=>'Documentación Lista y no requiere contrato',
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
		?>

		</div>
	</div>
</div>