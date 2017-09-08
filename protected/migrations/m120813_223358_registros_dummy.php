<?php

class m120813_223358_registros_dummy extends CDbMigration
{
	public function safeUp()
	{
		
		$this->execute("insert into gerencias(id, nombre) values (1,'Gerencia de Tecnologia')");
		$this->execute("insert into gerencias(id, nombre) values (2,'Gerencia de Operaciones')");
		$this->execute("insert into jefaturas(id, nombre, id_gerencia) values (1,'Jefatura de Infraestructura', 1)");
		$this->execute("insert into jefaturas(id, nombre, id_gerencia) values (2,'Jefatura de Gestión de Aplicaciones', 1)");
		$this->execute("insert into cargos (id, id_gerencia, nombre, es_jefe, es_gerente, activo) values (1, 1, 'Gerente de Tecnologia','No','Si',1)");
		$this->execute("insert into cargos (id, id_jefatura, nombre, es_jefe, es_gerente, activo) values (2,1,'Jefe de Infraestructura','Si','No',1)");
		$this->execute("insert into cargos (id, id_jefatura, nombre, es_jefe, es_gerente, activo) values (3,2,'Jefe de Gestion de Aplicaciones','Si','No',1)");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (1,'Juan Diego Arango','M','CC','21321446','Si')");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (2,'Juan Fernando Gomez','M','CC','54332111','Si')");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (3,'Diego Velez','M','CC','65432244','Si')");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (4,'Santiago Oquendo','M','CC','1037578768','Si')");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (5,'Daniela','M','CC','34213456','Si')");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (6,'Daniel','M','CC','43567876','Si')");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (7,'comite','M','CC','213214346','Si')");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (8,'presidencia','M','CC','213123246','Si')");
		$this->execute("insert into empleados (id, nombre_completo, genero, tipo_documento, numero_identificacion, activo) values (9,'jefe_compras','M','CC','91823172','Si')");
		$this->execute("insert into contratos (id, id_cargo, id_empleado,fecha_inicio) values (1,1,1,'2000-02-01')");
		$this->execute("insert into contratos (id, id_cargo, id_empleado,fecha_inicio) values (2,2,2,'2000-02-01')");
		$this->execute("insert into contratos (id, id_cargo, id_empleado,fecha_inicio) values (3,3,3,'2000-02-01')");
		$this->execute("insert into estado(id, nombre) values (1,'Guardar')");
		$this->execute("insert into estado(id, nombre) values (2,'Suspender')");
		$this->execute("insert into estado(id, nombre) values (3,'Cancelar')");
		$this->execute("insert into proveedor(nit, razon_social) values ('811005806','Imagine SAS')");
		$this->execute("insert into proveedor(nit, razon_social) values ('811123456','Software SAS')");	
		$this->execute("insert into centro_costos (id, codigo, id_jefatura,nombre, activo) values (1,100200,1,'Centro de costos x', 'Si')");
		$this->execute("insert into centro_costos (id, codigo, id_jefatura,nombre, activo) values (2,200300,2,'Centro de costos y', 'Si')");
		$this->execute("insert into centro_costos (id, codigo, id_jefatura,nombre, activo) values (3,300300,2,'Centro de costos z', 'No')");
		$this->execute("insert into cuenta_contable (id, codigo, nombre) values (1,'2222222333333','Cuenta Contable Uno')");
		$this->execute("insert into cuenta_contable (id, codigo, nombre) values (2,'3333333444444','Cuenta Contable Dos')");
		$this->execute("insert into tipo_compra(id, nombre, responsable) values (1,'Tecnologia',6)");
		$this->execute("insert into tipo_compra(id, nombre, responsable) values (2,'Mercadeo',5)");
		$this->execute("insert into tipo_compra(id, nombre, responsable) values (3,'Operaciones',6)");
		$this->execute("insert into tipo_compra(id, nombre, responsable) values (4,'Administrativo',5)");
		$this->execute("insert into producto(nombre) values ('Procesador Xeon 3.0 16GB RAM 1TB')");	
		$this->execute("insert into producto(nombre) values ('Procesador Xeon 3.2 8GB RAM 1.2TB')");
		$this->execute("insert into producto(nombre) values ('Procesador Xeon 3.5 16GB RAM 2TB ')");	

	}

	


}