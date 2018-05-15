<?php

/**
 * This is the model class for table "familias_productos".
 *
 * The followings are the available columns in table 'familias_productos':
 * @property integer $id
 * @property string $nombre
 */
class FamiliaProducto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FamiliaProducto the static model class
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
		return 'familias_productos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('id_categoria', 'numerical', 'integerOnly'=>true),
			array('nombre, id_categoria', 'required'),
			array('nombre', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, id_categoria', 'safe', 'on'=>'search'),
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
            'idCategoria' => array(self::BELONGS_TO, 'Categorias', 'id_categoria'),
            'productos' => array(self::HAS_MANY, 'Producto', 'id_familia'),
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
            'id_categoria' => 'Categoria',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(nombre)',strtolower($this->nombre),true);
        $criteria->compare('id_categoria',$this->id_categoria);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}