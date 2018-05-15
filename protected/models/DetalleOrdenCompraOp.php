<?php

/**
 * This is the model class for table "detalle_orden_compra_op".
 *
 * The followings are the available columns in table 'detalle_orden_compra_op':
 * @property integer $id
 * @property integer $id_orden_compra
 * @property integer $id_producto
 * @property integer $id_proveedor
 * @property integer $id_orden_producto
 * @property integer $cantidad
 * @property integer $id_orden
 * @property integer $id_cotizacion
 * @property string $fecha_entrega
 *
 * The followings are the available model relations:
 * @property OrdenCompra $idOrdenCompra
 * @property Producto $idProducto
 * @property Proveedor $idProveedor
 * @property OrdenProducto $idOrdenProducto
 * @property Orden $idOrden
 * @property CotizacionOp $idCotizacion
 */
class DetalleOrdenCompraOp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_orden_compra_op';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_orden_compra, id_producto, id_proveedor, id_orden_producto, cantidad, id_orden, id_cotizacion', 'numerical', 'integerOnly'=>true),
			array('fecha_entrega', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_orden_compra, id_producto, id_proveedor, id_orden_producto, cantidad, id_orden, id_cotizacion, fecha_entrega', 'safe', 'on'=>'search'),
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
			'idOrdenCompra' => array(self::BELONGS_TO, 'OrdenCompra', 'id_orden_compra'),
			'idProducto' => array(self::BELONGS_TO, 'Producto', 'id_producto'),
			'idProveedor' => array(self::BELONGS_TO, 'Proveedor', 'id_proveedor'),
			'idOrdenProducto' => array(self::BELONGS_TO, 'OrdenProducto', 'id_orden_producto'),
			'idOrden' => array(self::BELONGS_TO, 'Orden', 'id_orden'),
			'idCotizacion' => array(self::BELONGS_TO, 'CotizacionOp', 'id_cotizacion'),
			'idCotizacionOm' => array(self::BELONGS_TO, 'OmCotizacion', 'id_cotizacion_om'),
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
			'id_producto' => 'Id Producto',
			'id_proveedor' => 'Id Proveedor',
			'id_orden_producto' => 'Id Orden Producto',
			'cantidad' => 'Cantidad',
			'id_orden' => 'Id Orden',
			'id_cotizacion' => 'Id Cotizacion',
			'fecha_entrega' => 'Fecha Entrega',
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
	public function search($id_orden)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = 'id_orden_compra is null';
		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden_compra',$this->id_orden_compra);
		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		$criteria->compare('id_orden_producto',$this->id_orden_producto);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('id_orden',$id_orden);
		$criteria->compare('id_cotizacion',$this->id_cotizacion);
		$criteria->compare('fecha_entrega',$this->fecha_entrega,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_2($id_orden_compra)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden_compra',$id_orden_compra);
		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		$criteria->compare('id_orden_producto',$this->id_orden_producto);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('cantidad',$this->cantidad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
