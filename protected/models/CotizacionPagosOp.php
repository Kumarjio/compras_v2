<?php

/**
 * This is the model class for table "cotizacion_pagos_op".
 *
 * The followings are the available columns in table 'cotizacion_pagos_op':
 * @property integer $id
 * @property string $tipo
 * @property string $porcentaje
 * @property integer $id_cotizacion_op
 * @property string $observacion
 *
 * The followings are the available model relations:
 * @property CotizacionOp $idCotizacionOp
 */
class CotizacionPagosOp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cotizacion_pagos_op';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cotizacion_op, tipo, observacion, porcentaje', 'required'),
			array('id_cotizacion_op', 'numerical', 'integerOnly'=>true),
			array('tipo', 'length', 'max'=>255),
			array('porcentaje, observacion', 'safe'),
			array('porcentaje', 'numerical', 'integerOnly' => false),
			array('porcentaje', 'menor_que_cien'),
			array('porcentaje', 'anticipo_menor_que_cincuenta'),
            array('porcentaje', 'mensualidad_entero'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tipo, porcentaje, id_cotizacion_op, observacion', 'safe', 'on'=>'search'),
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
			'idCotizacionOp' => array(self::BELONGS_TO, 'CotizacionOp', 'id_cotizacion_op'),
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
			'porcentaje' => 'Porcentaje',
			'id_cotizacion_op' => 'Id Cotizacion Op',
			'observacion' => 'Observacion',
		);
	}

	
	public function menor_que_cien(){
		if(!(($this->porcentaje) > 0)){
			$this->addError('porcentaje','El porcentaje de pago debe ser mayor que cero.');
		}
		$pagos = CotizacionPagosOp::model()->findAllByAttributes(array('id_cotizacion_op' => $this->id_cotizacion_op));
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('porcentaje',$this->porcentaje,true);
		$criteria->compare('id_cotizacion_op',$_GET['id_cot']);
		$criteria->compare('observacion',$this->observacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CotizacionPagosOp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
