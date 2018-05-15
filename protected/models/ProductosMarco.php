<?php

/**
 * This is the model class for table "productos_marco".
 *
 * The followings are the available columns in table 'productos_marco':
 * @property integer $id_categoria
 * @property string $categoria
 * @property integer $id_subcategoria
 * @property string $subcategoria
 * @property integer $id_producto
 * @property string $producto
 * @property integer $id_orden_solicitud
 * @property integer $id_orden
 * @property integer $id_direccion
 * @property string $cant_disponible
 * @property integer $id_cotizacion
 * @property integer $id_proveedor
 */
class ProductosMarco extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'productos_marco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_categoria, id_subcategoria, id_producto, id_orden_solicitud, id_orden, id_direccion, id_cotizacion, id_proveedor', 'numerical', 'integerOnly'=>true),
			array('subcategoria, producto', 'length', 'max'=>255),
			array('categoria, cant_disponible', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_categoria, categoria, id_subcategoria, subcategoria, id_producto, producto, id_orden_solicitud, id_orden, id_direccion, cant_disponible, id_cotizacion, id_proveedor', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_categoria' => 'Id Categoria',
			'categoria' => 'Categoria',
			'id_subcategoria' => 'Id Subcategoria',
			'subcategoria' => 'Subcategoria',
			'id_producto' => 'Id Producto',
			'producto' => 'Producto',
			'id_orden_solicitud' => 'Id Orden Solicitud',
			'id_orden' => 'Id Orden',
			'id_direccion' => 'Id Direccion',
			'cant_disponible' => 'Cant Disponible',
			'id_cotizacion' => 'Id Cotizacion',
			'id_proveedor' => 'Id Proveedor',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_categoria',$this->id_categoria);
		$criteria->compare('categoria',$this->categoria,true);
		$criteria->compare('id_subcategoria',$this->id_subcategoria);
		$criteria->compare('subcategoria',$this->subcategoria,true);
		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('producto',$this->producto,true);
		$criteria->compare('id_orden_solicitud',$this->id_orden_solicitud);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('id_direccion',$this->id_direccion);
		$criteria->compare('cant_disponible',$this->cant_disponible,true);
		$criteria->compare('id_cotizacion',$this->id_cotizacion);
		$criteria->compare('id_proveedor',$this->id_proveedor);

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
	 * @return ProductosMarco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
