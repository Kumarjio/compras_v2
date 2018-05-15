<?php

/**
 * This is the model class for table "detalle_orden_pedido".
 *
 * The followings are the available columns in table 'detalle_orden_pedido':
 * @property integer $id
 * @property integer $id_orden_compra
 * @property integer $id_producto
 * @property integer $id_proveedor
 * @property integer $id_direccion
 * @property integer $id_orden_solicitud
 * @property integer $cantidad
 * @property integer $id_orden
 * @property integer $id_cotizacion
 * @property string $fecha_entrega
 *
 * The followings are the available model relations:
 * @property Orden $idOrden
 * @property Producto $idProducto
 * @property Proveedor $idProveedor
 * @property OrdenSolicitudDireccion $idDireccion
 * @property OrdenSolicitud $idOrdenSolicitud
 * @property Cotizacion $idCotizacion
 */
class DetalleOrdenPedido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_orden_pedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_producto, id_proveedor, id_direccion, id_orden_solicitud, cantidad, id_orden, id_cotizacion, fecha_entrega', 'required'),
			array('id_orden_compra, id_producto, id_proveedor, id_direccion, id_orden_solicitud, cantidad, id_orden, id_cotizacion', 'numerical', 'integerOnly'=>true),
			array('observacion', 'safe',),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_orden_compra, id_producto, id_proveedor, id_direccion, id_orden_solicitud, cantidad, id_orden, id_cotizacion, fecha_entrega', 'safe', 'on'=>'search'),
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
			'idProducto' => array(self::BELONGS_TO, 'Producto', 'id_producto'),
			'idProveedor' => array(self::BELONGS_TO, 'Proveedor', 'id_proveedor'),
			'idDireccion' => array(self::BELONGS_TO, 'OrdenSolicitudDireccion', 'id_direccion'),
			'idOrdenSolicitud' => array(self::BELONGS_TO, 'OrdenSolicitud', 'id_orden_solicitud'),
			'idCotizacion' => array(self::BELONGS_TO, 'Cotizacion', 'id_cotizacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden_compra' => 'Id Orden Compra',
			'id_producto' => 'Producto',
			'id_proveedor' => 'Proveedor',
			'id_direccion' => 'Direccion',
			'id_orden_solicitud' => 'Id Orden Solicitud',
			'cantidad' => 'Cantidad Solicitada',
			'id_orden' => 'Id Orden',
			'id_cotizacion' => 'Id Cotizacion',
			'fecha_entrega' => 'Fecha Entrega',
			'observacion' => 'Observación'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($id_orden_solicitud)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden_compra',$this->id_orden_compra);
		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		$criteria->compare('id_direccion',$this->id_direccion);
		$criteria->compare('id_orden_solicitud',$id_orden_solicitud);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('id_cotizacion',$this->id_cotizacion);
		$criteria->compare('fecha_entrega',$this->fecha_entrega,true);
		$criteria->compare('observacion',$this->observacion,true);
		$criteria->compare('estado',"Sin Enviar",true);
		$criteria->compare('usuario',Yii::app()->user->getState('id_empleado'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>5,
		    ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DetalleOrdenPedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
