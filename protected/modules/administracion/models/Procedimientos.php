<?php

/**
 * This is the model class for table "procedimientos".
 *
 * The followings are the available columns in table 'procedimientos':
 * @property integer $id_procedimiento
 * @property integer $id_tipo_prestacion
 * @property integer $identificador
 *
 * The followings are the available model relations:
 * @property DocumentoProcedimiento[] $documentoProcedimientos
 * @property TipoPrestacion $idTipoPrestacion
 * @property ListaEspera[] $listaEsperas
 */
class Procedimientos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'procedimientos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_prestacion, identificador', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_procedimiento, id_tipo_prestacion, identificador', 'safe', 'on'=>'search'),
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
			'documentoProcedimientos' => array(self::HAS_MANY, 'DocumentoProcedimiento', 'id_procedimiento'),
			'idTipoPrestacion' => array(self::BELONGS_TO, 'TipoPrestacion', 'id_tipo_prestacion'),
			'listaEsperas' => array(self::HAS_MANY, 'ListaEspera', 'id_procedimiento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_procedimiento' => 'Id Procedimiento',
			'id_tipo_prestacion' => 'Id Tipo Prestacion',
			'identificador' => 'Identificador',
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

		$criteria->compare('id_procedimiento',$this->id_procedimiento);
		$criteria->compare('id_tipo_prestacion',$this->id_tipo_prestacion);
		$criteria->compare('identificador',$this->identificador);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Procedimientos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getNombreProcedimiento(){

		if($this->id_tipo_prestacion == "1"){
			$especialidad = Especialidad::model()->findByPk($this->identificador);
			if($especialidad)
				$nombrePro = $especialidad->nombre_especialidad;
		}else{
			$examen = AyudasDiagnosticas::model()->findByPk($this->identificador);
			if($examen)
				$nombrePro = $examen->nombre_ayuda;
		}

		if(empty($nombrePro))
			$nombrePro = " - ";

		return $nombrePro;
	}

}
