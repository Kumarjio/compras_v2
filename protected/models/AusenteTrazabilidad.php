<?php

/**
 * This is the model class for table "ausente_trazabilidad".
 *
 * The followings are the available columns in table 'ausente_trazabilidad':
 * @property string $id_ausente_traza
 * @property string $usuario
 * @property integer $id_trazabilidad
 *
 * The followings are the available model relations:
 * @property Usuario $usuario0
 * @property Trazabilidad $idTrazabilidad
 */
class AusenteTrazabilidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ausente_trazabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, id_trazabilidad', 'required'),
			array('id_trazabilidad', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_ausente_traza, usuario, id_trazabilidad', 'safe', 'on'=>'search'),
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
			'usuario0' => array(self::BELONGS_TO, 'Usuario', 'usuario'),
			'idTrazabilidad' => array(self::BELONGS_TO, 'Trazabilidad', 'id_trazabilidad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_ausente_traza' => 'Id Ausente Traza',
			'usuario' => 'Usuario',
			'id_trazabilidad' => 'Id Trazabilidad',
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

		$criteria->compare('id_ausente_traza',$this->id_ausente_traza,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('id_trazabilidad',$this->id_trazabilidad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AusenteTrazabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
