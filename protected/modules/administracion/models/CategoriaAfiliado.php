<?php

/**
 * This is the model class for table "categoria_afiliado".
 *
 * The followings are the available columns in table 'categoria_afiliado':
 * @property integer $id_categoria_afiliado
 * @property integer $id_categoria
 * @property integer $id_tipo_afiliado
 *
 * The followings are the available model relations:
 * @property Categoria $idCategoria
 * @property TipoAfiliado $idTipoAfiliado
 */
class CategoriaAfiliado extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'categoria_afiliado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_categoria, id_tipo_afiliado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_categoria_afiliado, id_categoria, id_tipo_afiliado', 'safe', 'on'=>'search'),
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
			'idCategoria' => array(self::BELONGS_TO, 'Categoria', 'id_categoria'),
			'idTipoAfiliado' => array(self::BELONGS_TO, 'TipoAfiliado', 'id_tipo_afiliado'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_categoria_afiliado' => 'Id Categoria Afiliado',
			'id_categoria' => 'Id Categoria',
			'id_tipo_afiliado' => 'Id Tipo Afiliado',
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

		$criteria->compare('id_categoria_afiliado',$this->id_categoria_afiliado);
		$criteria->compare('id_categoria',$this->id_categoria);
		$criteria->compare('id_tipo_afiliado',$this->id_tipo_afiliado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoriaAfiliado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
