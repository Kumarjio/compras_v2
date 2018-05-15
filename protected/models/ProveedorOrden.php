<?php

/**
 * This is the model class for table "proveedor_orden".
 *
 * The followings are the available columns in table 'proveedor_orden':
 * @property integer $id
 * @property integer $id_proveedor
 * @property integer $id_orden_compra
 * @property integer $cantidad
 * @property string $valor_unitario
 * @property string $valor_compra
 *
 * The followings are the available model relations:
 * @property Proveedor $idProveedor
 * @property Orden $idOrdenCompra
 */
class ProveedorOrden extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProveedorOrden the static model class
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
		return 'proveedor_orden';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_proveedor, id_orden_compra, cantidad, valor_unitario, valor_compra', 'required'),
			array('id_proveedor, id_orden_compra, cantidad', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_proveedor, id_orden_compra, cantidad, valor_unitario, valor_compra', 'safe', 'on'=>'search'),
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
			'idProveedor' => array(self::BELONGS_TO, 'Proveedor', 'id_proveedor'),
			'idOrdenCompra' => array(self::BELONGS_TO, 'Orden', 'id_orden_compra'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_proveedor' => 'Id Proveedor',
			'id_orden_compra' => 'Id Orden Compra',
			'cantidad' => 'Cantidad',
			'valor_unitario' => 'Valor Unitario',
			'valor_compra' => 'Valor Compra',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		

		$criteria->compare('id',$this->id);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		$criteria->compare('id_orden_compra',$this->id_orden_compra);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('valor_unitario',$this->valor_unitario,true);
		$criteria->compare('valor_compra',$this->valor_compra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}