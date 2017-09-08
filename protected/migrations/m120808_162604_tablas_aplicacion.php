<?php

class m120808_162604_tablas_aplicacion extends CDbMigration
{
	public function safeUp()
	{
		
		$this->createTable("orden", array(
			'id' => 'pk',
			'orden' => 'integer',
			'tipo_compra' => 'integer',
			'nombre_compra' => 'string',
			'resumen_breve' => 'text',
			'id_gerencia' => 'integer',
			'id_jefatura' => 'integer',
			'fecha_solicitud' => 'timestamp DEFAULT now()',
			'id_gerente' => 'integer',
			'id_jefe' => 'integer',
			'id_usuario' => 'integer',
			'validacion_usuario' => 'integer',
			'validacion_jefe' => 'integer',
			'validacion_gerente' => 'integer',
			'usuario_actual' => 'integer',	
			'paso_wf' => 'string NOT NULL'			
		));
		
		$this->createTable("orden_solicitud", array(
			//'centro_costos' => 'integer',
			//'cuenta_contable' => 'integer',
			//'valor_presupuestado' => 'string',
			//'mes_presupuestado' => 'string',
			'id'=>'pk',
			'id_orden' => 'integer',
			'nombre' => 'string',
			'cantidad' => 'integer',
			'detalle' => 'text',
			'fecha_entrega' => 'date',
			'requiere_acuerdo_servicios' => 'integer',
			'requiere_polizas_cumplimiento' => 'integer',	
			'requiere_contrato' => 'integer',
			'nit' => 'integer',
			'proveedor' => 'string'
		));
		
		$this->createTable("orden_solicitud_direccion", array(
			'id'=>'pk',
			'id_orden_solicitud' => 'integer',
			'cantidad' => 'integer',
			'direccion_entrega' => 'string',
			'responsable' => 'string',
			'ciudad' => 'string',
			'departamento' => 'string',
			'telefono' => 'string'
		));
		
		$this->createTable("orden_solicitud_costos", array(
			'id'=>'pk',
			'id_orden_solicitud' => 'integer',
			'porcentaje_o_cantidad' => 'string',
			'numero' => 'numeric',
			'id_centro_costos' => 'integer',
			'id_cuenta_contable' => 'integer',
			'presupuestado' => 'string',
			'valor_presupuestado' => 'string',
			'mes_presupuestado' => 'string',
		));
		
		$this->createTable("orden_solicitud_proveedor", array(
			'id'=>'pk',
			'id_orden_solicitud' => 'integer',
			'nit' => 'integer',
			'proveedor' => 'string',
			'cantidad' => 'integer',
			'valor_unitario' => 'numeric',
			'moneda' => 'string',
			'total_compra' => 'numeric'
		));



		$this->createTable("orden_observacion", array(
			'id' => 'pk',
			'id_orden' => 'integer',
			'observacion' => 'text NOT NULL',
			'usuario' => 'string NOT NULL',
			'paso_wf' => 'string NOT NULL',
			'creacion' => 'timestamp NOT NULL'
		));


		$this->createTable("orden_adjuntos", array(
			'id' => 'pk',
			'id_orden' => 'integer NOT NULL',
			'path' => 'string NOT NULL'			
		));

		$this->createTable("centro_costos", array(
			'id' => 'pk',
			'codigo' => 'integer NOT NULL',
			'id_jefatura' => 'integer NOT NULL',
			'nombre' => 'string NOT NULL',
			'activo' => 'string'
		));

		$this->createTable("cuenta_contable", array(
			'id' => 'pk',
			'codigo' => 'string NOT NULL',
			'nombre' => 'string NOT NULL'
		));

		$this->createTable("proveedor", array(
			'nit' => 'pk',
			'razon_social' => 'string NOT NULL',
		));

		$this->createTable("proveedor_miembros", array(
			'id' => 'pk',
			'nit' => 'integer NOT NULL',
			'tipo_documento' => 'string NOT NULL',
			'documento_identidad' => 'string NOT NULL',
			'nombre_completo' => 'string NOT NULL',
			'participacion' => 'string NOT NULL',
			'porcentaje_participacion' => 'numeric NOT NULL'
		));

		$this->createTable("tipo_compra", array(
			'id' => 'pk',
			'nombre' => 'string NOT NULL',
			'responsable' => 'integer NOT NULL' 		
		));

		$this->createTable("producto", array(
			'id' => 'pk',
			'nombre' => 'string NOT NULL',
		));

		$this->createTable("producto_orden", array(
			'id' => 'pk',
			'orden' => 'integer NOT NULL',
			'producto' => 'integer',
			'orden_solicitud' => 'integer NOT NULL'
		));

		$this->createTable("cotizacion", array(
			'id' => 'pk',
			'producto_orden' => 'integer NOT NULL',
			'nit' => 'integer NOT NULL',
			'cantidad' => 'integer NOT NULL',
			'moneda' => 'string NOT NULL',
			'valor_unitario' => 'integer NOT NULL',
			'total_compra' => 'integer NOT NULL',
			'calificacion' => 'integer NOT NULL',
			'descripcion' => 'text NOT NULL',
			'razon_eleccion_usuario' => 'text',
			'razon_eleccion_compras' => 'text',
			'razon_eleccion_comite' => 'text',
			'enviar_a_usuario' => 'integer',
			'elegido_compras' => 'integer',
			'elegido_usuario' => 'integer',
			'elegido_comite' => 'integer'
		));

		$this->createTable("adjuntos_cotizacion", array(
			'id' => 'pk',
			'cotizacion' => 'integer NOT NULL',
			'nombre' => 'string NOT NULL',
			'usuario' => 'string NOT NULL',
			'path' => 'integer NOT NULL',
			'tipi' => 'string NOT NULL'
		));
		
		$this->createTable("adjuntos_proveedor_recomendado", array(
			'id' => 'pk',
			'proveedor_recomendado' => 'integer NOT NULL',
			'nombre' => 'string NOT NULL',
			'usuario' => 'string NOT NULL',
			'path' => 'integer NOT NULL',
			'tipi' => 'string NOT NULL'
		));
		
		$this->createTable("adjuntos_orden", array(
			'id' => 'pk',
			'orden' => 'integer NOT NULL',
			'nombre' => 'string NOT NULL',
			'usuario' => 'string NOT NULL',
			'path' => 'integer NOT NULL',
			'tipi' => 'string NOT NULL'
		));


		$this->createTable("estado", array(
			'id' => 'pk',
			'nombre' => 'string NOT NULL',
		
		));

		$this->createTable("gerencias", array(
			'id' => 'pk',
			'nombre' => 'string NOT NULL',
			'actualizacion' => 'timestamp'
		));

		$this->createTable("jefaturas", array(
			'id' => 'pk',
			'id_gerencia' => 'integer NOT NULL',
			'nombre' => 'string NOT NULL',
		));


		$this->createTable("empleados", array(
			'id' => 'pk',
			'nombre_completo' => 'string NOT NULL',
			'genero' => 'string NOT NULL',
			'tipo_documento' => 'string NOT NULL',
			'numero_identificacion' => 'string NOT NULL',
			'activo' => 'string NOT NULL',
			'embarazo' => 'string',
			'tiempo_gestacion' => 'integer',
			'fecha_probable_parto' => 'integer',
			
		));

		$this->createTable("cargos", array(
				'id' => 'pk',
				'id_jefatura' => 'integer DEFAULT NULL',
				'id_gerencia' => 'integer DEFAULT NULL',
				'nombre' => 'string NOT NULL',
				'recibe_dotacion' => 'string',
				'es_jefe' => 'string',
				'es_gerente' => 'string',
				'activo' => 'string',
			
		));

		$this->createTable("contratos", array(
			'id' => 'pk',
			'id_cargo' => 'integer NOT NULL', 
			'salario' => 'integer', 
			'id_empleado' => 'integer NOT NULL',
			'id_empleador' => 'integer',
			'fecha_inicio' => 'date NOT NULL',
			'fecha_fin' => 'date',
			'id_motivo_ingreso' => 'integer',
			'id_motivo_retiro' => 'integer',
			
		));

		$this->createTable("permisos", array(
			'id' => 'pk',
			'controllador_accion' => 'integer NOT NULL', 
			
		));

		$this->createTable("activerecordlog", array(
			'id' => 'pk',
			'action' => 'string',
			'model' => 'string',
			'idmodel' => 'integer',
			'iduser' => 'integer',      
			'field' => 'string',
			'username' => 'string',
			'description' => 'string',
			'description_new' => 'string',
			'fecha'=> "timestamp DEFAULT now()", 
		));

		$this->createTable("trazabiliadwfs", array(
			'id' => 'pk',
			'model' => 'string',
			'idmodel' => 'integer',
			'usuario_anterior' => 'integer', 
			'usuario_nuevo' => 'integer',     
			'estado_anterior' => 'string',
			'estado_nuevo' => 'string',
			'fecha'=> "timestamp DEFAULT now()"
		));

		$this->createTable("observacioneswfs", array(
			'id' => 'pk',
			'model' => 'string',
			'idmodel' => 'integer',
			'usuario' => 'integer', 
			'estado_anterior' => 'string',
			'estado_nuevo' => 'string',
			'observacion' => 'text',
			'fecha'=> "timestamp DEFAULT now()"
		));
		
		$this->createTable("atribuciones", array(
			'id' => 'pk',
			'id_empleado' => 'integer NOT NULL',
			'atribucion_disponible' => 'numeric NOT NULL',
			'atribucion_real' => 'numeric NOT NULL'
		));
		
		$this->createTable("asistentes_comite", array(
			'id' => 'pk',
			'id_empleado' => 'integer NOT NULL',
			'id_orden' => 'integer NOT NULL',
			'fecha_comite' => 'timestamp',
			'tipo_comite' => 'string'
		));
		
		$this->createTable("asistentes_comite_compras", array(
			'id' => 'pk',
			'id_empleado' => 'integer NOT NULL'
		));
		
		$this->createTable("asistentes_comite_presidencia", array(
			'id' => 'pk',
			'id_empleado' => 'integer NOT NULL'
		));
	
		$this->addForeignKey("fk_id_empleado","atribuciones","id_empleado","empleados","id","RESTRICT");
		
		$this->addForeignKey("fk_id_jefatura","centro_costos","id_jefatura","jefaturas","id","RESTRICT");
		
		$this->addForeignKey("fk_id_empleado","asistentes_comite","id_empleado","empleados","id","RESTRICT");
		$this->addForeignKey("fk_id_orden","asistentes_comite","id_orden","orden","id","RESTRICT");
		
		$this->addForeignKey("fk_id_empleado","asistentes_comite_compras","id_empleado","empleados","id","RESTRICT");
		
		$this->addForeignKey("fk_id_empleado","asistentes_comite_presidencia","id_empleado","empleados","id","RESTRICT");
		
		$this->addForeignKey("fk_id_jefatura","cargos","id_jefatura","jefaturas","id","RESTRICT");
		$this->addForeignKey("fk_id_gerencia","cargos","id_gerencia","gerencias","id","RESTRICT");

		$this->addForeignKey("fk_id_cargo","contratos","id_cargo","cargos","id","RESTRICT");
		$this->addForeignKey("fk_id_empleado","contratos","id_empleado","empleados","id","RESTRICT");
		$this->addForeignKey("fk_id_jefatura_gerencia","jefaturas","id_gerencia","gerencias","id","RESTRICT");

		$this->addForeignKey("fk_orden_tipocompra","orden","tipo_compra","tipo_compra","id","RESTRICT");
		
		$this->addForeignKey("fk_orden_solicitud_orden","orden_solicitud","id_orden","orden","id","CASCADE","CASCADE");
		
		$this->addForeignKey("fk_orden_solicitud_costos_orden_solicitud","orden_solicitud_costos","id_orden_solicitud","orden_solicitud","id","CASCADE","CASCADE");

		$this->addForeignKey("fk_orden_gerencia","orden","id_gerencia","gerencias","id","RESTRICT");
		$this->addForeignKey("fk_orden_jefatura","orden","id_jefatura","jefaturas","id","RESTRICT");

		$this->addForeignKey("fk_orden_empleado_gerente","orden","id_gerente","empleados","id","RESTRICT");
		$this->addForeignKey("fk_orden_empleado_jefe","orden","id_jefe","empleados","id","RESTRICT");
		$this->addForeignKey("fk_orden_empleado_usuario","orden","id_usuario","empleados","id","RESTRICT");
		$this->addForeignKey("fk_orden_empleado_usuario_actual","orden","usuario_actual","empleados","id","RESTRICT");

		$this->addForeignKey("fk_orden_solicitud_costos_centro_costos","orden_solicitud_costos","id_centro_costos","centro_costos","id","RESTRICT");
		$this->addForeignKey("fk_orden_solicitud_costos_cuenta_contable","orden_solicitud_costos","id_cuenta_contable","cuenta_contable","id","RESTRICT");
		
		$this->addForeignKey("fk_orden_centro_costos","orden_observacion","id_orden","orden","id","RESTRICT");
		$this->addForeignKey("fk_orden_adjuntos","orden_adjuntos","id_orden","orden","id","RESTRICT");

		$this->addForeignKey("fk_producto_orden_producto","producto_orden","producto","producto","id","RESTRICT");
		$this->addForeignKey("fk_producto_orden_orden","producto_orden","orden","orden","id","RESTRICT");

		$this->addForeignKey("fk_cotizacion_producto_orden","cotizacion","producto_orden","producto_orden","id","CASCADE");
		$this->addForeignKey("fk_cotizacion_proveedor","cotizacion","nit","proveedor","nit","RESTRICT","CASCADE");

		$this->addForeignKey("fk_adjuntos_cotizacion_cotizacion","adjuntos_cotizacion","cotizacion","cotizacion","id","CASCADE");

		$this->addForeignKey("fk_proveedor_miembros_proveedor","proveedor_miembros","nit","proveedor","nit","RESTRICT","CASCADE");

		$this->addForeignKey("fk_tipo_compra_empleado","tipo_compra","responsable","empleados","id","RESTRICT");


	}

	public function safeDown()
	{
		//No hay migracion hacia abajo
		
	}
}