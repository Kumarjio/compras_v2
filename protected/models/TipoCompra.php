<?php

/**
 * This is the model class for table "tipo_compra".
 *
 * The followings are the available columns in table 'tipo_compra':
 * @property integer $id
 * @property string $nombre
 * @property string $creacion
 * @property string $actualizacion
 *
 * The followings are the available model relations:
 * @property Orden[] $ordens
 */
class TipoCompra extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipoCompra the static model class
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
		return 'tipo_compra';
	}

	public function behaviors()
	{
		return array(
			/*
			'fechaRegistro' => array(
			'class' => 'application.components.behavior.FechaRegistroBehavior'
			),
			*/
		);
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, responsable', 'required'),
			array('nombre', 'length', 'max'=>255),
			array('nombre', 'unique', 'caseSensitive' => false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, creacion, actualizacion', 'safe', 'on'=>'search'),
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
			'ordens' => array(self::HAS_MANY, 'Orden', 'tipo_compra'),
			'responsable0' => array(self::BELONGS_TO, 'Empleados', 'responsable'),
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
		$criteria->select = 'responsable';
		$criteria->compare('id',$this->id);
		$criteria->compare('responsable',$this->responsable,true);
		$criteria->group = 'responsable';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_2()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if($this->responsable != ''){
			$criteria->addCondition("responsable in (select id from empleados where nombre_completo ilike '%".$this->responsable."%')");
		}
		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(nombre)',strtolower($this->nombre),true);
		//$criteria->compare('responsable',$this->responsable,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getResponsables()
	{
		$responsables = CHtml::listData(Empleados::model()->findAll(
			array(
				'order'=>'nombre_completo',
				#'with'=>'hora' ,
				'condition'=>"es_negociador = 'Si'"
				)
			),
			'id','nombre_completo');
		return $responsables;
	}

	public static function getCreacionResponsables()
	{
		$responsables = CHtml::listData(Empleados::model()->findAll(
			array(
				'order'=>'nombre_completo',
				#'with'=>'hora' ,
				'condition'=>"es_negociador IS NULL"
				)  
			),
			'id','nombre_completo');
		return $responsables;
	}
	
	/*public function search_2()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
  
							   
																															   
   
		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(nombre)',strtolower($this->nombre),true);
		$criteria->compare('responsable',$this->responsable,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_3()
	{
		$sql='SELECT responsable, (select nombre_completo from empleados where tipo_compra.responsable = id) as nombre FROM tipo_compra group by 1,2 UNION  SELECT 32, (select nombre_completo from empleados where id = 32) as nombre';
		
		
		return new CSqlDataProvider($sql, array(
			
		));
	 
						   
					   
	}*/

}
