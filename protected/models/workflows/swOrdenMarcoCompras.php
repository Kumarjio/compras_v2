<?php	
return array(
	     'initial' => 'llenarocm',
	     'node' => array(
			     array('id'=>'llenarocm', 'label'=>'Diligenciamiento de la solicitud', 'transition'=>array('aprobar_por_comite'=>'$this->aprobacion_comite()')),

			     array('id'=>'cancelada', 'label'=>'Cancelar orden de compra'),
			     array('id'=>'suspendida', 'label'=>'Suspender Orden de Compra', 'transition'=>'jefe, analista_compras,cancelada'),
			     array('id'=>'devolucion', 'label'=>'Devolución a Compras', 'transition'=>array('aprobar_por_comite'=>'$this->aprobacion_comite()')),

			     array('id'=>'aprobar_por_comite', 'label'=>'Aprobación por comite de compras', 'transition' =>array( 'aprobado_por_comite'=> '$this->aprobado_comite()', 'cancelada', 'suspendida', 'devolucion' => '$this->para_devolucion()')),
			     array('id'=>'aprobado_por_comite', 'label'=>'Aprobado por comite de compras', 'transition' => 'en_consumo' ,'constraint'),
				 array('id'=>'en_consumo', 'label'=>'Consumiendo'),
				 array('id'=>'finalizada', 'label'=>'Compra Finalizada'),
		    )
	    )
?>
