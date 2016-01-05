<?php

/**
 * This is the model class for table "recepcion_documento".
 *
 * The followings are the available columns in table 'recepcion_documento':
 * @property integer $id_recepcion_documento
 * @property integer $id_cita
 * @property integer $id_documento
 * @property string $path
 * @property string $fecha_carga
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Cita $idCita
 * @property Documentos $idDocumento
 */
class RecepcionDocumento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recepcion_documento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cita, id_documento, estado', 'numerical', 'integerOnly'=>true),
			array('path, fecha_carga', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_recepcion_documento, id_cita, id_documento, path, fecha_carga, estado', 'safe', 'on'=>'search'),
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
			'idCita' => array(self::BELONGS_TO, 'Cita', 'id_cita'),
			'idDocumento' => array(self::BELONGS_TO, 'Documentos', 'id_documento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_recepcion_documento' => 'Id Recepcion Documento',
			'id_cita' => 'Id Cita',
			'id_documento' => 'Id Documento',
			'path' => 'Path',
			'fecha_carga' => 'Fecha Carga',
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

		$criteria->compare('id_recepcion_documento',$this->id_recepcion_documento);
		$criteria->compare('id_cita',$this->id_cita);
		$criteria->compare('id_documento',$this->id_documento);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('fecha_carga',$this->fecha_carga,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecepcionDocumento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
