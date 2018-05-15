<?php

/**
 * This is the model class for table "documento_proveedor_adicional".
 *
 * The followings are the available columns in table 'documento_proveedor_adicional':
 * @property integer $id_docproadi
 * @property integer $id_docpro
 * @property integer $proveedor
 */
class DocumentoProveedorAdicional extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DocumentoProveedorAdicional the static model class
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
		return 'documento_proveedor_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_docpro, proveedor', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_docproadi, id_docpro, proveedor', 'safe', 'on'=>'search'),
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
                    
			'idProveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_docproadi' => 'Id Docproadi',
			'id_docpro' => 'Id Docpro',
			'proveedor' => 'Nit',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_docpro)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_docproadi',$this->id_docproadi);
		$criteria->compare('id_docpro',$id_docpro);
		$criteria->compare('proveedor',$this->proveedor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}