<?php

/**
 * This is the model class for table "detalle_orden_compra".
 *
 * The followings are the available columns in table 'detalle_orden_compra':
 * @property integer $id
 * @property integer $id_orden_compra
 * @property integer $id_producto
 * @property integer $id_proveedor
 * @property integer $id_direccion
 * @property integer $id_orden_solicitud
 * @property integer $cantidad
 */
class DetalleOrdenCompra extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetalleOrdenCompra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_orden_compra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_orden_compra, id_producto, id_proveedor, id_direccion, id_orden_solicitud, cantidad, id_orden', 'numerical', 'integerOnly'=>true, 'min' => 1),
			array('cantidad', 'required'),
			array('cantidad', 'menor_que_disponible'),
            array('fecha_entrega', 'date', 'format' => 'yyyy-MM-dd', 'message' => 'Formato de fecha inválido', 'allowEmpty' => false),
            array('fecha_entrega', 'after_today', 'skipOnError' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden_compra, id_producto, id_proveedor, id_direccion, id_orden_solicitud, cantidad', 'safe', 'on'=>'search'),
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
			'producto' => array(self::BELONGS_TO, 'Producto', 'id_producto'),
			'proveedor' => array(self::BELONGS_TO, 'Proveedor', 'id_proveedor'),
			'direccion' => array(self::BELONGS_TO, 'OrdenSolicitudDireccion', 'id_direccion'),
			'orden_solicitud' => array(self::BELONGS_TO, 'OrdenSolicitud', 'id_orden_solicitud'),
			'cotizacion' => array(self::BELONGS_TO, 'Cotizacion', 'id_cotizacion'),
			'orden' => array(self::BELONGS_TO, 'Orden', 'id_orden'),
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
			'id_direccion' => 'Id Direccion',
			'id_orden_solicitud' => 'Id Orden Solicitud',
			'cantidad' => 'Cantidad',
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
		$criteria->condition = 'id_orden_compra is null';
		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden_compra',$this->id_orden_compra);
		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		$criteria->compare('id_direccion',$this->id_direccion);
		$criteria->compare('id_orden_solicitud',$this->id_orden_solicitud);
		$criteria->compare('id_orden',$id_orden);
		$criteria->compare('cantidad',$this->cantidad);

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
		$criteria->compare('id_direccion',$this->id_direccion);
		$criteria->compare('id_orden_solicitud',$this->id_orden_solicitud);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('cantidad',$this->cantidad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function menor_que_disponible(){
		if($this->isNewRecord){
			if($this->cantidad > $this->direccion->cantidadDisponible()){
				$this->addError('cantidad','La cantidad total exede la cantidad disponible del producto.');
			}
		}else{
			$q = DetalleOrdenCompra::model()->findByPk($this->id);
			if($this->cantidad > ($this->direccion->cantidadDisponible() + $q->cantidad)){
				$this->addError('cantidad','La cantidad total exede la cantidad disponible del producto.');
			}
		}
	}

    public function after_today(){
      $hoy = time();
      $nf = $hoy + (60*60*24);
      if($this->fecha_entrega < date('Y-m-d',$nf) && $this->fecha_entrega != null){
        $this->addError('fecha_entrega','La fecha debe ser posterior al día de hoy.');                 
      }
    }

}
