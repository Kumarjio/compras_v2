<?php

/**
 * This is the model class for table "festivos".
 *
 * The followings are the available columns in table 'festivos':
 * @property string $fecha
 * @property string $tipo_dia
 */
class Festivos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'festivos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, tipo_dia', 'required'),
			array('tipo_dia', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fecha, tipo_dia', 'safe', 'on'=>'search'),
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
			'fecha' => 'Fecha',
			'tipo_dia' => 'Tipo Dia',
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

		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('tipo_dia',$this->tipo_dia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function esHabil($time) {
            $time = date("Y-m-d",  strtotime($time));
            $consulta = $this->findByAttributes(array('fecha'=>$time),"tipo_dia <> 'S'");
            if($consulta == null)
                return true;
            return false;
        }
        
        public function traerProximoDia($time) {
            $time = date("Y-m-d",  strtotime("+1 day", strtotime($time)));
            while (!$this->esHabil($time)){
                $time = date("Y-m-d",  strtotime("+1 day", strtotime($time)));
            }
            return "$time 08:00:00";
        }
        
        public function sumarDias($time, $cantidad) {
            for($i=0; $i<$cantidad; $i++){
                $time = $this->traerProximoDia($time);
            }
            return $time;
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Festivos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
