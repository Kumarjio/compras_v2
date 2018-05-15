<?php
$this->breadcrumbs=array(
	'Vinculacion Proveedor Administrativo'=>array('admin'),
	'Vincular'
);


$this->menu=array(
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
);

?>


<div class="well" id="proveedor-<?php echo $vpa->proveedor->nit; ?>">
	<form method="post">
	<?php echo CHtml::errorSummary($vpa, null, null, array('class' => 'alert alert-block alert-error')); ?>
	<h4>NIT: <?php echo $vpa->proveedor->nit; ?></h4>
	<h4>Razón Social: <?php echo $vpa->proveedor->razon_social; ?></h4>
	<br/>

	<div id="vincular-proveedor-<?php echo $vpa->proveedor->nit; ?>">
		<label class="checkbox" for="VinculacionProveedorAdministrativo_listas_control">
			<?php echo CHtml::hiddenField('codigo_seguridad', 'asdqwe123'); ?>
			<?php echo CHtml::activeCheckBox($vpa,'listas_control'); ?>
			Se verificó en las listas de control y el proveedor NO se encuentra bloqueado
		</label>
		<label class="checkbox" for="VinculacionProveedorAdministrativo_nivel_riesgo">
			Nivel de Riesgo
			<?php echo CHtml::activeDropDownList($vpa,'nivel_riesgo', array(2 => 'Bajo', 3 => 'Medio', 4 => 'Alto', 5 => 'Muy Alto'), array('onChange' => 'if($("#proveedor-'.$vpa->id_proveedor.' #VinculacionProveedorAdministrativo_nivel_riesgo option:selected").val() == 4 || $("#proveedor-'.$vpa->id_proveedor.' #VinculacionProveedorAdministrativo_nivel_riesgo option:selected").val() == 5){$("#proveedor-'.$vpa->id_proveedor.' #VinculacionProveedorAdministrativo_entrevista").attr("checked",true);}else{$("#proveedor-'.$vpa->id_proveedor.' #VinculacionProveedorAdministrativo_entrevista").attr("checked",false);}')); ?>
		</label>
		<label class="checkbox" for="VinculacionProveedorAdministrativo_entrevista">
			<?php 
			if($vpa->nivel_riesgo == 4 or $vpa->nivel_riesgo == 5){
				$vpa->entrevista = 1;
			}else{
				$vpa->entrevista = 0;
			}
			echo CHtml::activeCheckBox($vpa,'entrevista', array('disabled' => 'disabled')); ?>
			Requiere entrevista presencial
		</label>
		</form>
		</br>
		<div class="alert alert-block alert-warning fade in">
			<label for="VinculacionProveedorAdministrativo_observacion">Observacion: </label>
			<?php echo CHtml::activeTextArea($vpa,'observacion', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
		</div>
		<div class="well">
		<?php 
		$this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'button',
			'type'=>'danger',
			'label'=>'Rechazar Proveedor',
			'htmlOptions' => array(
				'onClick'=>	'
					$("#proveedor-'.$vpa->proveedor->nit.' form").attr("action", "/index.php/vinculacionProveedorAdministrativo/rechazar/id/'.$vpa->id.'");
					$("#proveedor-'.$vpa->proveedor->nit.' form").submit();'
					)
		)); 
		?>
		<?php 
			$this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'button',
				'type'=>'primary',
				'label'=>'Vincular',
				'htmlOptions' => array(
					'onClick'=>	'
						$("#proveedor-'.$vpa->proveedor->nit.' form").attr("action", "/index.php/vinculacionProveedorAdministrativo/vincular/id/'.$vpa->id.'");
						$("#proveedor-'.$vpa->proveedor->nit.' form").submit();'
						)
			));
		?>
		</div>
	</div>
</div>