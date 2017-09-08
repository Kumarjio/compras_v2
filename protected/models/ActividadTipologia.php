<?php

/**
 * This is the model class for table "actividad_tipologia".
 *
 * The followings are the available columns in table 'actividad_tipologia':
 * @property string $id
 * @property string $id_actividad
 * @property string $id_tipologia
 *
 * The followings are the available model relations:
 * @property Actividades $idActividad
 * @property Tipologias $idTipologia
 * @property Relaciones[] $relaciones
 * @property Relaciones[] $relaciones1
 */
class ActividadTipologia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actividad_tipologia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_actividad, id_tipologia', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_actividad, id_tipologia', 'safe', 'on'=>'search'),
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
			'idActividad' => array(self::BELONGS_TO, 'Actividades', 'id_actividad'),
			'idTipologia' => array(self::BELONGS_TO, 'Tipologias', 'id_tipologia'),
			'relaciones' => array(self::HAS_MANY, 'Relaciones', 'desde'),
			'relaciones1' => array(self::HAS_MANY, 'Relaciones', 'hasta'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_actividad' => 'Id Actividad',
			'id_tipologia' => 'Id Tipologia',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_actividad',$this->id_actividad,true);
		$criteria->compare('id_tipologia',$this->id_tipologia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActividadTipologia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function validaCierreFlujo($tipologia)
	{
		$i = 0;
		$j = 0;
		$consulta = ActividadTipologia::model()->findAllByAttributes(array('id_tipologia'=>$tipologia));
		if($consulta){
			foreach ($consulta as $valida) {
				if($valida->id_actividad == "1"){
					$j++;
				}elseif($valida->id_actividad == "20"){
					$i++;
				}
			}
		}
		if($i && $j){
			return $consulta;
		}else{
			return false;
		}
	}
	public static function validaAristasFlujo($data)
	{
		$rows = count($data);
		$i = 1;
		foreach ($data as $valida) {
			$consulta = Relaciones::model()->findAllByAttributes(array('desde'=>$valida->id));
			if($consulta){
				$i++;
			}
		}
		if($rows == $i){
			return true;
		}else{
			return false;
		}
	}
	public static function validaFlujoCircular($data)
	{
		$consulta = ActividadTipologia::model()->findAllByAttributes(array('id_tipologia'=>$tipologia));
		foreach ($data as $valida) {

		}
		return true;
	}
}
