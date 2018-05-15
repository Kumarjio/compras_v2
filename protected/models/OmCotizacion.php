<?php

/**
 * This is the model class for table "om_cotizacion".
 *
 * The followings are the available columns in table 'om_cotizacion':
 * @property integer $id
 * @property integer $producto_detalle_om
 * @property integer $nit
 * @property integer $cantidad
 * @property string $moneda
 * @property string $valor_unitario
 * @property string $total_compra
 * @property integer $calificacion
 * @property string $descripcion
 * @property string $razon_eleccion_compras
 * @property string $razon_eleccion_comite
 * @property integer $elegido_compras
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
 * @property OmProductoDetalle $productoDetalleOm
 * @property Proveedor $nit0
 */
class OmCotizacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $nombre_proveedor;

	public function tableName()
	{
		return 'om_cotizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_proveedor, contacto, producto_detalle_om, nit, cantidad, moneda, valor_unitario, total_compra, numero', 'required', 'except'=>'seleccion_envio, razon_eleccion_compras, razon_eleccion_comite'),
			array('producto_detalle_om, nit, cantidad, calificacion, elegido_compras, elegido_comite, dias_pago_factura, enviar_cotizacion_a_usuario, contacto', 'numerical', 'integerOnly'=>true),
			array('razon_eleccion_compras, forma_negociacion, cant_valor', 'required', 'on' => 'razon_eleccion_compras'),
			array('razon_eleccion_comite, forma_negociacion, cant_valor', 'required', 'on' => 'razon_eleccion_comite'),
			array('cant_valor', 'numerical'),
			array('moneda, numero, referencia', 'length', 'max'=>255),
			array('descuento_prontopago', 'length', 'max'=>2),
			array('calificacion', 'default', 'value' => 0),
			array('descripcion, razon_eleccion_compras, razon_eleccion_comite, trm, total_compra_pesos, porcentaje_descuento, total_ahorro, forma_negociacion, cant_valor', 'safe'),
			array('porcentaje_descuento', 'porcentaje'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, producto_detalle_om, nit, cantidad, moneda, valor_unitario, total_compra, calificacion, descripcion, razon_eleccion_compras, razon_eleccion_comite, elegido_compras, elegido_comite, trm, total_compra_pesos, descuento_prontopago, porcentaje_descuento, dias_pago_factura, enviar_cotizacion_a_usuario, contacto, numero, referencia, total_ahorro', 'safe', 'on'=>'search'),
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
			'productoDetalleOm' => array(self::BELONGS_TO, 'OmProductoDetalle', 'producto_detalle_om'),
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
			'producto_detalle_om' => 'Producto Detalle Om',
			'nit' => 'Nit',
			'cantidad' => 'Cantidad',
			'moneda' => 'Moneda',
			'valor_unitario' => 'Valor Unitario',
			'total_compra' => 'Total Compra',
			'calificacion' => 'Calificación',
			'descripcion' => 'Descripcion',
			'razon_eleccion_compras' => 'Razón Eleccion Compras',
			'razon_eleccion_comite' => 'Razón Eleccion Comite',
			'elegido_compras' => 'Elegido Compras',
			'elegido_comite' => 'Elegido Comite',
			'trm' => 'Trm',
			'total_compra_pesos' => 'Total Compra Pesos',
			'descuento_prontopago' => 'Descuento Prontopago',
			'porcentaje_descuento' => 'Porcentaje Descuento',
			'dias_pago_factura' => 'Dias Pago Factura',
			'enviar_cotizacion_a_usuario' => 'Enviar Cotización A Usuario',
			'contacto' => 'Contacto',
			'numero' => 'Numero',
			'referencia' => 'Referencia',
			'total_ahorro' => 'Total Ahorro',
			'forma_negociacion' => 'Forma de Negociación',
			'cant_valor' => 'Cantidad o Valor'
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


	public function envioParaRevision($omDetalle){
		$cots = $this->findAllByAttributes(array('producto_detalle_om'=>$omDetalle,'enviar_cotizacion_a_usuario'=> 1));
		if(!$cots)
			return false;
		return true;
	}

	public function huboEleccionCompras($omDetalle){
		$cots = $this->findAllByAttributes(array('producto_detalle_om'=>$omDetalle,'elegido_compras'=> 1));
		if(!$cots)
			return false;
		return true;
	}

	public function huboEleccionComite($omDetalle){
		$cots = $this->findAllByAttributes(array('producto_detalle_om'=>$omDetalle,'elegido_comite'=> 1));
		if(!$cots)
			return false;
		return true;
	}

	public function search($producto_detalle_om)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$omDeta = OmProductoDetalle::model()->findByPk($producto_detalle_om);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('producto_detalle_om',$producto_detalle_om);
		$criteria->compare('nit',$this->nit);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('valor_unitario',$this->valor_unitario,true);
		$criteria->compare('total_compra',$this->total_compra,true);
		$criteria->compare('calificacion',$this->calificacion);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('razon_eleccion_compras',$this->razon_eleccion_compras,true);
		$criteria->compare('razon_eleccion_comite',$this->razon_eleccion_comite,true);
		$criteria->compare('elegido_compras',$this->elegido_compras);
		$criteria->compare('elegido_comite',$this->elegido_comite);
		$criteria->compare('trm',$this->trm,true);
		$criteria->compare('total_compra_pesos',$this->total_compra_pesos,true);
		$criteria->compare('descuento_prontopago',$this->descuento_prontopago,true);
		$criteria->compare('porcentaje_descuento',$this->porcentaje_descuento,true);
		$criteria->compare('dias_pago_factura',$this->dias_pago_factura);
		if($omDeta->idOrdenMarco->paso_wf == "swOrdenMarcoCompras/aprobar_por_comite")
			$criteria->compare('enviar_cotizacion_a_usuario',1);
		$criteria->compare('contacto',$this->contacto);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('total_ahorro',$this->total_ahorro,true);
		$criteria->order = 'id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function verUrlElegir(){
		if ($this->productoDetalleOm->idOrdenMarco->paso_wf == 'swOrdenMarcoCompras/llenarocm' || $this->productoDetalleOm->idOrdenMarco->paso_wf == 'swOrdenMarcoCompras/devolucion')
			return CController::createUrl("/ordenMarcoCompras/elegir", array("prodord"=>$this->producto_detalle_om,"id"=>$this->id));
		else
			return CController::createUrl("/ordenMarcoCompras/elegirComite", array("prodord"=>$this->producto_detalle_om,"id"=>$this->id));
	}

	public function validarElegir(){
		$estados = array('swOrdenMarcoCompras/llenarocm', 'swOrdenMarcoCompras/devolucion' , 'swOrdenMarcoCompras/aprobar_por_comite' );
		return in_array($this->productoDetalleOm->idOrdenMarco->paso_wf, $estados);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
