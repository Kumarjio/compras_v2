<?php

/**
 * This is the model class for table "empresa_persona".
 *
 * The followings are the available columns in table 'empresa_persona':
 * @property string $documento
 * @property string $razon
 * @property integer $documento_identificacion
 *
 * The followings are the available model relations:
 * @property DocumentosIdentificacion $documentoIdentificacion
 * @property PolizaEmpresa[] $polizaEmpresas
 */
class EmpresaPersona extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'empresa_persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('razon', 'required'),
			array('documento_identificacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('documento, razon, documento_identificacion', 'safe', 'on'=>'search'),
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
			'documentoIdentificacion' => array(self::BELONGS_TO, 'DocumentosIdentificacion', 'documento_identificacion'),
			'polizaEmpresas' => array(self::HAS_MANY, 'PolizaEmpresa', 'nit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'documento' => 'Documento',
			'razon' => 'Razon',
			'documento_identificacion' => 'Documento Identificacion',
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

		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('razon',$this->razon,true);
		$criteria->compare('documento_identificacion',$this->documento_identificacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmpresaPersona the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function informacionEmpresa($documento)
	{
		$empresa = EmpresaPersona::model()->findByAttributes(array("documento"=>$documento));
		return $empresa;
	}
}
