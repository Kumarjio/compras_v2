<?php

/**
 * This is the model class for table "tipo_documento".
 *
 * The followings are the available columns in table 'tipo_documento':
 * @property integer $id_tipo_documento
 * @property string $tipo_documento
 *
 * The followings are the available model relations:
 * @property Pacientes[] $pacientes
 */
class TipoDocumento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipo_documento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo_documento', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_tipo_documento, tipo_documento', 'safe', 'on'=>'search'),
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
			'pacientes' => array(self::HAS_MANY, 'Pacientes', 'id_tipo_documento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tipo_documento' => 'Id Tipo Documento',
			'tipo_documento' => 'Tipo Documento',
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

		$criteria->compare('id_tipo_documento',$this->id_tipo_documento);
		$criteria->compare('tipo_documento',$this->tipo_documento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipoDocumento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
