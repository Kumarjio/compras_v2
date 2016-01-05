<?php

/**
 * This is the model class for table "trazabilidad".
 *
 * The followings are the available columns in table 'trazabilidad':
 * @property integer $id_trazabilidad
 * @property string $estado_anterior
 * @property string $estado_actual
 * @property string $usuario_anterior
 * @property string $usuario_actual
 * @property string $fecha_trazabilidad
 * @property integer $id_cita
 */
class Trazabilidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trazabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cita', 'numerical', 'integerOnly'=>true),
			array('estado_anterior, estado_actual, usuario_anterior, usuario_actual, fecha_trazabilidad', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_trazabilidad, estado_anterior, estado_actual, usuario_anterior, usuario_actual, fecha_trazabilidad, id_cita', 'safe', 'on'=>'search'),
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
			'id_trazabilidad' => 'Id Trazabilidad',
			'estado_anterior' => 'Estado Anterior',
			'estado_actual' => 'Estado Actual',
			'usuario_anterior' => 'Usuario Anterior',
			'usuario_actual' => 'Usuario Actual',
			'fecha_trazabilidad' => 'Fecha Trazabilidad',
			'id_cita' => 'Id Cita',
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

		$criteria->compare('id_trazabilidad',$this->id_trazabilidad);
		$criteria->compare('estado_anterior',$this->estado_anterior,true);
		$criteria->compare('estado_actual',$this->estado_actual,true);
		$criteria->compare('usuario_anterior',$this->usuario_anterior,true);
		$criteria->compare('usuario_actual',$this->usuario_actual,true);
		$criteria->compare('fecha_trazabilidad',$this->fecha_trazabilidad,true);
		$criteria->compare('id_cita',$this->id_cita);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Trazabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
