<?php

/**
 * This is the model class for table "documentos".
 *
 * The followings are the available columns in table 'documentos':
 * @property integer $id_documento
 * @property string $nombre_documento
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property RecepcionDocumento[] $recepcionDocumentos
 * @property DocumentoProcedimiento[] $documentoProcedimientos
 */
class Documentos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'documentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre_documento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_documento, nombre_documento, estado', 'safe', 'on'=>'search'),
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
			'recepcionDocumentos' => array(self::HAS_MANY, 'RecepcionDocumento', 'id_documento'),
			'documentoProcedimientos' => array(self::HAS_MANY, 'DocumentoProcedimiento', 'id_documento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_documento' => 'Id Documento',
			'nombre_documento' => 'Nombre Documento',
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

		$criteria->compare('id_documento',$this->id_documento);
		$criteria->compare('nombre_documento',$this->nombre_documento,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Documentos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
