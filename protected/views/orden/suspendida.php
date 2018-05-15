<?php

	$this->breadcrumbs=array(
		'Solicitud de compra Suspendida',
	);

	
	$this->menu=array(
	  array('label'=>'Reanudar Solicitud','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('reanudar','id'=>$orden->id),'confirm'=>'Al reanudar, no puede editar la solicitud y regresara al paso donde fue suspendida. Está seguro?')),
	  array('label'=>'Cancelar Solicitud','url'=>array('suspendidaacancelada','id'=>$orden->id),'icon'=>'trash'),
	  array('label'=>'Editar Solicitud','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('editarSuspendida','id'=>$orden->id),'confirm'=>'Está seguro de editar y reiniciar el proceso de esta solicitud?')),
	  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
	);
	


	$this->renderPartial('print',array(
				      'orden' => $orden,
				      'productos_orden' => $productos_orden,
                      'pagos' => $pagos,
                      'elegida' => $elegida,
                      'tabla'=>$tabla,
                      'observaciones' => $observaciones,
                      'tablaordenes' => $tablaordenes,
                      'tablaReemp' => $tablaReemp
				      ));
	?>
