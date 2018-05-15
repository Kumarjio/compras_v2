<?php

/**
 * This is the model class for table "orden_marco_compras".
 *
 * The followings are the available columns in table 'orden_marco_compras':
 * @property integer $id
 * @property string $nombre_compra
 * @property string $resumen_breve
 * @property string $fecha_solicitud
 * @property integer $id_usuario
 * @property integer $usuario_actual
 * @property string $paso_wf
 * @property integer $id_usuario_reemplazado
 *
 * The followings are the available model relations:
 * @property Empleados $idUsuario
 * @property Empleados $usuarioActual
 * @property Empleados $idUsuarioReemplazado
 * @property OmProductoDetalle[] $omProductoDetalles
 */
class OrdenMarcoCompras extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $fake;
	public $observacion;
	public $nombre_usuario_search;
	public $paso_actual;
	public function tableName()
	{
		return 'orden_marco_compras';
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
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			    
			array('paso_wf', 'SWValidator','enableSwValidation'=>true),
			array('paso_wf', 'required', 'except'=>'paso_1, paso_2'),
			array('nombre_compra, resumen_breve', 'required', 'on'=>'paso_1'),
			array('fake', 'validarUnProducto', 'on'=>'paso_2'),
			array('observacion', 'required', 'on'=>array('sw:aprobar_por_comite-devolucion','sw:aprobar_por_comite-cancelada','sw:aprobar_por_comite-suspendida')),
			
			array('id_usuario, usuario_actual, id_usuario_reemplazado', 'numerical', 'integerOnly'=>true),
			array('nombre_compra, paso_wf', 'length', 'max'=>255),
			array('resumen_breve, fecha_solicitud, observacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre_compra, resumen_breve, fecha_solicitud, id_usuario, usuario_actual, paso_wf, id_usuario_reemplazado, nombre_usuario_search', 'safe', 'on'=>'search'),
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
			'idUsuario' => array(self::BELONGS_TO, 'Empleados', 'id_usuario'),
			'usuarioActual' => array(self::BELONGS_TO, 'Empleados', 'usuario_actual'),
			'idUsuarioReemplazado' => array(self::BELONGS_TO, 'Empleados', 'id_usuario_reemplazado'),
			'omProductoDetalles' => array(self::HAS_MANY, 'OmProductoDetalle', 'id_orden_marco'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre_compra' => 'Nombre Compra',
			'resumen_breve' => 'Resumen Breve',
			'fecha_solicitud' => 'Fecha Solicitud',
			'id_usuario' => 'Id Usuario',
			'usuario_actual' => 'Usuario Actual',
			'paso_wf' => 'Estado Siguiente',
			'id_usuario_reemplazado' => 'Id Usuario Reemplazado',
		);
	}

	protected function afterSave(){
	  parent::afterSave();

      $id = null;

	  if(($this->paso_wf != "swOrden/llenaroc" && $this->paso_wf != "" && $_GET['paso'] == 3) && $this->id > 600000000){
	    $id = $this->_updateId();
	    $this->id = $id;
	  }
      return true;

	}
	
	public function generarNumeroProvisional(){
	  	$query = <<<EOD
	   		select nextval('nro_orden_marco_provisional') as id;
EOD;

	  	$res =  $this->dbConnection->createCommand($query)->queryAll();

	  	if(!count($res))
	   		throw new CException("No se pudo generar identificador provisional");

	  	return $res[0]['id'];			

	}
	
	public static function elecciones($compras, $comite, $cotizacion){
		$resp = '';
		if($compras == 1){
			$texto_eleccion = array(
				'razon'=> $cotizacion->razon_eleccion_compras,
				'tipo' =>($cotizacion->forma_negociacion == 'cantidad')? 'Por Cantidad': 'Por Valor',
				'cant_valor' =>$cotizacion->cant_valor
			);
			$resp = $resp."<h5><div id=\"notification-target\"></div><span class=\"label label-warning eleccion\">".OmProductoDetalle::model()->get_descripcion($texto_eleccion, $cotizacion->id, "Compras")."</span></h5>";
		}
		if($comite == 1){
			if($resp == ''){
				$resp = $resp."<h5><div id=\"notification-target\"></div><span class=\"label label-success eleccion\">".OmProductoDetalle::model()->get_descripcion($cotizacion->razon_eleccion_comite, $cotizacion->id, "Comite")."</span></h5>";
			}else{
				$resp = $resp."<br/><br/><h5><div id=\"notification-target\"></div><span class=\"label label-success eleccion\">".OmProductoDetalle::model()->get_descripcion($cotizacion->razon_eleccion_comite, $cotizacion->id, "Comite")."</span></h5>";
			}
		}
		/*if($cotizacion->productoOrden->orden0->paso_wf == 'swOrden/aprobado_por_atribuciones'){
			if($resp == ''){
				$resp = $resp."<span class=\"label label-important eleccion\"><a>Atribuciones</a></span>";
			}else{
				$resp = $resp."<br/><br/><span class=\"label label-important eleccion\"><a>Atribuciones</a></span>";
			}
		}*/
		return $resp;
	}

	public function validarUnProducto(){
		if(count($this->omProductoDetalles) > 0){
			foreach ($this->omProductoDetalles as $detalle) {
				if(count($detalle->omCotizacions) >0){
					if(OmCotizacion::model()->envioParaRevision($detalle->id)){
						if(!OmCotizacion::model()->huboEleccionCompras($detalle->id))
							$this->addError("fake", "para el producto: ".$detalle->producto0->nombre." debe hacer una elección de cotización");
						if(!OmCotizacion::model()->huboEleccionComite($detalle->id) && $this->paso_wf == "swOrdenMarcoCompras/aprobar_por_comite" && !$detalle->rechazado)
							$this->addError("fake", "para el producto: ".$detalle->producto0->nombre." debe hacer una elección de cotización");
					}
					else
						$this->addError("fake", "para el producto: ".$detalle->producto0->nombre." debe enviar por lo menos una cotización al siguiente usuario");
				}
				else {
					$this->addError("fake", "Para el producto: ".$detalle->producto0->nombre." debe agregar por lo menos una cotización");
				}
			}
		}
		else{
			$this->addError("fake", "Debe ingresar por lo menos un producto");
		}
	}

	public function obligarObservacion(){
		echo "obsrb " . $this->observacion;
		die($this->getScenario());
		if($this->observacion == "" && $this->paso_wf == "swOrdenMarcoCompras/devolucion")
			$this->addError("observacion", "Observación no puede ser nulo.");
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre_compra',$this->nombre_compra,true);
		$criteria->compare('resumen_breve',$this->resumen_breve,true);
		$criteria->compare('fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('usuario_actual',Yii::app()->user->getState("id_empleado"));
		$criteria->compare('paso_wf',$this->paso_wf,true);
		$criteria->compare('id_usuario_reemplazado',$this->id_usuario_reemplazado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_aprobadas()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre_compra',$this->nombre_compra,true);
		$criteria->compare('resumen_breve',$this->resumen_breve,true);
		$criteria->compare('fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('usuario_actual',$this->usuario_actual);
		$criteria->compare('id_usuario_reemplazado',$this->id_usuario_reemplazado);
		$criteria->addInCondition('paso_wf', array('swOrdenMarcoCompras/aprobado_por_comite','swOrdenMarcoCompras/en_consumo','swOrdenMarcoCompras/finalizada'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	private function _updateId(){
	  	$query = <<<EOD
	    	select nextval('orden_marco_compras_id_seq') as id;
EOD;

	  	$res =  $this->dbConnection->createCommand($query)->queryAll();
	  	$id = $res[0]['id'];
	  	$actual = $this->id;
	  	$this->dbConnection->createCommand("update orden_marco_compras set id = $id where id = $actual")->execute();
	  	$this->dbConnection->createCommand("update trazabiliadwfs set idmodel = $id where idmodel = $actual")->execute();
	  	$this->dbConnection->createCommand("update activerecordlog set idmodel = $id where idmodel = $actual")->execute();
	  	$this->dbConnection->createCommand("update observacioneswfs set idmodel = $id where idmodel = $actual and model = 'OrdenMarcoCompras'")->execute();
      	return $id;
	}

	public function labelEstado($id_estado){
		$estados = SWHelper::allStatuslistData($this);
		return $estados[$id_estado];
	}

    public function getLastDate(){
      $tr = TrazabilidadWfs::model()->findByAttributes(array('model' => 'OrdenMarcoCompras', 'idmodel' => $this->id),array('order' => 'fecha DESC'));
      if($tr){
        return $tr->fecha;
      }
    }

	public function aprobacion_comite(){
		$this->usuario_actual = 515;
	}

	public function aprobado_comite(){
		$this->usuario_actual = -1;
	}

	public function para_devolucion(){
		$this->usuario_actual = $this->id_usuario;
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
