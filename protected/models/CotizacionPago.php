<?php

/**
 * This is the model class for table "cotizacion_pagos".
 *
 * The followings are the available columns in table 'cotizacion_pagos':
 * @property integer $id
 * @property string $tipo
 * @property string $porcentaje
 */
class CotizacionPago extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CotizacionPago the static model class
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
		return 'cotizacion_pagos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo, porcentaje, id_cotizacion, observacion', 'required'),
			array('tipo', 'length', 'max'=>255),
			array('porcentaje', 'numerical', 'integerOnly' => false),
			array('porcentaje', 'menor_que_cien'),
			array('porcentaje', 'anticipo_menor_que_cincuenta'),
            array('porcentaje', 'mensualidad_entero'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tipo, porcentaje', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'tipo' => 'Tipo',
			'porcentaje' => 'Porcentaje/Coutas',
			'observacion' => 'Observacion'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_cot)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = "id_cotizacion = :c";
		$criteria->params = array(':c' => $id_cot);
		$criteria->compare('id',$this->id);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('porcentaje',$this->porcentaje,true);
		$criteria->order = 'id ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function menor_que_cien(){
		if(!(($this->porcentaje) > 0)){
			$this->addError('porcentaje','El porcentaje de pago debe ser mayor que cero.');
		}
		$pagos = CotizacionPago::model()->findAllByAttributes(array('id_cotizacion' => $this->id_cotizacion));
		$cant = 0;
		if(count($pagos) > 0){
			foreach($pagos as $p){
				if($this->isNewRecord == false and $p->id == $this->id){
					
				}else{
					$cant += $p->porcentaje;
				}
			}
		}
		if(($cant + $this->porcentaje) > 100){
			$this->addError('porcentaje','La suma de los porcentajes no puede exceder el 100%.');
		}
	}
	
	public function anticipo_menor_que_cincuenta(){
		if($this->tipo == "Anticipo" and $this->porcentaje > 50.00){
			$this->addError('porcentaje','El anticipo no puede ser mayor al 50%.');
		}
	}

    public function mensualidad_entero(){
      if($this->tipo == "Mensualidad" and !preg_match('/^\d+$/',$this->porcentaje)){
			$this->addError('porcentaje','Ingrese un entero en el numero de cuotas');
		}
	}

}