<?php

/**
 * This is the model class for table "plantilla_tipologia".
 *
 * The followings are the available columns in table 'plantilla_tipologia':
 * @property string $id
 * @property integer $id_plantilla
 * @property string $id_tipologia
 *
 * The followings are the available model relations:
 * @property PlantillasCartas $idPlantilla
 * @property Tipologias $idTipologia
 */
class PlantillaTipologia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plantilla_tipologia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipologia', 'required'),
			array('id_plantilla', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_plantilla, id_tipologia', 'safe', 'on'=>'search'),
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
			'idPlantilla' => array(self::BELONGS_TO, 'PlantillasCartas', 'id_plantilla'),
			'idTipologia' => array(self::BELONGS_TO, 'Tipologias', 'id_tipologia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_plantilla' => 'Id Plantilla',
			'id_tipologia' => 'Tipologias',
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
		$criteria->compare('id_plantilla',$this->id_plantilla);
		$criteria->compare('id_tipologia',$this->id_tipologia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantillaTipologia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function search_detalle()
	{
		$criteria=new CDbCriteria;
		if(!empty($_POST['id'])){
			$criteria->compare('id_plantilla',$_POST['id']);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			    'defaultOrder'=>'id ASC',
			)
		));
	}
}
