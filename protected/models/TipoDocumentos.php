<?php

/**
 * This is the model class for table "tipo_documentos".
 *
 * The followings are the available columns in table 'tipo_documentos':
 * @property integer $id_tipo_documento
 * @property string $tipo_documento
 */
class TipoDocumentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipoDocumentos the static model class
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
		return 'tipo_documentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo_documento', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
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
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_tipo_documento',$this->id_tipo_documento);
		$criteria->compare('tipo_documento',$this->tipo_documento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}