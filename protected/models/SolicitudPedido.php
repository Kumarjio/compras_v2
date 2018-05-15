<?php

/**
 * This is the model class for table "solicitud_pedido".
 *
 * The followings are the available columns in table 'solicitud_pedido':
 * @property integer $id
 * @property integer $solicitante
 * @property integer $usuario_actual
 * @property string $fecha_solicitud
 * @property string $paso_wf
 *
 * The followings are the available model relations:
 * @property Empleados $solicitante0
 * @property Empleados $usuarioActual
 */
class SolicitudPedido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'solicitud_pedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('solicitante', 'required'),
			array('solicitante, usuario_actual', 'numerical', 'integerOnly'=>true),
			array('fecha_solicitud, paso_wf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, solicitante, usuario_actual, fecha_solicitud, paso_wf', 'safe', 'on'=>'search'),
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
			'solicitante0' => array(self::BELONGS_TO, 'Empleados', 'solicitante'),
			'usuarioActual' => array(self::BELONGS_TO, 'Empleados', 'usuario_actual'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'solicitante' => 'Solicitante',
			'usuario_actual' => 'Usuario Actual',
			'fecha_solicitud' => 'Fecha Solicitud',
			'paso_wf' => 'Paso Wf',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('solicitante',$this->solicitante);
		$criteria->compare('usuario_actual',$this->usuario_actual);
		$criteria->compare('fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('paso_wf',$this->paso_wf,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SolicitudPedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
