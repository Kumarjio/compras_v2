<?php	
return array(
	     'initial' => 'llenaroc',
	     'node' => array(
			     array('id'=>'llenaroc', 'label'=>'Diligenciamiento de la solicitud', 'transition'=>'jefe, analista_compras, jefe_ventas_alkosto'),
			    
			     array('id'=>'jefe', 'label'=>'Revisión del jefe', 'constraint' => '((Yii::app()->user->getState("jefe") == false) && (Yii::app()->user->getState("gerente") == false))', 'transition'=>'analista_compras,devolucion,cancelada,suspendida'),

                 //Paso extra: Todas las solicitudes de compra que monte Paulina Aguirre (jefe mercadeo Alkosto), deben ir después a Alejandro Uribe (jefe de ventas Alkosto)
                 array('id'=>'jefe_ventas_alkosto', 'label'=>'Revisión del jefe de ventas de alkosto', 'constraint' => 'Yii::app()->user->id_empleado == 71', 'transition' => 'analista_compras, devolucion, cancelada, suspendida'),
			     array('id'=>'gerente', 'label'=>'Revisión del Gerente', 'constraint' => '(Yii::app()->user->getState("jefe") == true)', 'transition'=>'analista_compras,devolucion,cancelada,suspendida,jefe'),
			     array('id'=>'cancelada', 'label'=>'Cancelar orden de compra'),
			     array('id'=>'suspendida', 'label'=>'Suspender Orden de Compra', 'transition'=>'jefe, analista_compras,cancelada'),
			     array('id'=>'devolucion', 'label'=>'Devolución al usuario', 'transition'=>'jefe, jefe_ventas_alkosto, analista_compras,cancelada'),
                 array('id'=>'analista_compras', 'label'=>'Validación en compras', 'constraint' => '(Yii::app()->user->getState("gerente") == true || Yii::app()->user->getState("jefe") == true || Yii::app()->user->getState("jefe_compras") == true || Yii::app()->user->getState("desde_correo") == true) && Yii::app()->user->id_empleado != 71','transition'=>'en_negociacion,devolucion,suspendida,jefe'),
			     array('id'=>'en_negociacion', 'label'=>'Negociación en Contratación y Compras','transition'=>'validacion_cotizaciones, gerente_compra,suspendida,cancelada,analista_compras'),
			     array('id'=>'validacion_cotizaciones', 'label'=>'Validación de cotizaciones por el jefe', 'constraint' => '$this->verificar_usuario_gerente($this->id_usuario) == false', 'transition' => 'gerente_compra, en_negociacion, devolucion'),
			     //array('id'=>'gerente_compra', 'label'=>'Validación de cotizaciones por el gerente','transition' => 'aprobar_por_atribuciones, aprobar_por_comite, aprobar_por_presidencia, aprobar_por_junta,suspendida,cancelada,validacion_cotizaciones', 'constraint' => '$this->verificar_usuario_gerente($this->id_usuario) or (Yii::app()->user->getState("jefe") == true or Yii::app()->user->getState("jefe_compras") == true)'),
			     array('id'=>'gerente_compra', 'label'=>'Validación de cotizaciones por el gerente','transition' => 'aprobar_por_atribuciones, aprobar_por_comite, suspendida,cancelada,validacion_cotizaciones', 'constraint' => '$this->verificar_usuario_gerente($this->id_usuario) or (Yii::app()->user->getState("jefe") == true or Yii::app()->user->getState("jefe_compras") == true)'),
			     array('id'=>'aprobar_por_atribuciones', 'constraint' => '$this->verificar_atribuciones()', 'label'=>'Aprobación por atribuciones', 'transition' =>'aprobado_por_atribuciones, aprobar_por_comite,cancelada,suspendida,devolucion'),
			     array('id'=>'aprobado_por_atribuciones', 'label'=>'Aprobado por atribuciones', 'transition' => 'en_negociacion, usuario'),
			     array('id'=>'aprobar_por_comite', 'constraint' => '$this->verificar_comite("Compras")', 'label'=>'Aprobación por comite de compras', 'transition' => 'aprobado_por_comite, aprobar_por_presidencia, aprobar_por_junta, cancelada,suspendida, devolucion, en_negociacion'),
			     array('id'=>'aprobar_por_presidencia', 'constraint' => '$this->verificar_comite("Presidencia")', 'label'=>'Aprobación por comite de presidencia', 'transition' => 'aprobado_por_presidencia,aprobar_por_junta,cancelada,suspendida, devolucion, en_negociacion'),
                 array('id'=>'aprobar_por_junta', 'label'=>'Aprobación por junta directiva','constraint' => '$this->verificar_comite("Junta")', 'transition' => 'aprobado_por_junta,cancelada,suspendida, devolucion, en_negociacion'),
			     array('id'=>'aprobado_por_comite', 'label'=>'Aprobado por comite de compras', 'transition' => 'en_negociacion, usuario' ,'constraint' => '$this->verificar_comite("ap_x_comite")'),
			     array('id'=>'aprobado_por_presidencia', 'label'=>'Aprobado por comite de presidencia', 'transition' => 'en_negociacion, usuario'),
                 array('id'=>'aprobado_por_junta', 'label'=>'Aprobado por junta directiva', 'transition' => 'en_negociacion, usuario'),
                 array('id'=>'usuario', 'label'=>'Compra Aprobada', 'transition' => 'finalizada'),
				 array('id'=>'finalizada', 'label'=>'Compra Finalizada'),
				 array('id'=>'cancaler_post_aprobacion', 'label'=>'Cancelar post aprobación','transition' => 'cancelada, usuario'),
			     )
	     )
?>
