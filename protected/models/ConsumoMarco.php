<?php

/**
 * This is the model class for table "consumo_marco".
 *
 * The followings are the available columns in table 'consumo_marco':
 * @property integer $id
 * @property integer $id_orden_producto
 * @property integer $id_marco_detalle
 * @property integer $cantidad
 * @property string $estado
 *
 * The followings are the available model relations:
 * @property OmProductoDetalle $idMarcoDetalle
 * @property OrdenProducto $idOrdenProducto
 */
class ConsumoMarco extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'consumo_marco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad', 'required'),
			array('id_orden_producto, id_marco_detalle, cantidad', 'numerical', 'integerOnly'=>true),
			array('estado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_orden_producto, id_marco_detalle, cantidad, estado', 'safe', 'on'=>'search'),
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
			'idMarcoDetalle' => array(self::BELONGS_TO, 'OmProductoDetalle', 'id_marco_detalle'),
			'idOrdenProducto' => array(self::BELONGS_TO, 'OrdenProducto', 'id_orden_producto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden_producto' => 'Id Orden Producto',
			'id_marco_detalle' => 'Id Marco Detalle',
			'cantidad' => 'Cantidad',
			'estado' => 'Estado',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden_producto',$this->id_orden_producto);
		$criteria->compare('id_marco_detalle',$this->id_marco_detalle);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('estado',$this->estado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConsumoMarco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
