<?php

/**
 * This is the model class for table "documento_responsable_compras".
 *
 * The followings are the available columns in table 'documento_responsable_compras':
 * @property integer $id
 * @property string $responsable_compras
 */
class DocumentoResponsableCompras extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DocumentoResponsableCompras the static model class
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
		return 'documento_responsable_compras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('responsable_compras, correo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, responsable_compras, correo', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'responsable_compras' => 'Responsable Compras',
			'correo' => 'Correo Electrónico',
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
		$criteria->compare('responsable_compras',$this->responsable_compras,true);
		$criteria->compare('correo',$this->correo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function GetListaResponsableCompras(){
		return CHtml::listData(DocumentoResponsableCompras::model()->findall(array('order'=>'responsable_compras')), 'id', 'responsable_compras');
    }
}