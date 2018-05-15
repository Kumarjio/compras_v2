<?php

/**
 * This is the model class for table "producto".
 *
 * The followings are the available columns in table 'producto':
 * @property integer $id
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property ProductoOrden[] $productoOrdens
 */
class Producto extends CActiveRecord
{
	public $orden;
	public $nombre_familia_search;
	public $id_categoria;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Producto the static model class
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
		return 'producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, id_familia', 'required'),
			array('nombre', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, nombre_familia_search, id_categoria, id_familia', 'safe', 'on'=>'search'),
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
			'productoOrdens' => array(self::HAS_MANY, 'ProductoOrden', 'producto'),
			'familia' => array(self::BELONGS_TO, 'FamiliaProducto', 'id_familia'),
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
			'id_categoria'=>'Categoria'
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
		$criteria->with = array('familia');
		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(t.nombre)',strtolower($this->nombre),true);
		$criteria->compare('LOWER(familia.nombre)', strtolower($this->nombre_familia_search), true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
			            'nombre_familia_search'=>array(
			                'asc'=>'familia.nombre',
			                'desc'=>'familia.nombre DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

	public function search_presupuesto()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('familia');
		//$criteria->with = array('familia.idCategoria');
		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(t.nombre)',strtolower($this->nombre),true);
		$criteria->compare('id_familia', $this->id_familia);
		$criteria->compare('familia.id_categoria', $this->id_categoria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
					'pageSize'=>'5',
			), 
			'sort'=>array(
			        'attributes'=>array(
			            'nombre_familia_search'=>array(
			                'asc'=>'familia.nombre',
			                'desc'=>'familia.nombre DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}
}