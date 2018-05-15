<?php

/**
 * This is the model class for table "consumo_productos".
 *
 * The followings are the available columns in table 'consumo_productos':
 * @property integer $id_producto
 * @property string $consumo
 * @property integer $id_jefatura
 * @property integer $id_gerencia
 * @property integer $id_vicepresidencia
 * @property double $anio_solicitud
 */
class ConsumoProductos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'consumo_productos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_producto, id_jefatura, id_gerencia, id_vicepresidencia', 'numerical', 'integerOnly'=>true),
			array('anio_solicitud', 'numerical'),
			array('consumo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_producto, consumo, id_jefatura, id_gerencia, id_vicepresidencia, anio_solicitud', 'safe', 'on'=>'search'),
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
			'id_producto' => 'Id Producto',
			'consumo' => 'Consumo',
			'id_jefatura' => 'Id Jefatura',
			'id_gerencia' => 'Id Gerencia',
			'id_vicepresidencia' => 'Id Vicepresidencia',
			'anio_solicitud' => 'Anio Solicitud',
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

		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('consumo',$this->consumo,true);
		$criteria->compare('id_jefatura',$this->id_jefatura);
		$criteria->compare('id_gerencia',$this->id_gerencia);
		$criteria->compare('id_vicepresidencia',$this->id_vicepresidencia);
		$criteria->compare('anio_solicitud',$this->anio_solicitud);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConsumoProductos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
