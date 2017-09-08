<?php

/**
 * This is the model class for table "plantillas_cartas".
 *
 * The followings are the available columns in table 'plantillas_cartas':
 * @property integer $id
 * @property string $nombre
 * @property string $plantilla
 * @property boolean $activa
 *
 * The followings are the available model relations:
 * @property PlantillaTipologia[] $plantillaTipologias
 */
class PlantillasCartas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plantillas_cartas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, plantilla', 'required'),
			array('activa', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, plantilla, activa', 'safe', 'on'=>'search'),
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
			'plantillaTipologias' => array(self::HAS_MANY, 'PlantillaTipologia', 'id_plantilla'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'plantilla' => 'Plantilla',
			'activa' => 'Activa',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('plantilla',$this->plantilla,true);
		$criteria->compare('activa',$this->activa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantillasCartas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function cargaPlantillas($tipologia)
	{
	 	return CHtml::listData(PlantillaTipologia::model()->findAll(array("condition"=>"id_tipologia =  $tipologia",'order' => 't.id', 'with'=>'idPlantilla')),'id_plantilla',CHtml::encode('idPlantilla.nombre'),true);
	}
	public function search_detalle()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('plantilla',$this->plantilla,true);
		$criteria->compare('activa',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.id ASC',
			)
		));
	}
}
