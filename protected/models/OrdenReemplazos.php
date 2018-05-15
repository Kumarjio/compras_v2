<?php

/**
 * This is the model class for table "orden_reemplazos".
 *
 * The followings are the available columns in table 'orden_reemplazos':
 * @property integer $id
 * @property integer $orden_nueva
 * @property integer $orden_vieja
 * @property string $creacion
 */
class OrdenReemplazos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenReemplazos the static model class
	 */
	public $nombre_compra;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orden_reemplazos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orden_nueva, orden_vieja', 'required'),
			array('orden_nueva, orden_vieja', 'numerical', 'integerOnly'=>true),
			array('orden_vieja','existeOrden', 'on' => 'asignar'),
			array('creacion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, orden_nueva, orden_vieja, creacion', 'safe', 'on'=>'search'),
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
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_vieja'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orden_nueva' => 'Orden Nueva',
			'orden_vieja' => 'Orden Vieja',
			'nombre_compra' => 'Nombre de la compra',
			'creacion' => 'Creacion',
		);
	}

	public function existeOrden(){
		if(!$this->hasErrors()){
			$orden = Orden::model()->find(array(
				"condition" => "id = :o and paso_wf in ('swOrden/usuario')",
				"params" => array(':o' => $this->orden_vieja)
			));

			if($orden === NULL){
				$this->addError("orden_vieja", "La orden ingresada no existe o no está aprobada");
			}
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($orden)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('orden_nueva',$orden);
		$criteria->compare('orden_vieja',$this->orden_vieja);
		$criteria->compare('creacion',$this->creacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}