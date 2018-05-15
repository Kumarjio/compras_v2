<?php

/**
 * This is the model class for table "disponibles_marco_compras".
 *
 * The followings are the available columns in table 'disponibles_marco_compras':
 * @property integer $nit
 * @property integer $cant_valor
 * @property integer $producto
 * @property integer $id_detalle_om
 * @property integer $disponible
 */
class DisponiblesMarcoCompras extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public function tableName()
	{
		return 'disponibles_marco_compras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nit, cant_valor, producto, id_detalle_om, disponible', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nit, cant_valor, producto, id_detalle_om, disponible', 'safe', 'on'=>'search'),
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
			'nit' => 'Nit',
			'cant_valor' => 'Cantidad o Valor',
			'producto' => 'Producto',
			'id_detalle_om' => 'Id Detalle Om',
			'disponible' => 'Disponible',
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

		$criteria->compare('nit',$this->nit);
		$criteria->compare('cant_valor',$this->cant_valor);
		$criteria->compare('producto',$this->producto);
		$criteria->compare('id_detalle_om',$this->id_detalle_om);
		$criteria->compare('disponible',$this->disponible);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DisponiblesMarcoCompras the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
