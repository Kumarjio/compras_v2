<?php

/**
 * This is the model class for table "facturacion.tmp_tipificadas".
 *
 * The followings are the available columns in table 'facturacion.tmp_tipificadas':
 * @property integer $id_tmp_tipificadas
 * @property integer $id_factura
 * @property integer $id_tipificada
 * @property string $valor
 */
class TmpTipificadas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TmpTipificadas the static model class
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
		return 'facturacion.tmp_tipificadas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_factura, id_tipificada', 'numerical', 'integerOnly'=>true),
			array('valor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_tmp_tipificadas, id_factura, id_tipificada, valor', 'safe', 'on'=>'search'),
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
			'id_tmp_tipificadas' => 'Id Tmp Tipificadas',
			'id_factura' => 'Id Factura',
			'id_tipificada' => 'Id Tipificada',
			'valor' => 'Valor',
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

		$criteria->compare('id_tmp_tipificadas',$this->id_tmp_tipificadas);
		$criteria->compare('id_factura',$this->id_factura);
		$criteria->compare('id_tipificada',$this->id_tipificada);
		$criteria->compare('valor',$this->valor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}