<?php

/**
 * This is the model class for table "sucursal_recepcion".
 *
 * The followings are the available columns in table 'sucursal_recepcion':
 * @property string $na
 * @property string $label
 * @property integer $fecha_sucursal
 * @property string $hora_sucursal
 *
 * The followings are the available model relations:
 * @property Recepcion $na0
 */
class SucursalRecepcion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sucursal_recepcion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('na, label, fecha_sucursal, hora_sucursal, no_documentos', 'required'),
			array('fecha_sucursal, no_documentos', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('na, label, fecha_sucursal, hora_sucursal, no_documentos', 'safe', 'on'=>'search'),
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
			'na0' => array(self::BELONGS_TO, 'Recepcion', 'na'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'na' => 'Na',
			'label' => 'Label',
			'fecha_sucursal' => 'Fecha Sucursal',
			'hora_sucursal' => 'Hora Sucursal',
			'no_documentos' => 'No Documentos',
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

		$criteria->compare('na',$this->na,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('fecha_sucursal',$this->fecha_sucursal);
		$criteria->compare('hora_sucursal',$this->hora_sucursal,true);
		$criteria->compare('hora_sucursal',$this->no_documentos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SucursalRecepcion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function informacionSucursal($na)
	{
		$sucursal = SucursalRecepcion::model()->findByAttributes(array("na"=>$na));
		return $sucursal;
	}
}
