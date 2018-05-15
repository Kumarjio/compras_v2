<?php

/**
 * This is the model class for table "orden_solicitud".
 *
 * The followings are the available columns in table 'orden_solicitud':
 * @property integer $id
 * @property integer $id_orden
 * @property integer $cantidad
 * @property string $detalle
 * @property string $fecha_entrega
 * @property string $direccion_entrega
 * @property string $responsable
 * @property integer $requiere_acuerdo_servicios
 * @property integer $requiere_polizas_cumplimiento
 * @property integer $requiere_contrato
 * @property integer $nit
 * @property string $proveedor
 * @property string $valor_unitario
 * @property string $total_compra
 *
 * The followings are the available model relations:
 * @property Orden $idOrden
 * @property OrdenSolicitudCostos[] $ordenSolicitudCostoses
 */
class OrdenSolicitud extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenSolicitud the static model class
	 */
	public $requiere_polizas;
	public $fake;
	public $id_producto;
	public $nombre_producto;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orden_solicitud';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_orden, nombre, cantidad, fecha_entrega, fecha_maxima_aprobacion, detalle', 'required', 'on' => 'update'),
			array('id_orden, cantidad, requiere_acuerdo_servicios, requiere_polizas_cumplimiento, requiere_contrato, nit, requiere_acuerdo_confidencialidad, requiere_seriedad_oferta, requiere_buen_manejo_anticipo, requiere_calidad_suministro, requiere_calidad_correcto_funcionamiento, requiere_pago_salario_prestaciones, requiere_estabilidad_oferta, requiere_calidad_obra, requiere_responsabilidad_civil_extracontractual', 'numerical', 'integerOnly'=>true, 'on'=>'update'),
			array('fake', 'verificar_costos_usuario','on'=>'update'),
			array('id_producto, nombre_producto', 'required', 'on'=>'validacion_compras'),
			//array('direccion_entrega, responsable, proveedor', 'length', 'max'=>255),
			//array('detalle, fecha_entrega, total_compra', 'safe'),
			array('detalle, fecha_entrega, nombre_producto', 'safe'),
			//array('valor_unitario, total_compra, fecha_entrega', 'default', 'value'=>null),
			array('fecha_entrega, fecha_maxima_aprobacion', 'default', 'value'=>null),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, id_orden, cantidad, detalle, fecha_entrega, direccion_entrega, responsable, requiere_acuerdo_servicios, requiere_polizas_cumplimiento, requiere_contrato, nit, proveedor, valor_unitario, total_compra', 'safe', 'on'=>'search'),
			array('id, id_orden, cantidad, detalle, fecha_entrega, requiere_acuerdo_servicios, requiere_polizas_cumplimiento, requiere_contrato', 'safe', 'on'=>'search'),
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
			'idOrden' => array(self::BELONGS_TO, 'Orden', 'id_orden'),
			'ordenSolicitudCostoses' => array(self::HAS_MANY, 'OrdenSolicitudCostos', 'id_orden_solicitud'),
			'ordenSolicitudDirecciones' => array(self::HAS_MANY, 'OrdenSolicitudDireccion', 'id_orden_solicitud'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden' => 'Id Orden',
			'cantidad' => 'Cantidad/Número de horas',
			'detalle' => 'Detalle',
			'fecha_maxima_aprobacion' => 'Fecha Máxima de aprobación para la Compra',
			'fecha_entrega' => 'Fecha de Entrega',
			'requiere_acuerdo_servicios' => 'Requiere Acuerdo Servicios',
			'requiere_polizas_cumplimiento' => 'Requiere Polizas Cumplimiento',
			'requiere_contrato' => 'Requiere Contrato',
			//'nit' => 'Nit',
			//'proveedor' => 'Proveedor',
			//'valor_unitario' => 'Valor Unitario',
			//'total_compra' => 'Total Compra',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_orden)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = 'id_orden = :o';
		$criteria->params = array(':o' => $id_orden);
		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('fecha_entrega',$this->fecha_entrega,true);
		$criteria->compare('fecha_maxima_aprobacion',$this->fecha_maxima_aprobacion,true);
		$criteria->compare('requiere_acuerdo_servicios',$this->requiere_acuerdo_servicios);
		$criteria->compare('requiere_polizas_cumplimiento',$this->requiere_polizas_cumplimiento);
		$criteria->compare('requiere_contrato',$this->requiere_contrato);
		$criteria->order = 'id';
		//$criteria->compare('nit',$this->nit);
		//$criteria->compare('proveedor',$this->proveedor,true);
		//$criteria->compare('valor_unitario',$this->valor_unitario,true);
		//$criteria->compare('total_compra',$this->total_compra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getIdProducto(){
		$po = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $this->id));
		return $po->producto;
	}
	
    public function getIdCotizacion(){
		$po = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $this->id));
		$cot = Cotizacion::model()->findByAttributes(array('producto_orden' => $po->id, 'elegido_comite' => 1));
		return $cot->id;
	}

	public function getNitProveedor(){
		$po = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $this->id));
		$cot = Cotizacion::model()->findByAttributes(array('producto_orden' => $po->id, 'elegido_comite' => 1));
		return $cot->nit;
	}
	
	public function verificar_costos_usuario(){
		
		$porcentaje_o_cantidad = "";
		$porcentaje_o_cantidad_flag = true;
		$suma = 0;
		$costos = OrdenSolicitudCostos::model()->findAllByAttributes(array('id_orden_solicitud' => $this->id));
		if(!(count($costos) > 0)){
			$this->addError("fake", "Se debe asociar por lo menos un centro de costos y una cuenta contable a cada solicitud.");
			
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
				$this->addError("fake", "La distribución debe ser toda en cantidad o toda en porcentaje.");
				
			}
			if($porcentaje_o_cantidad == "Porcentaje" and $suma > 100){
				$this->addError("fake", "La suma de los porcentajes no debe ser mayor que 100.");
				
			}
			if($porcentaje_o_cantidad == "Cantidad" and $suma > $this->cantidad){
				$this->addError("fake", "La suma de las cantidades no debe ser mayor que la cantidad indicada en la solicitud.");
				
			}
		}
		$direcciones = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $this->id));
		if(!(count($direcciones) > 0)){
			$this->addError("resumen_breve", "Debe ingresar por lo menos una direccion de envío por producto.");
		}	
		
	}

	public function getNombreProducto(){
		$orden_producto = OrdenProducto::model()->findByAttributes(array('id_orden_solicitud'=>$this->id));
		if($orden_producto)
			return $orden_producto->idProducto->nombre;
		return "";
	}
}