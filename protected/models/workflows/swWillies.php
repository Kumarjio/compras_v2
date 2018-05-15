<?php	
return array(
	     'initial' => 'ajustes_contrato',
	     'node' => array(
			     array('id'=>'ajustes_contrato',	'label'=>'Ajustes Contrato', 'transition' => 'revision_polizas, cancelado, enviar_a_thomas'),
				 array('id'=>'revision_polizas',	'label'=>'Revision de las Pólizas', 'transition' => 'ajustes_contrato, enviar_a_thomas, cancelado'),
				array('id'=>'enviar_a_thomas',	'label'=>'Pólizas Validadas Correctamente', 'transition' => 'cancelado'),
				array('id'=>'cancelado',	'label'=>'Cancelado por Proveedor Rechazado'),
			     )
	     )
?>