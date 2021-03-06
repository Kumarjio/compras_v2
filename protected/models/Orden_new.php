<?php

/**
 * This is the model class for table "orden".
 *
 * The followings are the available columns in table 'orden':
 * @property integer $id
 * @property integer $orden
 * @property integer $tipo_compra
 * @property string $nombre_compra
 * @property string $resumen_breve
 * @property integer $id_gerencia
 * @property integer $id_jefatura
 * @property string $fecha_solicitud
 * @property integer $id_gerente
 * @property integer $id_jefe
 * @property integer $id_usuario
 * @property integer $centro_costos
 * @property integer $cuenta_contable
 * @property integer $estado
 * @property string $valor_presupuestado
 * @property string $mes_presupuestado
 * @property string $detalle
 * @property string $fecha_entrega
 * @property string $direccion_entrega
 * @property string $responsable
 * @property integer $requiere_acuerdo_servicios
 * @property integer $requiere_polizas_cumplimiento
 * @property integer $validacion_usuario
 * @property integer $validacion_jefe
 * @property integer $validacion_gerente
 * @property string $paso_wf
 *
 * The followings are the available model relations:
 * @property OrdenProveedor[] $ordenProveedors
 * @property TipoCompra $tipoCompra
 * @property Estado $estado0
 * @property Gerencias $idGerencia
 * @property Jefaturas $idJefatura
 * @property Empleados $idGerente
 * @property Empleados $idJefe
 * @property Empleados $idUsuario
 * @property CentroCostos $centroCostos
 * @property CuentaContable $cuentaContable
 * @property OrdenObservacion[] $ordenObservacions
 */
class Orden extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Orden the static model class
	 */

	public $observacion;
	public $nombre_usuario_search;
    public $paso_actual;
    private $_traz;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orden';
	}

	public function behaviors()
  {
      return array(
          'swBehavior'=>array(
              'class' => 'application.extensions.simpleWorkflow.SWActiveRecordBehavior'
          ),

          'ActiveRecordLogableBehavior'=>array(
              'class' => 'application.components.behavior.ActiveRecordLogableBehavior',
          ),

          'WorkflowTrazabilidad'=>array(
              'class' => 'application.components.behavior.WorkflowTrazabilidad',
          ),

          'WorkflowObservaciones'=>array(
              'class' => 'application.components.behavior.WorkflowObservaciones',
          ),
         
      );
  }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			    
			array('paso_wf', 'SWValidator','enableSwValidation'=>true),
			//Usuario a usuario
			array('tipo_compra, negociacion_directa, nombre_compra','required','on'=>"validarbase"),
			//Usuario a jefe
			array('tipo_compra, negociacion_directa, nombre_compra, resumen_breve, id_gerencia, id_jefatura, id_gerente, id_jefe, ','required','on'=>array('sw:llenaroc_jefe','sw:jefe_gerente')),
			array('validacion_usuario','required','requiredValue'=>1, 'message'=>'Debe certificar que la información ingresada es correcta', 'on'=>array('sw:llenaroc_jefe')),
			array('resumen_breve','verificar_proveedores_legalizacion', 'on' => array('sw:llenaroc_jefe')),
			array('resumen_breve','verificar_costos_usuario', 'on' => array('sw:llenaroc_jefe')),
			array('resumen_breve','verificar_solicitudes', 'on' => array('sw:llenaroc_jefe')),
			array('resumen_breve','verificar_direcciones', 'on' => array('sw:llenaroc_jefe')),
			//Jefe a gerente
			array('tipo_compra, negociacion_directa, nombre_compra, resumen_breve, id_gerencia, id_jefatura, id_gerente, id_jefe, ','required','on'=>array('sw:jefe_gerente')),
			array('validacion_jefe','required','requiredValue'=>1, 'message'=>'Debe certificar que la información ingresada es correcta', 'on'=>array('sw:jefe_gerente')),
			array('resumen_breve','verificar_costos_jefe', 'on' => array('sw:jefe_gerente')),
			array('resumen_breve','verificar_direcciones', 'on' => array('sw:jefe_gerente')),
			array('resumen_breve','verificar_proveedores_legalizacion', 'on' => array('sw:jefe_gerente')),
			//array('cuenta_contable, valor_presupuestado, mes_presupuestado','required','on'=>array('sw:jefe_gerente')),
			//array('valor_presupuestado','numerical','on'=>array('sw:jefe_gerente')),

			//Gerente a compras
			array('tipo_compra, negociacion_directa, nombre_compra, resumen_breve, id_gerencia, id_jefatura, id_gerente, id_jefe, ','required','on'=>array('sw:gerente_analista_compras')),
			array('validacion_gerente','required','requiredValue'=>1, 'message'=>'Debe certificar que la información ingresada es correcta', 'on'=>array('sw:gerente_analista_compras')),
			array('resumen_breve','verificar_costos_jefe', 'on' => array('sw:gerente_analista_compras')),
			array('resumen_breve','verificar_direcciones', 'on' => array('sw:gerente_analista_compras')),
			array('resumen_breve','verificar_proveedores_legalizacion', 'on' => array('sw:gerente_analista_compras')),

			
			//LLenar oc a gerente
			array('tipo_compra, negociacion_directa, nombre_compra, resumen_breve, id_gerencia, id_jefatura, id_gerente, id_jefe, ','required','on'=>array('sw:llenaroc_gerente')),
			array('validacion_usuario','required','requiredValue'=>1, 'message'=>'Debe certificar que la información ingresada es correcta', 'on'=>array('sw:llenaroc_gerente')),
			array('resumen_breve','verificar_costos_jefe', 'on' => array('sw:llenaroc_gerente')),
			array('resumen_breve','verificar_direcciones', 'on' => array('sw:llenaroc_gerente')),
			array('resumen_breve','verificar_proveedores_legalizacion', 'on' => array('sw:llenaroc_gerente')),

			
			//LLenar oc a compras
			array('tipo_compra, negociacion_directa, nombre_compra, resumen_breve, id_gerencia, id_gerente','required','on'=>array('sw:llenaroc_analista_compras')),
			array('validacion_usuario','required','requiredValue'=>1, 'message'=>'Debe certificar que la información ingresada es correcta', 'on'=>array('sw:llenaroc_analista_compras')),
			array('resumen_breve','verificar_costos_jefe', 'on' => array('sw:llenaroc_analista_compras')),
			array('resumen_breve','verificar_direcciones', 'on' => array('sw:llenaroc_analista_compras')),
			array('resumen_breve','verificar_proveedores_legalizacion', 'on' => array('sw:llenaroc_analista_compras')),
			
			
			//Devolucion al usuario
			array('observacion','required', 'on'=>array('sw:jefe_devolucion')),
			array('observacion','required', 'on'=>array('sw:gerente_devolucion')),
			array('observacion','required', 'on'=>array('sw:analista_compras_devolucion')),

            
            //Devolver al paso anterior
            array('observacion','required', 'on'=>array('sw:analista_compras_jefe')),
            array('observacion','required', 'on'=>array('sw:validacion_cotizaciones_en_negociacion')),
            array('observacion','required', 'on'=>array('sw:gerente_compra_validacion_cotizaciones')),
            array('observacion','required', 'on'=>array('sw:aprobar_por_atribuciones_gerente_compra')),

			
			//Suespende y cancelar
			array('observacion','required', 'on'=>array('sw:jefe_suspendida')),
			array('observacion','required', 'on'=>array('sw:jefe_cancelada')),
			array('observacion','required', 'on'=>array('sw:gerente_suspendida')),
			array('observacion','required', 'on'=>array('sw:gerente_cancelada')),
			array('observacion','required', 'on'=>array('sw:analista_compras_cancelada')),
			array('observacion','required', 'on'=>array('sw:analista_compras_suspendida')),
			array('observacion','required', 'on'=>array('sw:suspendida_cancelada')),     

			array('observacion','required', 'on'=>array('solicitar_cancelacion')),

			//Validacion compras a Usuario
			array('observacion','required', 'on'=>array('sw:analista_compras_llenaroc')),
			
			//Gerente compra a Aprobar por atribuciones
			array('observacion', 'existe_elegido_usuario', 'on' => array('sw:gerente_compra_aprobar_por_atribuciones')),
			
			//validacion_cotizaciones a Gerente compra
			array('observacion', 'existe_elegido_usuario', 'on' => array('sw:validacion_cotizaciones_gerente_compra')),
			
			//en_negociacion a validacion_cotizaciones
			array('observacion', 'existe_elegido_compras', 'on' => array('sw:en_negociacion_validacion_cotizaciones')),

			//en_negociacion a suspendido o cancelado
			array('observacion', 'required', 'on' => array('sw:en_negociacion_suspendida')),
			array('observacion', 'required', 'on' => array('sw:en_negociacion_cancelada')),

			//cancaler_post_aprobacion_cancelada
			array('observacion', 'required', 'on' => array('sw:cancaler_post_aprobacion_cancelada')),

			//cancaler_post_aprobacion_usuario
			array('observacion', 'required', 'on' => array('sw:cancaler_post_aprobacion_usuario')),
			
			//en_negociacion_gerente_compra
			array('observacion', 'existe_elegido_compras', 'on' => array('sw:en_negociacion_gerente_compra')),
                        array('observacion','existenProductos', 'on'=>array('sw:en_negociacion_gerente_compra')),
                        array('observacion','tieneCotizaciones', 'on'=>array('sw:en_negociacion_gerente_compra')), 		
	
			//aprobar_por_comite aprobado_por_comite
			array('observacion', 'existe_elegido_comite', 'on' => array('sw:aprobar_por_comite_aprobado_por_comite')),
			
			//aprobar_por_presidencia aprobado_por_presidencia
			array('observacion', 'existe_elegido_comite', 'on' => array('sw:aprobar_por_presidencia_aprobado_por_presidencia')),
            array('observacion', 'existe_elegido_comite', 'on' => array('sw:aprobar_por_junta_aprobado_por_junta')),

			//En negociacion a validar por el usuario
			array('observacion','existenProductos', 'on'=>array('sw:en_negociacion_validacion_cotizaciones')),
			array('observacion','tieneCotizaciones', 'on'=>array('sw:en_negociacion_validacion_cotizaciones')),
			//array('observacion','tieneElegida', 'on'=>array('sw:en_negociacion_validacion_cotizaciones')),
			//array('observacion','tieneElegidaUsuario', 'on'=>array('sw:validacion_cotizaciones_gerente_compra')),
			
			//aprobacion por comité o por presidencia
			
			array('observacion','validar_asistentes', 'on'=>array('sw:aprobar_por_comite_aprobado_por_comite')),
			array('observacion','validar_asistentes', 'on'=>array('sw:aprobar_por_presidencia_aprobado_por_presidencia')),

			array('orden, tipo_compra, id_gerencia, id_jefatura, id_gerente, id_jefe, id_usuario, validacion_usuario, validacion_jefe, validacion_gerente', 'numerical', 'integerOnly'=>true,'on'=>array('sw:llenaroc_jefe')),

			array('nombre_compra, paso_wf', 'length', 'max'=>255),
			array('tipo_compra, nombre_compra, resumen_breve, id_gerencia, id_jefatura, id_gerente, id_jefe, validacion_usuario, validacion_jefe, validacion_gerente, cuenta_contable,valor_presupuestado, observacion, nombre_usuario_search,negociacion_directa,marco', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, orden, tipo_compra, nombre_compra, resumen_breve, id_gerencia, id_jefatura, fecha_solicitud, id_gerente, id_jefe, id_usuario, validacion_usuario, validacion_jefe, validacion_gerente, paso_wf, marco', 'safe', 'on'=>'search'),
			
			//De Suspendido a Jefe
			array('resumen_breve','verificar_direcciones', 'on' => array('sw:suspendida_jefe')),
			
			//De Suspendido a Gerente
			array('resumen_breve','verificar_direcciones', 'on' => array('sw:suspendida_gerente')),
			
			//De Suspendido a Compras
			array('resumen_breve','verificar_direcciones', 'on' => array('sw:suspendida_analista_compras')),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'ordenProveedors' => array(self::HAS_MANY, 'OrdenProveedor', 'id_orden'),
			'tipoCompra' => array(self::BELONGS_TO, 'TipoCompra', 'tipo_compra'),
			'estado0' => array(self::BELONGS_TO, 'Estado', 'estado'),
			'idGerencia' => array(self::BELONGS_TO, 'Gerencias', 'id_gerencia'),
			'idJefatura' => array(self::BELONGS_TO, 'Jefaturas', 'id_jefatura'),
			'idGerente' => array(self::BELONGS_TO, 'Empleados', 'id_gerente'),
			'idJefe' => array(self::BELONGS_TO, 'Empleados', 'id_jefe'),
			'idUsuario' => array(self::BELONGS_TO, 'Empleados', 'id_usuario'),
			'id_usuario' => array(self::BELONGS_TO, 'Empleados', 'id_usuario'),
			'id_usuario_actual' => array(self::BELONGS_TO, 'Empleados', 'usuario_actual'),
			//'centroCostos' => array(self::BELONGS_TO, 'CentroCostos', 'centro_costos'),
			//'cuentaContable' => array(self::BELONGS_TO, 'CuentaContable', 'cuenta_contable'),
			'ordenObservacions' => array(self::HAS_MANY, 'OrdenObservacion', 'id_orden'),
			'observacionesCount'=>array(self::STAT, 'ObservacionesWfs', 'idmodel'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Número de Solicitud',
			'orden' => 'Orden',
			'tipo_compra' => 'Tipo Compra',
			'nombre_compra' => 'Nombre Solicitud de Compra',
			'resumen_breve' => 'Justificacion de la Solicitud',
			'id_gerencia' => 'Gerencia',
			'id_jefatura' => 'Jefatura',
			'fecha_solicitud' => 'Fecha Solicitud',
			'id_gerente' => 'Nombre del Gerente',
			'id_jefe' => 'Nombre del Jefe',
			'id_usuario' => 'Id Usuario',
			'negociacion_directa' => "Tipo de Negociación",
			'validacion_usuario' => 'Certifico que las características y cantidades solicitadas fueron revisadas y son necesarias para el desarrollo de la compañía',
			'validacion_jefe' => 'Certifico que las características y cantidades solicitadas fueron revisadas y son necesarias para el desarrollo de la compañía',
			'validacion_gerente' => 'Certifico que las características y cantidades solicitadas fueron revisadas y son necesarias para el desarrollo de la compañía',
			'paso_wf' => 'Paso Workflow',
			'observacion' => 'Observación',
                        'marco'=>'Solicitud tipo Marco'
		);
	}

	public function tiposNegociacion(){
		return array(
			array('id' => 1, 'nombre' => 'Negociación directa (No negociar)'),
			array('id' => 2, 'nombre' => 'Negociar en compras'),
			array('id' => 3, 'nombre' => 'Legalización')
		);
	}

	public function tipoNegociacionSpan($tipo){
		if($tipo == 1)
			$color = "-warning";
		
		if($tipo == 2)
			return "";
		
		if($tipo == 3)
			$color = "-important";

		if($tipo == ""){
			return "";
		}

		return "<br/><span class='label label".$color."''>".Orden::model()->tiposNegociacionById($tipo)."</span>";
	}

	public function tiposNegociacionById($id){

		$arr = array_filter($this->tiposNegociacion(), function($ar) use($id) {

			return ($ar['id'] == $id);
		   //return ($ar['name'] == 'cat 1' AND $ar['id'] == '3');// you can add multiple conditions
		});


		$arr2 = array_pop($arr);
		return $arr2['nombre'];
	}

	public function existenProductos(){
		$existe = ProductoOrden::model()->findAllByAttributes(
                                                              array('orden' => $this->id, 'producto' => null, 'rechazado' => false)
		);

		if(count($existe) != 0)
			$this->addError("observacion", "Debe elegir el nombre del producto.");
	}

	public function tieneCotizaciones(){
		$existe = ProductoOrden::model()->findAllByAttributes(
                                                              array('orden' => $this->id, 'rechazado' => false)
		);

		$prod = count($existe);

		$coti = Cotizacion::model()->findAll(
			array(
				'select' => 'count(*),producto_orden',
				'condition' => 'producto_orden in (select id from producto_orden where orden = :o and rechazado = false)',
				'params' => array(':o' => $this->id),
				'group' => 'producto_orden'
			)
		);

		$cuantas_cot = count($coti);

		if($prod != $cuantas_cot)
			$this->addError("observacion", "Debe agregar al menos una cotización para cada producto");
	}

	public function tieneElegida(){
		$existe = ProductoOrden::model()->findAllByAttributes(
                                                              array('orden' => $this->id, 'rechazado' => false)
		);

		$prod = count($existe);

		$coti = Cotizacion::model()->findAll(
			array(
				'select' => 'count(*),producto_orden',
				'condition' => 'producto_orden in (select id from producto_orden where orden = :o) and elegido_compras is not null',
				'params' => array(':o' => $this->id),
				'group' => 'producto_orden'
			)
		);

		$cuantas_cot = count($coti);

		if($prod != $cuantas_cot)
			$this->addError("observacion", "Debe elegir un proveedor por cada uno de los productos");
	}
	
	public function tieneElegidaUsuario(){
		$existe = ProductoOrden::model()->findAllByAttributes(
			array('orden' => $this->id, 'rechazado' => false)
		);

		$prod = count($existe);

		$coti = Cotizacion::model()->findAll(
			array(
				'select' => 'count(*),producto_orden',
				'condition' => 'producto_orden in (select id from producto_orden where orden = :o) and elegido_usuario is not null',
				'params' => array(':o' => $this->id),
				'group' => 'producto_orden'
			)
		);

		$cuantas_cot = count($coti);

		if($prod != $cuantas_cot)
			$this->addError("observacion", "Debe elegir un proveedor por cada uno de los productos");
	}
	
	public function verificar_solicitudes(){
		$q = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $this->id, 'cantidad' => null));
		if(count($q) > 0){
			$this->addError("resumen_breve", "Debe verificar que todos los productos tengan la información completa y hayan sido guardados correctamente.");
		}
	}
	
	public function verificar_direcciones(){
		$q = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $this->id));
		if(count($q) > 0){
			foreach($q as $r){
				$dirs = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $r->id));
				$cant = 0;
				if(count($dirs) > 0){
					foreach($dirs as $d){
						$cant += $d->cantidad;
					}
				}
				if($r->cantidad != $cant){
					$this->addError("resumen_breve", "Debe verificar que la cantidad del producto: <strong>'".$r->nombre."'</strong> concuerde con las cantidades de las direcciones ingresadas.");
				}
			}
		}
	}

	public function verificar_proveedores_legalizacion(){

		if($this->negociacion_directa == 1 || $this->negociacion_directa == 3){

			$orden_solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $this->id));

			foreach($orden_solicitudes as $os)
			{
				
				$suma = 0;
				$proveedores = OrdenSolicitudProveedor::model()->findAllByAttributes(array('id_orden_solicitud' => $os->id));
				if(count($proveedores) == 0){
					$this->addError("resumen_breve", "Para negociación directa y legalización, debe ingresar un proveedor para el producto: ".$os->nombre.".");
					break;
				}else{
					foreach($proveedores as $p){
						$suma += $p->total_compra;
					}
				}


			}

			$salario = SalarioMinimo::model()->findByAttributes(array('ano' => date("Y")));
			    
		    if($salario == null){
		       $s_minimo = Yii::app()->params->salario_minimo;
		    }else{
		       $s_minimo = $salario->salario;
		    }

			if($suma > ($s_minimo * Yii::app()->params->salarios_atribuciones)){
				$this->addError("resumen_breve", "El total de la solicitud excede el monto autorizado por atribuciones de gerente");
			}


		}
		

	}
	
	public function verificar_costos_usuario(){
		$orden_solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $this->id));
		if(!(count($orden_solicitudes) > 0)){
			$this->addError("resumen_breve", "Debe agregar al menos una solicitud.");
		}else{
			foreach($orden_solicitudes as $os){
				$porcentaje_o_cantidad = "";
				$porcentaje_o_cantidad_flag = true;
				$suma = 0;
				$costos = OrdenSolicitudCostos::model()->findAllByAttributes(array('id_orden_solicitud' => $os->id));
				if(!(count($costos) > 0)){
					$this->addError("resumen_breve", "Se debe asociar por lo menos un centro de costos y una cuenta contable a cada solicitud.");
					break;
				}else{
					foreach($costos as $c){
						if($porcentaje_o_cantidad == ""){
							$porcentaje_o_cantidad = $c->porcentaje_o_cantidad;
						}else{
							if($porcentaje_o_cantidad != $c->porcentaje_o_cantidad){
								$porcentaje_o_cantidad_flag = false;
							}
						}
						$suma = $suma + $c->numero;
					}
					if($porcentaje_o_cantidad_flag == false){
						$this->addError("resumen_breve", "La distribución debe ser toda en cantidad o toda en porcentaje.");
						break;
					}
					if($porcentaje_o_cantidad == "Porcentaje" and $suma > 100){
						$this->addError("resumen_breve", "La suma de los porcentajes no debe ser mayor que 100.");
						break;
					}
					if($porcentaje_o_cantidad == "Cantidad" and $suma > $os->cantidad){
						$this->addError("resumen_breve", "La suma de las cantidades no debe ser mayor que la cantidad indicada en la solicitud.");
						break;
					}
				}
				$direcciones = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $os->id));
				if(!(count($direcciones) > 0)){
					$this->addError("resumen_breve", "Debe ingresar por lo menos una direccion de envío por producto.");
				}
			}
		}
	}
	
	
	public function verificar_costos_jefe(){
		$orden_solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $this->id));
		if(!(count($orden_solicitudes) > 0)){
			$this->addError("resumen_breve", "Debe agregar al menos un producto.");
		}else{
			foreach($orden_solicitudes as $os){
				$porcentaje_o_cantidad = "";
				$porcentaje_o_cantidad_flag = true;
				$suma = 0;
				$costos = OrdenSolicitudCostos::model()->findAllByAttributes(array('id_orden_solicitud' => $os->id));
				if(!(count($costos) > 0)){
					$this->addError("resumen_breve", "Se debe asociar por lo menos un centro de costos y una cuenta contable al producto ".$os->nombre.".");
					break;
				}else{
					foreach($costos as $c){
						if($porcentaje_o_cantidad == ""){
							$porcentaje_o_cantidad = $c->porcentaje_o_cantidad;
						}else{
							if($porcentaje_o_cantidad != $c->porcentaje_o_cantidad){
								$porcentaje_o_cantidad_flag = false;
							}
						}
						$suma = $suma + $c->numero;
					}
					if($porcentaje_o_cantidad_flag == false){
						$this->addError("resumen_breve", "La distribución de los centros de costo del producto ".$os->nombre." debe ser toda en cantidad o toda en porcentaje.");
						break;
					}
					if($porcentaje_o_cantidad == "Porcentaje" and $suma != 100){
						$this->addError("resumen_breve", "La suma de los porcentajes de los centros de costo del producto ".$os->nombre." debe ser igual a 100.");
						break;
					}
					if($porcentaje_o_cantidad == "Cantidad" and $suma != $os->cantidad){
						$this->addError("resumen_breve", "La suma de las cantidades de los centros de costo del producto ".$os->nombre." debe ser igual a la cantidad indicada en el producto.");
						break;
					}
				}
				$direcciones = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $os->id));
				if(!(count($direcciones) > 0)){
					$this->addError("resumen_breve", "Debe ingresar por lo menos una direccion de envío en el producto ".$os->nombre.".");
				}
			}
		}
	}
	
	public function verificar_atribuciones(){
    
		$empleado = Empleados::model()->findByPk(Yii::app()->user->id_empleado);
		$orden = $this;
		$ok = true;
		$costo_total = 0;

        //if($orden->tipo_compra == Yii::app()->params->compra_software)
        //  return false;

		if($empleado == null or $orden == null){
			return false;
		}else{
			$atribucion = Atribucion::model()->findByAttributes(array('id_empleado' => $empleado->id));
            
			if($atribucion == null){
				return false;
			}else{
				$productos = ProductoOrden::model()->findAllByAttributes(array('orden' => $orden->id));
				if(count($productos) <= 0){
					return false;
				}else{
					$pks = array();
					foreach($productos as $p){
						$pks[] = $p['id'];
					}
					$pks_producto_orden = implode(",", $pks);
					$cotizaciones = Cotizacion::model()->findAll(array(
					    'condition'=>'t.producto_orden in ('.$pks_producto_orden.')'
					));
					if(count($cotizaciones) <= 0){
						return false;
          }else{
            
						foreach($cotizaciones as $c){
							if($c->elegido_usuario == 1){
								$costo_total = $costo_total + $c->total_compra_pesos;
							}
							if($c->elegido_compras != $c->elegido_usuario){
								$ok = false;
							}
						}
                         
						if($costo_total <= 11000000 and $ok){
							return true;
						}else{
              if($costo_total <= 1277000){
                
								return true;
							}else{
								return false;
							}
						}
					}
				}
			}
		}
	}
	
	public static function elecciones($compras, $comite, $usuario, $cotizacion){
		$resp = '';
		if($compras == 1){
			$resp = $resp."<span class=\"label label-warning eleccion\">".ProductoOrden::model()->get_descripcion($cotizacion->razon_eleccion_compras, $cotizacion->id, "Compras")."</span>";
		}
		if($comite == 1){
			if($resp == ''){
				$resp = $resp."<span class=\"label label-success eleccion\">".ProductoOrden::model()->get_descripcion($cotizacion->razon_eleccion_comite, $cotizacion->id, "Comite")."</span>";
			}else{
				$resp = $resp."<br/><br/><span class=\"label label-success eleccion\">".ProductoOrden::model()->get_descripcion($cotizacion->razon_eleccion_comite, $cotizacion->id, "Comite")."</span>";
			}
		}
		if($usuario == 1){
			if($resp == ''){
				$resp = $resp."<span class=\"label label-info eleccion\">".ProductoOrden::model()->get_descripcion($cotizacion->razon_eleccion_usuario, $cotizacion->id, "Usuario")."</span>";
			}else{
				$resp = $resp."<br/><br/><span class=\"label label-info eleccion\">".ProductoOrden::model()->get_descripcion($cotizacion->razon_eleccion_usuario, $cotizacion->id, "Usuario")."</span>";
			}
		}
		if($cotizacion->productoOrden->orden0->paso_wf == 'swOrden/aprobado_por_atribuciones'){
			if($resp == ''){
				$resp = $resp."<span class=\"label label-important eleccion\"><a>Atribuciones</a></span>";
			}else{
				$resp = $resp."<br/><br/><span class=\"label label-important eleccion\"><a>Atribuciones</a></span>";
			}
		}
		return $resp;
	}
	
	public static function iconoUsuarioVisible($id){
		$o = Orden::model()->findByPk($id);
		if($o != null and $o->paso_wf == 'swOrden/en_negociacion'){
			return true;
		}else{
			return false;
		}
	}
	
	public function verificar_comite($comite){
      $salario = SalarioMinimo::model()->findByAttributes(array('ano' => date("Y")));
      if($salario == null){
        $s_minimo = Yii::app()->params->salario_minimo;
      }else{
        $s_minimo = $salario->salario;
      }

		$orden = $this;
		$ok = true;
		$costo_total = 0;
		$costo_total_usuario = 0;
		$costo_total_compras = 0;
		if($orden == null){
			return false;
		}else{

			$productos = ProductoOrden::model()->findAllByAttributes(array('orden' => $orden->id));
			if(count($productos) <= 0){
				return false;
			}else{
				$pks = array();
				foreach($productos as $p){
					$pks[] = $p['id'];
				}
				$pks_producto_orden = implode(",", $pks);
				$cotizaciones = Cotizacion::model()->findAll(array(
				    'condition'=>'t.producto_orden in ('.$pks_producto_orden.')'
				));
				if(count($cotizaciones) <= 0){
					return false;
				}else{
					foreach($cotizaciones as $c){
						if($c->elegido_compras == 1){
							$costo_total_compras += $c->total_compra_pesos;
						}
						if($c->elegido_usuario == 1){
							$costo_total_usuario +=$c->total_compra_pesos;
						}
						if($c->elegido_compras != $c->elegido_usuario){
							$ok = false;
						}
					}
					if($costo_total_usuario <= $costo_total_compras){
						$costo_total = $costo_total_compras;
					}else{
						$costo_total = $costo_total_usuario;
					}
					if($costo_total <= $s_minimo && ($orden->tipo_compra != Yii::app()->params->compra_software)){
						return false;
					}else{

						
								
						if( ($costo_total > $s_minimo * 100) && $this->algunoNoPresupuestado()){

							if($comite == "Junta"){
							  return true;
							}else if($comite == "Compras"){
								return true;
							}else {
							 	return false;
							}
						}
						else if($costo_total >= ($s_minimo * 135)){//($s_minimo * 100)
							if($comite == "Presidencia"){
								return true;
							}else if($comite == "Compras"){
								return true;
							}else {
							 	return false;
							}
						}else{
							if($comite == "Compras"){
								return true;
							}else if($comite == "ap_x_comite"){
							   return true;
							}else {
							 	return false;
							}
						}
					}
				}
			}
			
		}
	}

    public function algunoNoPresupuestado(){
      $os = OrdenSolicitud::model()->with('ordenSolicitudCostoses')->findByAttributes(array('id_orden' => $this->id));
      $costos = $os->ordenSolicitudCostoses;

      foreach($costos as $c){
        if($c->presupuestado != 'Presupuestado'){
          return true; 
        }
      }
    }
    
	
	public function validar_asistentes(){
		$q = AsistenteComite::model()->findAllByAttributes(array('id_orden' => $this->id));
		if(!count($q) > 0){
			$this->addError("observacion", "Debe seleccionar por lo menos un asistente.");
		}
	}
	
	public function verificar_usuario_gerente($id_usuario){
		$contratos = Contratos::model()->findAllByAttributes(array('id_empleado' => $id_usuario), array('order' => 'fecha_inicio DESC', 'limit' => '1'));
		if(count($contratos) > 0){
			$cont = $contratos[0];
			if($cont->fecha_fin == null or $cont->fecha_fin >= date('Y-m-d')){
				$cargo = Cargos::model()->findByPk($cont->id_cargo);
				if($cargo->es_gerente == "Si"){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search_asignadas()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array( 'id_usuario' );
		
		$criteria->condition = "usuario_actual = :u and paso_wf != :paso";

		$criteria->params = array(':u' => Yii::app()->user->getState('id_empleado'),
								  ':paso' => "swOrden/finalizada");

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipo_compra',$this->tipo_compra);
		$criteria->compare('LOWER(t.nombre_compra)',strtolower($this->nombre_compra),true);
		$criteria->compare('t.resumen_breve',$this->resumen_breve,true);
		$criteria->compare('t.id_gerencia',$this->id_gerencia);
		$criteria->compare('t.id_jefatura',$this->id_jefatura);
		$criteria->compare('t.fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('t.id_gerente',$this->id_gerente);
		$criteria->compare('t.id_jefe',$this->id_jefe);
		$criteria->compare('t.id_usuario',$this->id_usuario);
		$criteria->compare('LOWER(id_usuario.nombre_completo)',strtolower($this->nombre_usuario_search),true);
		$criteria->compare('t.validacion_usuario',$this->validacion_usuario);
		$criteria->compare('t.validacion_jefe',$this->validacion_jefe);
		$criteria->compare('t.validacion_gerente',$this->validacion_gerente);

		if(Yii::app()->user->getState("comite_compras")){
			$criteria->addCondition("t.paso_wf != 'swOrden/aprobar_por_comite'");
		}

		$criteria->compare('t.paso_wf',$this->paso_wf,true);
		

		if(!isset($_GET['Orden_sort']))
		  $criteria->order = "t.id desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
						'nombre_usuario_search'=>array(
			                'asc'=>'id_usuario.nombre_completo',
			                'desc'=>'id_usuario.nombre_completo DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}


	public function search_todas()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array( 'id_usuario' );

        $criteria->condition = "t.id < 500000000";
		
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipo_compra',$this->tipo_compra);
		$criteria->compare('LOWER(t.nombre_compra)',strtolower($this->nombre_compra),true);
		$criteria->compare('t.resumen_breve',$this->resumen_breve,true);
		$criteria->compare('t.id_gerencia',$this->id_gerencia);
		$criteria->compare('t.id_jefatura',$this->id_jefatura);
		$criteria->compare('t.fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('t.id_gerente',$this->id_gerente);
		$criteria->compare('t.id_jefe',$this->id_jefe);
		$criteria->compare('t.id_usuario',$this->id_usuario);
		$criteria->compare('LOWER(id_usuario.nombre_completo)',strtolower($this->nombre_usuario_search),true);
		$criteria->compare('t.validacion_usuario',$this->validacion_usuario);
		$criteria->compare('t.validacion_jefe',$this->validacion_jefe);
		$criteria->compare('t.validacion_gerente',$this->validacion_gerente);
		$criteria->compare('t.paso_wf',$this->paso_wf,true);
		

		if(!isset($_GET['Orden_sort']))
		  $criteria->order = "t.id desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>100),
			'sort'=>array(
			        'attributes'=>array(
						'nombre_usuario_search'=>array(
			                'asc'=>'id_usuario.nombre_completo',
			                'desc'=>'id_usuario.nombre_completo DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

	public function search_todas_area()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array( 'id_usuario' );

        $criteria->condition = "t.id < 500000000";
		$res = Gerencias::model()->jefaturaYGerencia();
//print_r($res);die;
		if(count($res) != 0){
		  $id_gerencia = $res[0]['id_gerencia'];

		  //Caso en el que el jefe es igual al gerente. (Analistas sin jefe, solo con gerente)
          $jefe_gerente = Orden::model()->getJefeJefatura(Yii::app()->user->getState("id_empleado"));
		  if(count($jefe_gerente) > 0){
		      $id_jefatura = $jefe_gerente[0]['id_jefatura'];
		  }else{
		  	  $id_jefatura = $res[0]['id_jefatura'];
		  }
		  
		}
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipo_compra',$this->tipo_compra);
		$criteria->compare('LOWER(t.nombre_compra)',strtolower($this->nombre_compra),true);
		$criteria->compare('t.resumen_breve',$this->resumen_breve,true);
		$criteria->compare('t.id_gerencia',$id_gerencia);
		$criteria->compare('t.id_jefatura',$id_jefatura);
		$criteria->compare('t.fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('t.id_gerente',$this->id_gerente);
		$criteria->compare('t.id_jefe',$this->id_jefe);
		$criteria->compare('t.id_usuario',$this->id_usuario);
		$criteria->compare('LOWER(id_usuario.nombre_completo)',strtolower($this->nombre_usuario_search),true);
		$criteria->compare('t.validacion_usuario',$this->validacion_usuario);
		$criteria->compare('t.validacion_jefe',$this->validacion_jefe);
		$criteria->compare('t.validacion_gerente',$this->validacion_gerente);
		$criteria->compare('t.paso_wf',$this->paso_wf,true);
		

		if(!isset($_GET['Orden_sort']))
		  $criteria->order = "t.id desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>100),
			'sort'=>array(
			        'attributes'=>array(
						'nombre_usuario_search'=>array(
			                'asc'=>'id_usuario.nombre_completo',
			                'desc'=>'id_usuario.nombre_completo DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}


	public function search_solicitadas()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array( 'id_usuario_actual' );
		$criteria->condition = "id_usuario = :u and t.id < 500000000 and paso_wf != :paso";
		$criteria->params = array(':u' => Yii::app()->user->getState('id_empleado'),
								  ':paso' => "swOrden/finalizada");

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipo_compra',$this->tipo_compra);
		$criteria->compare('LOWER(t.nombre_compra)',strtolower($this->nombre_compra),true);
		$criteria->compare('t.resumen_breve',$this->resumen_breve,true);
		$criteria->compare('t.id_gerencia',$this->id_gerencia);
		$criteria->compare('t.id_jefatura',$this->id_jefatura);
		$criteria->compare('t.fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('t.id_gerente',$this->id_gerente);
		$criteria->compare('t.id_jefe',$this->id_jefe);
		$criteria->compare('t.id_usuario',$this->id_usuario);
		$criteria->compare('LOWER(id_usuario_actual.nombre_completo)',strtolower($this->nombre_usuario_search),true);
		$criteria->compare('t.validacion_usuario',$this->validacion_usuario);
		$criteria->compare('t.validacion_jefe',$this->validacion_jefe);
		$criteria->compare('t.validacion_gerente',$this->validacion_gerente);
		$criteria->compare('t.paso_wf',$this->paso_wf, true);
		
		if(!isset($_GET['Orden_sort']))
		  $criteria->order = "t.id desc";


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
						'nombre_usuario_search'=>array(
			                'asc'=>'id_usuario_actual.nombre_completo',
			                'desc'=>'id_usuario_actual.nombre_completo DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}
	
	public function search_anteriores()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array( 'id_usuario' );
		
		$criteria->addCondition("t.id IN (select t.idmodel from trazabiliadwfs t where model='Orden' and usuario_anterior = :u)");
		$criteria->params = array(':u' => Yii::app()->user->getState('id_empleado'));
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipo_compra',$this->tipo_compra);
		$criteria->compare('LOWER(t.nombre_compra)',strtolower($this->nombre_compra),true);
		$criteria->compare('t.resumen_breve',$this->resumen_breve,true);
		$criteria->compare('t.id_gerencia',$this->id_gerencia);
		$criteria->compare('t.id_jefatura',$this->id_jefatura);
		$criteria->compare('t.fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('t.id_gerente',$this->id_gerente);
		$criteria->compare('t.id_jefe',$this->id_jefe);
		$criteria->compare('t.id_usuario',$this->id_usuario);
		$criteria->compare('LOWER(id_usuario.nombre_completo)',strtolower($this->nombre_usuario_search),true);
		$criteria->compare('t.validacion_usuario',$this->validacion_usuario);
		$criteria->compare('t.validacion_jefe',$this->validacion_jefe);
		$criteria->compare('t.validacion_gerente',$this->validacion_gerente);
		$criteria->compare('t.paso_wf',$this->paso_wf,true);
		

		if(!isset($_GET['Orden_sort']))
		  $criteria->order = "t.id desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
						'nombre_usuario_search'=>array(
			                'asc'=>'id_usuario.nombre_completo',
			                'desc'=>'id_usuario.nombre_completo DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

	public function search_finalizadas()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array( 'id_usuario' );
		
		$criteria->condition = "usuario_actual = :u and paso_wf = :paso";
		$criteria->params = array(':u' => Yii::app()->user->getState('id_empleado'), ':paso' => "swOrden/finalizada");
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipo_compra',$this->tipo_compra);
		$criteria->compare('LOWER(t.nombre_compra)',strtolower($this->nombre_compra),true);
		$criteria->compare('t.resumen_breve',$this->resumen_breve,true);
		$criteria->compare('t.id_gerencia',$this->id_gerencia);
		$criteria->compare('t.id_jefatura',$this->id_jefatura);
		$criteria->compare('t.fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('t.id_gerente',$this->id_gerente);
		$criteria->compare('t.id_jefe',$this->id_jefe);
		$criteria->compare('t.id_usuario',$this->id_usuario);
		$criteria->compare('LOWER(id_usuario.nombre_completo)',strtolower($this->nombre_usuario_search),true);
		$criteria->compare('t.validacion_usuario',$this->validacion_usuario);
		$criteria->compare('t.validacion_jefe',$this->validacion_jefe);
		$criteria->compare('t.validacion_gerente',$this->validacion_gerente);
		$criteria->compare('t.paso_wf',$this->paso_wf,true);
		

		if(!isset($_GET['Orden_sort']))
		  $criteria->order = "t.id desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
						'nombre_usuario_search'=>array(
			                'asc'=>'id_usuario.nombre_completo',
			                'desc'=>'id_usuario.nombre_completo DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

    public function search_aprobadas()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipo_compra',$this->tipo_compra);
		$criteria->compare('LOWER(t.nombre_compra)',strtolower($this->nombre_compra),true);
		$criteria->compare('t.resumen_breve',$this->resumen_breve,true);
		$criteria->compare('t.id_gerencia',$this->id_gerencia);
		$criteria->compare('t.id_jefatura',$this->id_jefatura);
		$criteria->compare('t.fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('t.id_gerente',$this->id_gerente);
		$criteria->compare('t.id_jefe',$this->id_jefe);
		$criteria->compare('t.id_usuario',$this->id_usuario);
		$criteria->compare('LOWER(id_usuario.nombre_completo)',strtolower($this->nombre_usuario_search),true);
		$criteria->compare('t.validacion_usuario',$this->validacion_usuario);
		$criteria->compare('t.validacion_jefe',$this->validacion_jefe);
		$criteria->compare('t.validacion_gerente',$this->validacion_gerente);
		$criteria->compare('t.paso_wf','swOrden/usuario');
		

		if(!isset($_GET['Orden_sort']))
		  $criteria->order = "t.id desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
						'nombre_usuario_search'=>array(
			                'asc'=>'id_usuario.nombre_completo',
			                'desc'=>'id_usuario.nombre_completo DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

	public function search_en_comite()
	{

		$criteria=new CDbCriteria;
		
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.orden',$this->orden);
		$criteria->compare('t.tipo_compra',$this->tipo_compra);
		$criteria->compare('LOWER(t.nombre_compra)',strtolower($this->nombre_compra),true);
		$criteria->compare('t.resumen_breve',$this->resumen_breve,true);
		$criteria->compare('t.id_gerencia',$this->id_gerencia);
		$criteria->compare('t.id_jefatura',$this->id_jefatura);
		$criteria->compare('t.fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('t.id_gerente',$this->id_gerente);
		$criteria->compare('t.id_jefe',$this->id_jefe);
		$criteria->compare('t.id_usuario',$this->id_usuario);
		$criteria->compare('LOWER(id_usuario.nombre_completo)',strtolower($this->nombre_usuario_search),true);
		$criteria->compare('t.validacion_usuario',$this->validacion_usuario);
		$criteria->compare('t.validacion_jefe',$this->validacion_jefe);
		$criteria->compare('t.validacion_gerente',$this->validacion_gerente);
		$criteria->compare('t.paso_wf','swOrden/aprobar_por_comite');
		

		if(!isset($_GET['Orden_sort']))
		  $criteria->order = "t.id asc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
						'nombre_usuario_search'=>array(
			                'asc'=>'id_usuario.nombre_completo',
			                'desc'=>'id_usuario.nombre_completo DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

	public function meses(){
		return array(
			array('id' => 'Enero', 'mes' => 'Enero' ),
			array('id' => 'Febrero', 'mes' => 'Febrero' ),
			array('id' => 'Marzo', 'mes' => 'Marzo' ),
			array('id' => 'Abril', 'mes' => 'Abril' ),
			array('id' => 'Mayo', 'mes' => 'Mayo' ),
			array('id' => 'Junio', 'mes' => 'Junio' ),
			array('id' => 'Julio', 'mes' => 'Julio' ),
			array('id' => 'Agosto', 'mes' => 'Agosto' ),
			array('id' => 'Septiembre', 'mes' => 'Septiembre' ),
			array('id' => 'Octubre', 'mes' => 'Octubre' ),
			array('id' => 'Noviembre', 'mes' => 'Noviembre' ),
			array('id' => 'Diciembre', 'mes' => 'Diciembre' )
		);
	}

	public function reanudar(){

		$traz = TrazabilidadWfs::model()->find(
				array(
					'condition' => "model = :m and idmodel = :id",
					'params' => array(':m' => 'Orden', ':id' => $this->id),
					'order' => "fecha desc",
					'limit' => 1
				)
			);


		if($traz != null){
			$query = "update orden set paso_wf = :paso, usuario_actual = :usuario where id = :orden";
			$res =  $this->dbConnection->createCommand($query)
					->bindValue(":paso", $traz->estado_anterior)
					->bindValue(":usuario", $traz->usuario_anterior)
					->bindValue(":orden", $this->id)
					->execute();
			if($res){
				$t = new TrazabilidadWfs;
				$t->model = $traz->model;
				$t->idmodel = $traz->idmodel;
				$t->estado_anterior = $traz->estado_nuevo;
				$t->estado_nuevo = $traz->estado_anterior;
				$t->usuario_nuevo = $traz->usuario_anterior;
				$t->usuario_anterior = $traz->usuario_nuevo;
				$t->save();

				return $res;
			}
		}

		return 0;

	}

	public function limpiarElecciones(){
		$q = "
			update 
			cotizacion set 
			elegido_compras = null, 
			elegido_usuario = null, 
			elegido_comite = null, 
			razon_eleccion_usuario = null,
			razon_eleccion_compras = null,
			razon_eleccion_comite = null,
			enviar_a_usuario = null,
			enviar_cotizacion_a_usuario = null
			where producto_orden in (select id from producto_orden where orden = :orden)";
			$res =  $this->dbConnection->createCommand($q)
				->bindValue(":orden", $this->id)
				->execute();
	}

	public function editarSuspendida(){

		$query = "update orden set paso_wf = :paso, usuario_actual = :usuario where id = :orden";
		$res =  $this->dbConnection->createCommand($query)
				->bindValue(":paso", "swOrden/llenaroc")
				->bindValue(":usuario", Yii::app()->user->id_empleado)
				->bindValue(":orden", $this->id)
				->execute();
		
		if($res){

			$this->limpiarElecciones();

			$t = new TrazabilidadWfs;
			$t->model = "Orden";
			$t->idmodel = $this->id;
			$t->estado_anterior = "swOrden/suspendida";
			$t->estado_nuevo = "swOrden/llenaroc";
			$t->usuario_nuevo = Yii::app()->user->id_empleado;
			$t->usuario_anterior = Yii::app()->user->id_empleado;
			$t->save();

			return $res;
		}
		

		return 0;

	}


	public function labalEstado($id_estado){
		$estados = SWHelper::allStatuslistData($this);
		return $estados[$id_estado];
	}
	
	protected function beforeSave(){
      $orden = $this->findByPk($this->id);
      $this->paso_actual = $orden->paso_wf;
		if($this->scenario != 'delegar'){
			switch ($this->paso_wf) {
				case 'swOrden/llenaroc':
					$this->asignarAUsuario();
					break;
				case 'swOrden/devolucion':
					$this->asignarAUsuario();
					$this->limpiarElecciones();
					break;
				case 'swOrden/jefe':
					$this->asignarAJefe();
					break;
               case 'swOrden/jefe_ventas_alkosto':
                    $this->asignarAJefeVentasAlkosto();
                    break;
				case 'swOrden/gerente':
					$this->asignarAGerente();
					break;
				case 'swOrden/cancelada':
					$this->asignarNulo();
					$this->descongelarOrden();
					break;
				case 'swOrden/suspendida':
					$this->asignarAUsuario();
					break;
				case 'swOrden/analista_compras':
					$this->asignarAnalistaCompras();
					break;
				case 'swOrden/en_negociacion':
                    $this->asignarAnalistaCompras();
					$this->crearProductos();
					break;
				case 'swOrden/validacion_cotizaciones':
				    if($this->tieneJefeGerente()){
				    	$this->paso_wf = "swOrden/gerente_compra";
				    	$this->asignarAGerente();
				    }else{
                        $this->asignarAJefe();
                    } 
					break;
				case 'swOrden/gerente_compra':
					$this->asignarAGerente();
					break;
				case 'swOrden/aprobar_por_comite':
					$this->asignarAComiteCompras();
					//$this->crearAsistentesCompras();
                    //$this->crearAsistentesUltimoComite('Compras');
					break;
				case 'swOrden/aprobar_por_presidencia':
					$this->asignarAPresidencia();
					//$this->crearAsistentesPresidencia();
                    //$this->crearAsistentesUltimoComite('Presidencia');
					break;
                case 'swOrden/aprobar_por_junta':
					$this->asignarAJunta();
					break;
				case 'swOrden/aprobado_por_comite':
					$this->asignarAnalistaCompras();
					$this->asignarOrdenesParaCancelar();
					$this->calcularAhorro();
					$this->guardarAsistentes('Compras');
					break;
				case 'swOrden/aprobado_por_presidencia':
					$this->asignarAnalistaCompras();
					$this->asignarOrdenesParaCancelar();
					$this->calcularAhorro();
					$this->guardarAsistentes('Presidencia');
					break;
                case 'swOrden/aprobado_por_junta':
                    $this->asignarAnalistaCompras();
					break;
				case 'swOrden/aprobar_por_atribuciones':
					$this->asignarAJefeCompras();
					$this->sumarAtribuciones();
					break;
				case 'swOrden/aprobado_por_atribuciones':
					$this->marcarAprobacion();
					$this->asignarAnalistaCompras();
					$this->asignarOrdenesParaCancelar();
					$this->calcularAhorro();
					break;
				case 'swOrden/usuario':
					$this->asignarAUsuario();
					$this->descongelarOrden();
					break;

				default:
					break;
			}
            $this->verificarReemplazo();
		}
		
		if(($this->paso_wf != "swOrden/llenaroc" && $this->paso_wf != "swOrden/dummy") && $this->id > 500000000){
		  //$this->_updateId();
		}

		return true;
	}

    public function verificarReemplazo(){
      $e = Empleados::model()->findByPk($this->usuario_actual);
      if($e->reemplazo != ""){
      	$this->id_usuario_reemplazado = $this->usuario_actual;
        $this->usuario_actual = $e->reemplazo;
      }
    }

    public function urlPaso(){
      $url = "";
      $parametro = "";
      switch($this->paso_wf){
      case "swOrden/en_negociacion":
        $url = "/productoOrden/create";
        $parametro = "orden";
        break;
      case "swOrden/validacion_cotizaciones":
        $url = "/productoOrden/create";
        $parametro = "orden";
        break;
      case "swOrden/cancaler_post_aprobacion":
        $url = "/productoOrden/create";
        $parametro = "orden";
        break;
      case "swOrden/gerente_compra":
        $url = "/productoOrden/create";
        $parametro = "orden";
        break;
      case "swOrden/aprobar_por_comite":
        $url = "/productoOrden/create";
        $parametro = "orden";
        break;
      case "swOrden/aprobar_por_presidencia":
        $url = "/productoOrden/create";
        $parametro = "orden";
        break;
      case "swOrden/aprobar_por_junta":
        $url = "/productoOrden/create";
        $parametro = "orden";
        break;
      case "swOrden/aprobar_por_atribuciones":
        $url = "/productoOrden/create";
        $parametro = "orden";
        break;
      case "swOrden/aprobado_por_atribuciones":
        $url = "/orden/vincular";
        $parametro = "id";
        break;
      case "swOrden/aprobado_por_comite":
        $url = "/orden/vincular";
        $parametro = "id";
        break;
      case "swOrden/aprobado_por_presidencia":
        $url = "/orden/vincular";
        $parametro = "id";
        break;
      case "swOrden/aprobado_por_junta":
        $url = "/orden/vincular";
        $parametro = "id";
        break;
      case "swOrden/usuario":
        $url = "/orden/realizarPedido";
        $parametro = "id";
        break;
      case "swOrden/suspendida":
        $url = "/orden/suspendida";
        $parametro = "orden";
        break;
      default:
        $url = "/orden/update";
        $parametro = "id";
        break;			
      }

      return array($url,$parametro);
                        
    }

    public function proximoPaso($id_paso){
      $estados = SWHelper::allStatuslistData($this);
      $proximo = $estados[$id_paso];
      return $proximo;
    }

    public function generarHash(){
      $hash = HashesAprobacion::model()->findByAttributes(array('id_orden' => $this->id));
      if($hash == null){
        $hash = new HashesAprobacion;
        $hash->id_orden = $this->id;
      }
      $hash->save();
      return $hash->hash;
    }

    public function getHash(){
      $hash = HashesAprobacion::model()->findByAttributes(array('id_orden' => $this->id));
      return $hash->hash;
    }

    public function urlMail($id = false){
      list($url, $parametro) = $this->urlPaso();
      if($id){
      	$urlFin = "http://".$_SERVER['HTTP_HOST']."/index.php".$url."/".$parametro."/".$id;
      }else{
      	$urlFin = "http://".$_SERVER['HTTP_HOST']."/index.php".$url."/".$parametro."/".$this->id;
      }
      return $urlFin;
    }

    public function getActionLinks(){
      Yii::app()->user->setState('desde_correo',true);
      $next_steps = SWHelper::nextStatuslistData($this);
      $link = '';
      $first = true;
      foreach($next_steps as $step => $label){
        if($step == $this->paso_wf or $label == "Guardar sin enviar" or in_array($step,array('swOrden/devolucion', 'swOrden/cancelada', 'swOrden/suspendida'))){
          // No Hacer Nada
        }else{
          /* No se puede ejecutar acción desde el correo
			 porque al suspender se puede o reanudar o editar.
			 Es mejor que el usuario escoja desde el PC.
          */
          if($this->paso_wf != "swOrden/suspendida"){
          	if($first){
				$first = false;
			}else{
				$link .= '  |  ';
			}
			$link .= CHtml::link($label, Yii::app()->controller->createAbsoluteUrl('orden/aprobarOrden',array('id'=>$this->id, 'key' => $this->getHash(), 'step' => $step)));
          }
          
        }
      }
      Yii::app()->user->setState('desde_correo',false);
      return $link;
    }
                    
    protected function sendEmail($id){
      $estados = SWHelper::allStatuslistData($this);
      $proximo = $this->proximoPaso($this->paso_wf);
      $empleado = Empleados::model()->findByPk($this->usuario_actual);
      $email = $empleado->email;
      
      $urlFin = $this->urlMail();

      if($email != ""){
        if(($this->paso_actual == "swOrden/analista_compras") && $this->paso_wf == "swOrden/en_negociacion"){

        }else{
          $html = Yii::app()->controller->renderPartial("/orden/emailview", array('orden'=>$this),true);
          Yii::app()->mailer->compraAsignada($email, $this->nombre_compra, $proximo, $id, $urlFin, $html);
          if($this->paso_actual == "swOrden/usuario"){
            $jefe = Empleados::model()->findByPk($this->id_jefe);
            $email_jefe = $jefe->email;
            if($email_jefe != ""){
              Yii::app()->mailer->compraAsignada($email_jefe, $this->nombre_compra, $proximo, $id, $urlFin, $html);
            }
          }
        }
      }
      
    }

    protected function sendEmailEspecial($id,$paso,$empleado){

      $proximo = $this->proximoPaso($paso);
      $orden = $this->findByPk($id);
      $empleado = Empleados::model()->findByPk($empleado);
      $email = $empleado->email;
      
      $urlFin = $this->urlMail($id);

      if($email != ""){
          $html = Yii::app()->controller->renderPartial("/orden/emailview", array('orden'=>$orden),true);
          Yii::app()->mailer->compraAsignada($email, $orden->nombre_compra, $proximo, $id, $urlFin, $html);        
      }
      
    }

    public function descongelarOrden(){
    	$r = OrdenReemplazos::model()->findByAttributes(array("orden_vieja" => $this->id));
    	if($r !== NULL){
    		$r->congelar = 0;
    		$r->save();
    	}
    }

	protected function afterSave(){
	  parent::afterSave();

      $this->generarHash();

      $id = null;

	  if(($this->paso_wf != "swOrden/llenaroc" && $this->paso_wf != "") && $this->id > 500000000){
	    $id = $this->_updateId();
	  }
      
      $this->enviarEmail();
      
	  	if($this->scenario != 'delegar'){
			switch ($this->paso_wf) {
				case 'swOrden/aprobado_por_comite':
					$this->createVinculacionProveedorAdministrativoYJuridico();
					break;
				case 'swOrden/aprobado_por_presidencia':
					$this->createVinculacionProveedorAdministrativoYJuridico();	
					break;
				case 'swOrden/aprobado_por_junta':
					$this->createVinculacionProveedorAdministrativoYJuridico();	
					break;
				case 'swOrden/aprobado_por_atribuciones':
					$this->createVinculacionProveedorAdministrativoYJuridico();
					break;
				default:
					break;
			}
		}
		return true;

	}

	public function enviarEmail(){
            if(($this->paso_wf != "swOrden/llenaroc" && $this->paso_wf != "" && $this->paso_actual != $this->paso_wf)){
                if($this->paso_wf != "swOrden/finalizada"){
                    $this->sendEmail($id == null ? $this->id : $id);	
	        }
	    }
	}
	
	public function guardarAsistentes($comite){
		$asistentes = AsistenteComite::model()->findAllByAttributes(array('id_orden' => $this->id));
		if(count($asistentes) > 0){
			$f = date("Y-m-d H:i:s");
			foreach($asistentes as $a){
				$a->tipo_comite = $comite;
				$a->fecha_comite = $f;
				$a->save();
			}
		}
	}
	
	public function crearAsistentesUltimoComite($comite){
		AsistenteComite::model()->deleteAllByAttributes(array('id_orden' => $this->id));
		
		$q1 = AsistenteComite::model()->findAll(array(
		    'condition'=>"t.tipo_comite='".$comite."' and t.fecha_comite is not null",
		    'order'=>'t.fecha_comite desc',
		));
		$f = null;
		if(count($q1) > 0){
			$f = $q1[0]['fecha_comite'];
		}
		if($f != null){
			$q = AsistenteComite::model()->findAll(array(
			    'condition'=>"t.tipo_comite='".$comite."' and t.fecha_comite='".$f."'",
			));
			if(count($q) > 0){
				foreach($q as $e){
					$a = new AsistenteComite;
					$a->id_orden = $this->id;
					$a->id_empleado = $e->id_empleado;
					$a->save();
				}
			}
		}
		
	}

    public function crearAsistentesHabitualesComite($comite){
      AsistenteComite::model()->deleteAllByAttributes(array('id_orden' => $this->id));
      switch($comite){
        case 'Compras':
          $this->crearAsistentesCompras();
          break;
        case 'Presidencia':
          $this->crearAsistentesPresidencia();
          break;
        default:
          break;
      }
    }

    public function getLastDate(){
      $tr = TrazabilidadWfs::model()->findByAttributes(array('model' => 'Orden', 'idmodel' => $this->id),array('order' => 'fecha DESC'));
      if($tr){
        return $tr->fecha;
      }
    }
	
	public function sumarAtribuciones(){
		$empleado = Empleados::model()->findByPk(Yii::app()->user->id_empleado);
		$orden = $this;
		$ok = true;
		$costo_total = 0;
		if($empleado == null or $orden == null){
		}else{
			$atribucion = Atribucion::model()->findByAttributes(array('id_empleado' => $empleado->id));
			if($atribucion == null){
			}else{
				$productos = ProductoOrden::model()->findAllByAttributes(array('orden' => $orden->id));
				if(count($productos) <= 0){
				}else{
					$pks = array();
					foreach($productos as $p){
						$pks[] = $p['id'];
					}
					$pks_producto_orden = implode(",", $pks);
					$cotizaciones = Cotizacion::model()->findAll(array(
					    'condition'=>'t.producto_orden in ('.$pks_producto_orden.')'
					));
					if(count($cotizaciones) <= 0){
					}else{
						foreach($cotizaciones as $c){
							if($c->elegido_compras == 1 and $c->elegido_usuario == 1){
								$costo_total = $costo_total + $c->total_compra_pesos;
							}
							if($c->elegido_compras != $c->elegido_usuario){
								break;
							}
						}
						if($costo_total <= $atribucion->atribucion_disponible and $ok){
							$atribucion->atribucion_disponible = $atribucion->atribucion_disponible + $costo_total;
							$atribucion->save();
						}
					}
				}
			}
		}
	}
	
	public function crearAsistentesCompras(){
		$q = AsistenteComiteCompras::model()->findAll();
		if(count($q) > 0){
			foreach($q as $e){
				$a = new AsistenteComite;
				$a->id_orden = $this->id;
				$a->id_empleado = $e->id_empleado;
				$a->save();
			}
		}
	}
	
	public function crearAsistentesPresidencia(){
		$q = AsistenteComitePresidencia::model()->findAll();
		if(count($q) > 0){
			foreach($q as $e){
				$a = new AsistenteComite;
				$a->id_orden = $this->id;
				$a->id_empleado = $e->id_empleado;
				$a->save();
			}
		}
	}

	public function tieneJefeGerente(){

		if($this->id_jefe != $this->id_gerente){
			return false;
		}

		$jefeGerente = $this->id_gerente;
		$query = <<<EOD
	    select count(*) from empleado_con_jefe_gerente where id_jefe_gerente = $jefeGerente
EOD;

	  $res =  $this->dbConnection->createCommand($query)->queryScalar();

	  if($res > 0)
	  	return true;

	  return false;
	}

	public function getJefeJefatura($empleado){
		
		$query = <<<EOD
	    select * from empleado_con_jefe_gerente where id_empleado = $empleado
EOD;

	  $res =  $this->dbConnection->createCommand($query)->queryAll();
	  return $res;
	}
	
	public function asignarAUsuario()
	{
		$this->usuario_actual = $this->id_usuario;
	}

    public function trazabilidadAtual(){
      $this->_traz = TrazabilidadWfs::model()->find(
                                                    array(
                                                          "condition" => "idmodel = :o",
                                                          "params" => array(':o' => $this->id),
                                                          "order"  => "id desc",
                                                          "limit"  => 1
                                                          )
                                                    );

    }

	public function asignarAPasoAnterior()
	{
      $traz = $this->_traz;

      if($traz != null){
        $transaction=$this->dbConnection->beginTransaction();
        try{
          $this->dbConnection->createCommand("update orden set usuario_actual = '".$traz->usuario_anterior."', 
                                             paso_wf = '".$traz->estado_anterior."' 
                                             where id = ".$this->id)->execute();
          $transaction->commit();
        }catch(Exception $e){

          $transaction->rollback();
          throw new CHttpException(500, "No se pudo devolver la solicitud al paso anterior");
        }

      }else{
        throw new CHttpException(500, "No se pudo devolver la solicitud al paso anterior");
      }

	}

	public function asignarAJefe()
	{
		$this->usuario_actual = $this->id_jefe;
	}

    public function asignarAJefeVentasAlkosto(){
		$this->usuario_actual = 541;
	}

	public function asignarAGerente()
	{
		$this->usuario_actual = $this->id_gerente;
	}

	public function asignarNulo()
	{
		$this->usuario_actual = null;
	}
	
	public function asignarAComiteCompras()
	{
		$this->usuario_actual = 515;
	}
	
	public function asignarAPresidencia()
	{
		$this->usuario_actual = 498;
	}

	public function asignarAJunta()
	{
		$this->usuario_actual = 498;
	}

	
	public function asignarAJefeCompras()
	{
		$this->usuario_actual = 32;
	}

	public function determinarAnalista(){
		$model_bd = Orden::model()->findByPk($this->id);
		if(($model_bd->paso_wf != 'swOrden/analista_compras')){
			$analista_anterior = TrazabilidadWfs::model()->findAll(
				array(
					'select' => 'max(fecha) as fecha, usuario_nuevo',
					'condition' => 'model = :m and idmodel = :i and estado_nuevo = :e',
					'params' => array(':m' => 'Orden', ':i' => $this->id, ':e' => 'swOrden/en_negociacion'),
					'order' => 'max(fecha) desc',
					'limit' => 1,
					'group' => 'usuario_nuevo'
				)
			);

			if(count($analista_anterior)){
			  $usuario = $analista_anterior[0]['usuario_nuevo'];
			  return $usuario;
			}
		}

		$res = TipoCompra::model()->findAllByPk($this->tipo_compra);
		$usuario = $res[0]['responsable'];

		return $usuario;
	}

	public function calcularAhorro(){
			$productos_orden = ProductoOrden::model()->with(
                                                      array(
                                                            'producto0',
                                                            )
                                                      )->findAllByAttributes(array('orden' => $this->id));

			foreach ($productos_orden as $producto) {
				if($producto->rechazado)
			    continue;

				$ahorro = 0;
				foreach ($producto->cotizacions as $cot) {
					if($cot->elegido_comite == 1){
						  $ahorro = Cotizacion::ahorro($cot->id, $producto->id) * $cot->total_compra_pesos;
						  if($ahorro != 0){
							$cot->total_ahorro = number_format($ahorro, 2,".","");
							if($cot->save()){

							};
						  }
					}
				}
			}
	}

	public function asignarOrdenesParaCancelar(){
		$reempazos = OrdenReemplazos::model()->findAllByAttributes(array('orden_nueva' => $this->id));

		if(count($reempazos)){
			foreach ($reempazos as $r) {
				$this->asignarOrdenParaCancelar($r->orden_vieja, "swOrden/cancaler_post_aprobacion", $this->usuario_actual);
			}
		}
	}

	public function asignarAnalistaCompras()
	{
		$usuario = $this->determinarAnalista();
		$this->usuario_actual = $usuario;
	}
	

	public function asignarOrdenParaCancelar($id, $paso, $empleado){
		$orden = Orden::model()->findByPk($id);
		$usuario_anterior = $orden->usuario_actual;
		$paso_anterior = $orden->paso_wf;

		$cuantos = Orden::model()->updateAll(array(
				'paso_wf' => $paso,
				'usuario_actual' => $empleado 
			), "id = :o", array(':o' => $id));
		
		if($cuantos == 1){
			$t = new TrazabilidadWfs;
			$t->model = "Orden";
			$t->idmodel = $id;
			$t->estado_anterior = $paso_anterior;
			$t->estado_nuevo = $paso;
			$t->usuario_nuevo = $empleado;
			$t->usuario_anterior = $usuario_anterior;
			$t->save();
			$this->sendEmailEspecial($id, $paso, $empleado);
		}
		
	}
	
	public function crearProductos(){
		//$po = ProductoOrden::model()->findAllByAttributes(array('orden' => $this->id));
		//if(count($po) == 0){
        $solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $this->id));
        if(count($solicitudes) > 0){
            foreach($solicitudes as $s){
                if(!ProductoOrden::model()->exists("orden_solicitud = :orden_sol", array(':orden_sol' => $s->id))){
                    $po = new ProductoOrden;
                    $po->orden = $this->id;
                    $po->orden_solicitud = $s->id;
                    $po->save();
                }
            }
        }
        //}
	}

	public function idProvisional(){
	  $query = <<<EOD
	    select nextval('numero_sol_provisional') as id;
EOD;

	  $res =  $this->dbConnection->createCommand($query)->queryAll();

	  if(!count($res))
	    throw new CException("No se pudo generar identificador provisional");

	  return $res[0]['id'];			

	}

	private function _updateId(){
	  $query = <<<EOD
	    select nextval('orden_id_seq') as id;
EOD;

	  $res =  $this->dbConnection->createCommand($query)->queryAll();
	  $id = $res[0]['id'];
	  $actual = $this->id;
	  $this->dbConnection->createCommand("update orden set id = $id where id = $actual")->execute();
	  $this->dbConnection->createCommand("update trazabiliadwfs set idmodel = $id where idmodel = $actual")->execute();
	  $this->dbConnection->createCommand("update activerecordlog set idmodel = $id where idmodel = $actual")->execute();
	  $this->dbConnection->createCommand("update observacioneswfs set idmodel = $id where idmodel = $actual and model = 'Orden'")->execute();
      return $id;
	}


	public function asignarNegociacion()
	{
		
	}
	
	public function existe_elegido_usuario(){
		$productos_orden = ProductoOrden::model()->findAllByAttributes(array('orden' => $this->id, 'rechazado' => false));
		if(count($productos_orden) > 0){
			foreach($productos_orden as $po){
				$cotizaciones = Cotizacion::model()->findAllByAttributes(array('producto_orden' => $po->id, 'elegido_usuario' => 1));
				if(count($cotizaciones) == 0){
					$this->addError("observacion", "Debe seleccionar una cotizacion para el producto ".$po->orden_solicitud0->nombre.".");
				}
			}
		}
	}
	
	public function existe_elegido_compras(){
		$productos_orden = ProductoOrden::model()->findAllByAttributes(array('orden' => $this->id, 'rechazado' => false));
		if(count($productos_orden) > 0){
			foreach($productos_orden as $po){
				$cotizaciones = Cotizacion::model()->findAllByAttributes(array('producto_orden' => $po->id, 'elegido_compras' => 1));
				if(count($cotizaciones) == 0){
					$this->addError("observacion", "Debe seleccionar una cotizacion para el producto ".$po->orden_solicitud0->nombre.".");
				}
			}
		}
	}
	
	public function existe_elegido_comite(){
		$productos_orden = ProductoOrden::model()->findAllByAttributes(array('orden' => $this->id, 'rechazado' => false));
		if(count($productos_orden) > 0){
			foreach($productos_orden as $po){
				$cotizaciones = Cotizacion::model()->findAllByAttributes(array('producto_orden' => $po->id, 'elegido_comite' => 1));
				if(count($cotizaciones) == 0){
					$this->addError("observacion", "Debe seleccionar una cotizacion para el producto ".$po->orden_solicitud0->nombre.".");
				}
			}
		}
	}
	
	public function marcarAprobacion(){
		$a = array();
		$a = $this->dbConnection->createCommand("select cot.id from cotizacion cot inner join producto_orden po inner join orden_solicitud os on (po.orden_solicitud = os.id) on (po.id = cot.producto_orden) where os.id_orden=".$this->id." and cot.elegido_usuario=1;")->queryAll();
		$r = array();
		if(count($a)>0){
			foreach($a as $c){
				$cotizacion = Cotizacion::model()->findByPk($c['id']);
				$cotizacion->elegido_comite = 1;
				$cotizacion->save();
			}
		}
	}
	
	public function proveedores(){
		$a = array();
		$a = $this->dbConnection->createCommand("select cot.nit from cotizacion cot inner join producto_orden po inner join orden_solicitud os on (po.orden_solicitud = os.id) on (po.id = cot.producto_orden) where os.id_orden=".$this->id." and cot.elegido_comite=1 group by cot.nit;")->queryAll();
		$r = array();
		if(count($a)>0){
			foreach($a as $id){
				$r[] = $id['nit'];
			}
			return $r;
		}else{
			return null;	
		}
	}
	
	public function analistaCompras(){
		$model_bd = Orden::model()->findByPk($this->id);
		if(($this->paso_wf != "swOrden/en_negociacion") and ($model_bd->paso_wf != 'swOrden/analista_compras')){
			$analista_anterior = TrazabilidadWfs::model()->findAll(
				array(
					'select' => 'max(fecha) as fecha, usuario_nuevo',
					'condition' => 'model = :m and idmodel = :i and estado_nuevo = :e',
					'params' => array(':m' => 'Orden', ':i' => $this->id, ':e' => 'analista_compras'),
					'group' => 'usuario_nuevo'
				)
			);

			if(count($analista_anterior)){
			  $usuario = $analista_anterior[0]['usuario_nuevo'];
			}else{
			  $res = TipoCompra::model()->findAllByPk($this->tipo_compra);
			  $usuario = $res[0]['responsable'];
			}
		
			return $usuario;
		}
	}
	
	public function createVinculacionProveedorAdministrativoYJuridico(){
		$proveedores = Proveedor::model()->findAllByPk($this->proveedores());
		foreach($proveedores as $p){
			$vpa = new VinculacionProveedorAdministrativo;
			$vpa->id_orden = $this->id;
			$vpa->paso_wf = 'swVinculacionProveedorAdministrativo/verificar_vinculacion';
			$vpa->id_proveedor = $p->nit;
			$vpa->save();
			$vpj = new VinculacionProveedorJuridico;
			$vpj->id_orden = $this->id;
			$vpj->paso_wf = 'swVinculacionProveedorJuridico/verificar_vinculacion';
			$vpj->id_proveedor = $p->nit;
			$vpj->save();
		}
	}
	
	public function sePuedeEnviarAUsuario(){
		if($this->paso_wf == "swOrden/aprobado_por_junta" or $this->paso_wf == "swOrden/aprobado_por_comite" or $this->paso_wf == "swOrden/aprobado_por_presidencia" or $this->paso_wf == "swOrden/aprobado_por_atribuciones"){
			$se_puede = true;
			$proveedores = Proveedor::model()->findAllByPk($this->proveedores());
			foreach($proveedores as $p){
				$vpjq = VinculacionProveedorJuridico::model()->findAllByAttributes(array('id_proveedor' => $p->nit, 'id_orden' => $this->id), array('order' => 'creacion DESC', 'limit' => 1));
				$vpj = $vpjq[0];
				if($vpj->paso_wf == "swVinculacionProveedorJuridico/ok_sin_contrato"){
					$se_puede = true;
				}else{
					$w = Willies::model()->findByAttributes(array('id_vpj' => $vpj->id));
					if($vpj->paso_wf == "swVinculacionProveedorJuridico/enviar_a_thomas" and $w->paso_wf == "swWillies/enviar_a_thomas"){
						
					}else{
						return false;
					}
				}
			}
			if($se_puede){
				return true;
			}
		}
		return false;
	}
	
	public function costo_total(){
		$orden = $this;
		$costo_total = 0;
		$productos = ProductoOrden::model()->findAllByAttributes(array('orden' => $orden->id));
		if(count($productos) <= 0){
			return 0;
		}else{
			$pks = array();
			foreach($productos as $p){
				$pks[] = $p['id'];
			}
			$pks_producto_orden = implode(",", $pks);
			$cotizaciones = Cotizacion::model()->findAll(array(
			    'condition'=>'t.producto_orden in ('.$pks_producto_orden.')'
			));
			if(count($cotizaciones) <= 0){
				return 0;
			}else{
				foreach($cotizaciones as $c){
					if($c->elegido_usuario == 1){
						$costo_total = $costo_total + $c->total_compra_pesos;
					}
				}
				return $costo_total;
			}
		}
	}
	
        public static function formatoMoneda($valor){
            $valor_ent= intval($valor);
            if($valor_ent>0){    
                if($valor/$valor_ent==1){
                    $respuesta= '$'.number_format($valor);
                }else{
                    $respuesta= '$'.number_format((round($valor*100)/100),2);
                }
            }else{
                $respuesta=$valor;
            } 
            return $respuesta;
        }
}
