<?php

/**
 * This is the model class for table "cotizacion_op".
 *
 * The followings are the available columns in table 'cotizacion_op':
 * @property integer $id
 * @property integer $orden_producto
 * @property integer $nit
 * @property integer $cantidad
 * @property string $moneda
 * @property string $valor_unitario
 * @property string $total_compra
 * @property integer $calificacion
 * @property string $descripcion
 * @property string $razon_eleccion_usuario
 * @property string $razon_eleccion_compras
 * @property string $razon_eleccion_comite
 * @property integer $enviar_a_usuario
 * @property integer $elegido_compras
 * @property integer $elegido_usuario
 * @property integer $elegido_comite
 * @property string $trm
 * @property string $total_compra_pesos
 * @property string $descuento_prontopago
 * @property string $porcentaje_descuento
 * @property integer $dias_pago_factura
 * @property integer $enviar_cotizacion_a_usuario
 * @property integer $contacto
 * @property string $numero
 * @property string $referencia
 * @property string $total_ahorro
 *
 * The followings are the available model relations:
 * @property OrdenProducto $ordenProducto
 * @property Proveedor $nit0
 */
class CotizacionOp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $nombre_proveedor;

	public function tableName()
	{
		return 'cotizacion_op';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_proveedor, orden_producto, nit, cantidad, moneda, valor_unitario, total_compra', 'required', 'except'=>'seleccion_envio, razon_eleccion_compras, razon_eleccion_comite, razon_eleccion_usuario'),
			array('orden_producto, nit, cantidad, calificacion, enviar_a_usuario, elegido_compras, elegido_usuario, elegido_comite, dias_pago_factura, enviar_cotizacion_a_usuario, contacto', 'numerical', 'integerOnly'=>true),
			array('razon_eleccion_compras, forma_negociacion, cant_valor', 'required', 'on' => 'razon_eleccion_compras'),
			array('razon_eleccion_comite, forma_negociacion, cant_valor', 'required', 'on' => 'razon_eleccion_comite'),
			array('razon_eleccion_usuario', 'required', 'on' => 'razon_eleccion_usuario'),
			array('moneda, numero, referencia', 'length', 'max'=>255),
			array('descuento_prontopago', 'length', 'max'=>2),
			array('calificacion', 'default', 'value' => 0),
			array('descripcion, razon_eleccion_usuario, razon_eleccion_compras, razon_eleccion_comite, trm, total_compra_pesos, porcentaje_descuento, total_ahorro', 'safe'),
			array('porcentaje_descuento', 'porcentaje'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orden_producto, nit, cantidad, moneda, valor_unitario, total_compra, calificacion, descripcion, razon_eleccion_usuario, razon_eleccion_compras, razon_eleccion_comite, enviar_a_usuario, elegido_compras, elegido_usuario, elegido_comite, trm, total_compra_pesos, descuento_prontopago, porcentaje_descuento, dias_pago_factura, enviar_cotizacion_a_usuario, contacto, numero, referencia, total_ahorro', 'safe', 'on'=>'search'),
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
			'ordenProducto' => array(self::BELONGS_TO, 'OrdenProducto', 'orden_producto'),
			'nit0' => array(self::BELONGS_TO, 'Proveedor', 'nit'),
			'idContacto' => array(self::BELONGS_TO, 'ContactoProveedor', 'contacto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orden_producto' => 'Orden Producto',
			'nit' => 'Nit',
			'cantidad' => 'Cantidad',
			'moneda' => 'Moneda',
			'valor_unitario' => 'Valor Unitario',
			'total_compra' => 'Total Compra',
			'calificacion' => 'Calificacion',
			'descripcion' => 'Descripcion',
			'razon_eleccion_usuario' => 'Razon Eleccion Usuario',
			'razon_eleccion_compras' => 'Razon Eleccion Compras',
			'razon_eleccion_comite' => 'Razon Eleccion Final',
			'enviar_a_usuario' => 'Enviar A Usuario',
			'elegido_compras' => 'Elegido Compras',
			'elegido_usuario' => 'Elegido Usuario',
			'elegido_comite' => 'Elegido Final',
			'trm' => 'Trm',
			'total_compra_pesos' => 'Total Compra Pesos',
			'descuento_prontopago' => 'Descuento Prontopago',
			'porcentaje_descuento' => 'Porcentaje Descuento',
			'dias_pago_factura' => 'Dias Pago Factura',
			'enviar_cotizacion_a_usuario' => 'Enviar Cotizacion A Usuario',
			'contacto' => 'Contacto',
			'numero' => 'Numero',
			'referencia' => 'Referencia',
			'total_ahorro' => 'Total Ahorro',
		);
	}
	
	public function porcentaje(){
		if($this->descuento_prontopago == "Si"){
			if($this->porcentaje_descuento == null or $this->porcentaje_descuento == ''){
				$this->addError("porcentaje_descuento", "Debe ingresar el porcentaje de descuento.");
			}else{
				if($this->porcentaje_descuento <= 0 ){
					$this->addError("porcentaje_descuento", "El porcentaje de descuento debe ser mayor que cero (0).");
				}else{
					if($this->porcentaje_descuento > 100 ){
						$this->addError("porcentaje_descuento", "El porcentaje de descuento debe ser menor que cien (100).");
					}
				}
			}
			if($this->dias_pago_factura == null or $this->dias_pago_factura == ''){
				$this->addError("dias_pago_factura", "Debe ingresar los días para el pago de la factura.");
			}else{
				if($this->dias_pago_factura <= 0 ){
					$this->addError("dias_pago_factura", "El número de días para el pago de la factura debe ser mayor a cero (0).");
				}else{
					
				}
			}
		}
		return true;
	}
	
	public function search($orden_producto)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$orp = OrdenProducto::model()->findByPk($orden_producto);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('orden_producto',$orden_producto);
		$criteria->compare('nit',$this->nit);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('valor_unitario',$this->valor_unitario,true);
		$criteria->compare('total_compra',$this->total_compra,true);
		$criteria->compare('calificacion',$this->calificacion);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('razon_eleccion_usuario',$this->razon_eleccion_usuario,true);
		$criteria->compare('razon_eleccion_compras',$this->razon_eleccion_compras,true);
		$criteria->compare('razon_eleccion_comite',$this->razon_eleccion_comite,true);
		$criteria->compare('enviar_a_usuario',$this->enviar_a_usuario);
		$criteria->compare('elegido_compras',$this->elegido_compras);
		$criteria->compare('elegido_usuario',$this->elegido_usuario);
		$criteria->compare('elegido_comite',$this->elegido_comite);
		$criteria->compare('trm',$this->trm,true);
		$criteria->compare('total_compra_pesos',$this->total_compra_pesos,true);
		$criteria->compare('descuento_prontopago',$this->descuento_prontopago,true);
		$criteria->compare('porcentaje_descuento',$this->porcentaje_descuento,true);
		$criteria->compare('dias_pago_factura',$this->dias_pago_factura);
		if($orp->idOrden->paso_wf == "swOrden/validacion_cotizaciones" || $orp->idOrden->paso_wf == "swOrden/gerente_compra" || $orp->idOrden->paso_wf == "swOrden/vicepresidente_compra")
			$criteria->compare('enviar_cotizacion_a_usuario',1);
		$criteria->compare('contacto',$this->contacto);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('total_ahorro',$this->total_ahorro,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function verUrlElegir(){
		if ($this->ordenProducto->idOrden->paso_wf == 'swOrden/en_negociacion' || $this->ordenProducto->idOrden->paso_wf == 'swOrden/aprobar_jefe_compras')
			return CController::createUrl("/orden/elegirCotCompras", array("prodord"=>$this->orden_producto,"id"=>$this->id));
		elseif($this->ordenProducto->idOrden->elegirCotizacionFinal() )
			return CController::createUrl("/orden/elegirComite", array("prodord"=>$this->orden_producto,"id"=>$this->id));
		else
			return CController::createUrl("/orden/elegir", array("prodord"=>$this->orden_producto,"id"=>$this->id));
	}

	/*public function validarElegir(){
		$estados = array('swOrden/', 'swOrdenMarcoCompras/devolucion' , 'swOrdenMarcoCompras/aprobar_por_comite' );
		return in_array($this->ordenProducto->idOrden->paso_wf, $estados);
	}*/

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
