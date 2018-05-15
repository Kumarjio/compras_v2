<?php	
return array(
	     'initial' => 'verificar_vinculacion',
	     'node' => array(
			     array('id'=>'verificar_vinculacion',	'label'=>'Verificar Vinculacion del Proveedor', 'transition' => 'recepcion_documentacion, listo_para_contrato, cancelado'),
				 array('id'=>'recepcion_documentacion',	'label'=>'Recepcion de Documentacion', 'transition' => 'en_vinculacion, verificar_vinculacion, cancelado'),
				array('id'=>'en_vinculacion',	'label'=>'En Vinculación', 'transition' => 'listo_para_contrato, cancelado'),
				array('id'=>'listo_para_contrato',	'label'=>'Listo para Contrato', 'transition' => 'cancelado'),
				array('id'=>'cancelado',	'label'=>'Cancelado por Proveedor Rechazado'),
			     )
	     )
?>