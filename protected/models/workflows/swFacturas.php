<?php	
return array(
	     'initial' => 'recepcion_documento',
	     'node' => 
                array(
                        array(
                                'id'=>'recepcion_documento',
                                'label'=>'Recepción Factura', 
                                'transition' => array(
                                    'indexacion'=>'$this->paraIndexacion()'
                                )
                            ),
                        array(
                                'id'=>'indexacion',	
                                'label'=>'Indexación', 
                                'transition' => array(
                                    'revisionanalista'=>'$this->paraAnalista()'
                                )
                            ),
                        array(
                                'id'=>'devolver_indexacion',	
                                'label'=>'Devolver Indexación',  
                                'transition' => array(
                                    'revisionanalista'=>'$this->paraAnalista()'
                                )
                            ),
                        array(
                                'id'=>'revisionanalista',	
                                'label'=>'Revisión Analista', 
                                'transition' => array(
                                    'aprobar_jefe'=>'$this->paraJefe()',
                                    'devolver_indexacion'=>'$this->devolverIndexacion()'
                                )
                            ),
                        array(
                                'id'=>'devolver_revision_analista',	
                                'label'=>'Devolver Revisión Analista', 
                                'transition' => array(
                                    'aprobar_jefe'=>'$this->paraJefe()',
                                    'devolver_indexacion'=>'$this->devolverIndexacion()'
                                )
                            ),
                        array(
                                'id'=>'aprobar_jefe',	
                                'label'=>'Aprobación Jefe', 
                                'transition' => array(
                                    'causacion'=>'$this->paraCausacion()',
                                    'aprobar_gerente'=>'$this->paraGerente()',
                                    'devolver_revision_analista'=>'$this->paraAnalista()',
                                )
                            ),
                        array(
                                'id'=>'devolver_aprobar_jefe',	
                                'label'=>'Devolver Aprobación Jefe', 
                                'transition' =>  array(
                                    'causacion'=>'$this->paraCausacion()',
                                    'devolver_revision_analista'=>'$this->paraAnalista()',
                                    'aprobar_gerente'=>'$this->paraGerente()'
                                )
                            ),
                        array(
                                'id'=>'aprobar_gerente',	
                                'label'=>'Aprobación Gerente', 
                                'constraint' => '!$this->tieneOrden()',
                                'transition' => array(
                                    'causacion'=>'$this->paraCausacion()',
                                    'devolver_aprobar_jefe'=>'$this->paraJefe()',
                                )
                            ),
                        array(
                                'id'=>'devolver_aprobar_gerente',	
                                'label'=>'Devolver Aprobación Gerente', 
                                'constraint' => '!$this->tieneOrden()',
                                'transition' =>  array(
                                    'causacion'=>'$this->paraCausacion()',
                                    'devolver_aprobar_jefe'=>'$this->paraJefe()',
                                )
                            ),
                        array(
                                'id'=>'causacion',	
                                'label'=>'Causación',
                                'constraint' => '$this->tieneOrden() || Yii::app()->user->getState("gerente") == true',//$this->paso_wf == "swFacturas/aprobar_gerente" || $this->paso_wf == "swFacturas/devolver_aprobar_gerente" || $this->paso_wf == "swFacturas/causacion" ',//($this->paso_actual == "" && ($this->paso_wf == "swFacturas/aprobar_gerente" || $this->paso_wf == "swFacturas/devolver_aprobar_gerente")) || ($this->paso_actual == "swFacturas/aprobar_gerente" || $this->paso_actual == "swFacturas/devolver_aprobar_gerente")',
                                'transition' =>  array(
                                    'enviar_fra',
                                    'devolver_revision_analista'=>'$this->paraAnalista()',
                                    'devolver_aprobar_jefe'=>'$this->paraJefe()',
                                    'devolver_aprobar_gerente'=>'$this->paraGerente()'
                                )
                            ),
                        array(
                                'id'=>'devolver_causacion',	
                                'label'=>'Devolver a Causación',
                                'transition' => array(
                                    'enviar_fra',
                                    'devolver_aprobar_jefe'=>'$this->paraJefe()'
                                )
                            ),
                        array(
                                'id'=>'enviar_fra',	
                                'label'=>'Tipificación Cuentas',
                                'transition' =>array( 
                                    'generacion_lote',
                                    'devolver_causacion'=>'$this->devolucionCausacion()',
                                )
                            ),
                        array(
                                'id'=>'devolver_enviar_fra',	
                                'label'=>'Devolver Tipificación Cuentas',
                                'transition' => 'generacion_lote, devolver_causacion'
                            ),
                        array(
                                'id'=>'generacion_lote',	
                                'label'=>'Generar Lote y Causar',
                                'transition' => array(
                                    'jefatura'=>'$this->paraAdministrativo()', 
                                    'modificar_registros_tipificada', 
                                    'modificar_fecha_normal', 
                                    'modificar_todas_fechas', 
                                    'eliminacion_lote'
                                )
                            ),
                        array(
                                'id'=>'generacion_devolver_lote',	
                                'label'=>'Devolver a Generar Lote y Causar',
                                'transition' => array(
                                    'jefatura'=>'$this->paraAdministrativo()', 
                                    'modificar_registros_tipificada', 
                                    'modificar_fecha_normal', 
                                    'modificar_todas_fechas', 
                                    'eliminacion_lote'
                                )
                            ),
                        array(
                                'id'=>'modificar_registros_tipificada',	
                                'label'=>'Modificar Registros Tipificada',
                                'transition' => 'generacion_lote'
                            ),
                        array(
                                'id'=>'modificar_fecha_normal',	
                                'label'=>'Modificación Lote (Fecha Normal)',
                                'transition' => 'generacion_lote'
                            ),
                        array(
                                'id'=>'modificar_todas_fechas',	
                                'label'=>'Modificación Lote (Todas Las Fechas)',
                                'transition' => 'generacion_lote'
                            ),
                        array(
                                'id'=>'eliminacion_lote',	
                                'label'=>'Eliminación Lote',
                                'transition' => 'causacion'
                            ),
                        array(
                                'id'=>'jefatura',	
                                'label'=>'Administrativo',
                                'transition' => array(
                                    'aprobada'=>'$this->paraOperaciones()',
                                    'generacion_devolver_lote'=>'$this->para_generar_lote_dev()'
                                )
                            ),
                        array(
                                'id'=>'aprobada',	
                                'label'=>'Operaciones',
                                'transition' => array(
                                    'pagada'
                                )
                            ),
                        array(
                                'id'=>'dev_proveedor',	
                                'label'=>'Devolver al proveedor'
                            ),
                        array(
                                'id'=>'pagada',	
                                'label'=>'Factura Pagada'
                            ),
                    )
	     )
?>