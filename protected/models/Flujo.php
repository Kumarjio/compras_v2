<?php

/**
 * This is the model class for table "flujo".
 *
 * The followings are the available columns in table 'flujo':
 * @property string $id
 * @property string $actividad
 * @property string $sucesion
 * @property string $tipologia
 *
 * The followings are the available model relations:
 * @property Actividades $actividad0
 * @property Tipologias $tipologia0
 * @property Actividades $sucesion0
 */
class Flujo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public function tableName()
	{
		return 'flujo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $usuario;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('actividad, sucesion, tipologia, usuario', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, actividad, sucesion, tipologia', 'safe', 'on'=>'search'),
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
			'actividad0' => array(self::BELONGS_TO, 'Actividades', 'actividad'),
			'tipologia0' => array(self::BELONGS_TO, 'Tipologias', 'tipologia'),
			'sucesion0' => array(self::BELONGS_TO, 'Actividades', 'sucesion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'actividad' => 'Actividad',
			'sucesion' => 'Sucesión',
			'usuario' => 'Usuario',
			'tipologia' => 'Tipologia',
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
		$criteria->compare('actividad',$this->actividad);
		$criteria->compare('sucesion',$this->sucesion);
		$criteria->compare('tipologia',$this->tipologia);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Flujo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function search_detalle(){
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		if(!empty($_GET['tipologia'])){
			$criteria->compare('tipologia',$_GET['tipologia']);
		}else{
			$criteria->compare('tipologia',-1);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			  'sort'=>array(
			    'defaultOrder'=>'id ASC',
			  )
		));
	}
	public static function iniciaFlujo($na){
		$trazabilidad = new Trazabilidad;
		$tipologia = Tipologias::model()->getTipologia($na);	
		$flujo = Flujo::model()->findByAttributes(array("tipologia"=>$tipologia),array('order'=>'id'));
		$trazabilidad->na = $na;
		$trazabilidad->user_asign = Yii::app()->user->usuario;
		$trazabilidad->estado = "1";
		$trazabilidad->actividad = $flujo->id;
		$trazabilidad->save();
		return $flujo->id;
	}
}
