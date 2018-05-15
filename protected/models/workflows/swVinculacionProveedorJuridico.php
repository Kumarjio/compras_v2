<?php	
return array(
	     'initial' => 'verificar_vinculacion',
	     'node' => array(
			     array('id'=>'verificar_vinculacion',	'label'=>'Verificar Vinculacion del Proveedor', 'transition' => 'recepcion_documentacion, listo_para_contrato, cancelado, enviar_a_thomas'),
				 array('id'=>'recepcion_documentacion',	'label'=>'Recepcion de Documentacion', 'transition' => 'listo_para_contrato, verificar_vinculacion, cancelado, enviar_a_thomas, ok_sin_contrato'),
				array('id'=>'listo_para_contrato',	'label'=>'Listo para Contrato', 'transition' => 'cancelado, revision_contrato, ok_sin_contrato'),
				array('id' => 'revision_contrato', 'label' => 'En Revisión del Contrato', 'transition' => 'ajustes_contrato, enviar_firmas, ok_sin_contrato, cancelado'),
				array('id' => 'ajustes_contrato', 'label' => 'En Ajustes del Contrato', 'transition' => 'revision_contrato,cancelado'),
				array('id' => 'enviar_firmas', 'label' => 'En Firmas del Contrato', 'transition' => 'revision_contrato,cancelado, revision_contrato_firmado'),
				array('id' => 'revision_contrato_firmado', 'label' => 'En Revisión de Firmas del Contrato', 'transition' => 'revision_contrato,enviar_firmas,cancelado, enviar_a_thomas'),
				array('id' => 'enviar_a_thomas', 'label' => 'En Custodia del Contrato', 'transition' => 'cancelado'),
				array('id' => 'ok_sin_contrato', 'label' => 'Ok sin contrato', 'transition' => 'cancelado'),
				array('id'=>'cancelado',	'label'=>'Cancelado por Proveedor Rechazado'),
			     )
	     )
?>