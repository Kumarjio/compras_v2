<?php

/**
 * This is the model class for table "proveedor".
 *
 * The followings are the available columns in table 'proveedor':
 * @property integer $nit
 * @property string $razon_social
 *
 * The followings are the available model relations:
 * @property ProveedorMiembros[] $proveedorMiembroses
 * @property Cotizacion[] $cotizacions
 */
class Proveedor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Proveedor the static model class
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
		return 'proveedor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('razon_social, nit', 'required'),
			array('razon_social', 'length', 'max'=>255),
			array('nit', 'numerical', 'integerOnly' => true),
			array('nit', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nit, razon_social', 'safe', 'on'=>'search'),
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
			'proveedorMiembroses' => array(self::HAS_MANY, 'ProveedorMiembros', 'nit'),
			'cotizacions' => array(self::HAS_MANY, 'Cotizacion', 'nit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nit' => 'Nit',
			'razon_social' => 'Razon Social',
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

		$criteria->compare('nit',$this->nit);
		$criteria->compare('LOWER(razon_social)',strtolower($this->razon_social),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getProveedor(){
		$query = Yii::app()->db->createCommand("select nit, nit || ' - ' || razon_social as dato from proveedor where bloqueado <> 1")->queryAll();
		return CHtml::listData($query, 'nit', 'dato');
	}

        public function searchAgregar($id_docPro)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addCondition("nit not in (select proveedor from documento_proveedor_adicional where id_docpro = $id_docPro)");
		$criteria->compare('nit',$this->nit);
		$criteria->compare('LOWER(razon_social)',strtolower($this->razon_social),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_2()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('nit',$this->nit);
		$criteria->compare('LOWER(razon_social)',strtolower($this->razon_social),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5)
		));
	}
}