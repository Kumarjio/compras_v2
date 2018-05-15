<?php

/**
 * This is the model class for table "cotizacion_regalos".
 *
 * The followings are the available columns in table 'cotizacion_regalos':
 * @property integer $id
 * @property integer $id_cotizacion
 * @property string $valor
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property Cotizacion $idCotizacion
 */
class CotizacionRegalos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CotizacionRegalos the static model class
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
		return 'cotizacion_regalos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                     array('valor, descripcion,id_cotizacion', 'required'),
			array('id_cotizacion', 'numerical', 'integerOnly'=>true),
			array('valor, descripcion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_cotizacion, valor, descripcion', 'safe', 'on'=>'search'),
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
			'id_cotizacion' => 'Id Cotizacion',
			'valor' => 'Valor',
			'descripcion' => 'Descripcion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_cot)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_cotizacion',$id_cot);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}