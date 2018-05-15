<?php

/**
 * This is the model class for table "centro_costos".
 *
 * The followings are the available columns in table 'centro_costos':
 * @property integer $id
 * @property integer $codigo
 * @property integer $id_jefatura
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Orden[] $ordens
 */
class CentroCostos extends CActiveRecord
{
	public $nombre_jefatura_search;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CentroCostos the static model class
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
		return 'centro_costos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo, id_jefatura, nombre', 'required'),
			array('codigo, id_jefatura', 'numerical', 'integerOnly'=>true),
			array('codigo', 'unique'),
			array('nombre', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, id_jefatura, nombre, nombre_jefatura_search', 'safe', 'on'=>'search'),
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
			'jefatura' => array(self::BELONGS_TO, 'Jefaturas', 'id_jefatura'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'Codigo',
			'id_jefatura' => 'Jefatura',
			'nombre' => 'Nombre',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	 public function search()
	 {
		 // Warning: Please modify the following code to remove attributes that
		 // should not be searched.

		 $criteria=new CDbCriteria;
		 $criteria->with = array( 'jefatura' );
		 $criteria->condition = "activo='Si'";
		 $criteria->compare('t.id',$this->id);
		 $criteria->compare('t.codigo',$this->codigo);
		 $criteria->compare('t.id_jefatura',$this->id_jefatura);
		 $criteria->compare('LOWER(t.nombre)',strtolower($this->nombre),true);
		 $criteria->compare('LOWER(jefatura.nombre)',strtolower($this->nombre_jefatura_search),true);

		  return new CActiveDataProvider($this, array(
			  'criteria'=>$criteria,
			  'pagination'=>array(
					      'pageSize'=>'200',
					      ), 
			  'sort'=>array(
				  'attributes'=>array(
				      'nombre_jefatura_search'=>array(
					  'asc'=>'jefatura.nombre',
					  'desc'=>'jefatura.nombre DESC',
				      ),
				      '*',
				  ),
			      ),
		  ));
	 }

	 public function search_pres()
	 {
		 // Warning: Please modify the following code to remove attributes that
		 // should not be searched.

		 $criteria=new CDbCriteria;
		 $criteria->with = array( 'jefatura' );
		 $criteria->condition = "activo='Si'";
		 $criteria->compare('t.id',$this->id);
		 $criteria->compare('t.codigo',$this->codigo);
		 $criteria->compare('t.id_jefatura',$this->id_jefatura);
		 $criteria->compare('LOWER(t.nombre)',strtolower($this->nombre),true);
		 $criteria->compare('LOWER(jefatura.nombre)',strtolower($this->nombre_jefatura_search),true);

		  return new CActiveDataProvider($this, array(
			  'criteria'=>$criteria,
			  'pagination'=>array(
					      'pageSize'=>'7',
					      ), 
			  'sort'=>array(
				  'attributes'=>array(
				      'nombre_jefatura_search'=>array(
					  'asc'=>'jefatura.nombre',
					  'desc'=>'jefatura.nombre DESC',
				      ),
				      '*',
				  ),
			      ),
		  ));
	 }
	 
     public function beforeSave(){
       if($this->isNewRecord)
         $this->activo = "Si";
       
       return true;

     }
}