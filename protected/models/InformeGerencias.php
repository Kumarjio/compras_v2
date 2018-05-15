<?php

/**
 * This is the model class for table "informe_gerencias".
 *
 * The followings are the available columns in table 'informe_gerencias':
 * @property integer $id
 * @property string $nombre_compra
 * @property string $total
 * @property string $ahorro
 * @property string $fecha_solicitud
 * @property string $negociacion_directa
 * @property integer $id_jefatura
 * @property string $jefatura
 * @property integer $id_gerencia
 * @property string $gerencia
 * @property integer $nit
 */
class InformeGerencias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformeGerencias the static model class
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
		return 'informe_gerencias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_jefatura, id_gerencia, nit', 'numerical', 'integerOnly'=>true),
			array('nombre_compra, jefatura, gerencia', 'length', 'max'=>255),
			array('total, ahorro, fecha_solicitud, negociacion_directa', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre_compra, total, ahorro, fecha_solicitud, negociacion_directa, id_jefatura, jefatura, id_gerencia, gerencia, nit', 'safe', 'on'=>'search'),
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
			'nombre_compra' => 'Nombre Compra',
			'total' => 'Total',
			'ahorro' => 'Ahorro',
			'fecha_solicitud' => 'Fecha Solicitud',
			'negociacion_directa' => 'Negociacion Directa',
			'id_jefatura' => 'Id Jefatura',
			'jefatura' => 'Jefatura',
			'id_gerencia' => 'Id Gerencia',
			'gerencia' => 'Gerencia',
			'nit' => 'Nit',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($informeGlobal)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if($informeGlobal->id_gerencia != ''){
			$gerencias = implode(",", $informeGlobal->id_gerencia);
			$criteria->addCondition("id_gerencia in ($gerencias)");	
		}
		if($informeGlobal->id_jefatura != ''){
			$jefaturas = $informeGlobal->id_jefatura;
			$criteria->addCondition("id_jefatura in ($jefaturas)");
		}
		if($informeGlobal->tipo_negociacion != ''){
			$tipos_wh = implode(',', $informeGlobal->tipo_negociacion);
			$criteria->addCondition("tipo_negociacion in ($tipos_wh)");
		}
        $criteria->addCondition("fecha_solicitud between '".$informeGlobal->fecha_inicio."' and '".$informeGlobal->fecha_fin."'");

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre_compra',$this->nombre_compra,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('ahorro',$this->ahorro,true);
		$criteria->compare('fecha_solicitud',$this->fecha_solicitud,true);
		$criteria->compare('negociacion_directa',$this->negociacion_directa,true);
		$criteria->compare('jefatura',$this->jefatura,true);
		$criteria->compare('gerencia',$this->gerencia,true);
		$criteria->compare('nit',$this->nit);

        $pages = new CPagination;
        $pages->params = array('InformeGlobalForm'=>$informeGlobal->attributes); 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>$pages
		));
	}

	public function sumar($informeGlobal){

		$criteria=new CDbCriteria;
		$where = " where fecha_solicitud between '".$informeGlobal->fecha_inicio."' and '".$informeGlobal->fecha_fin."' ";
		if($informeGlobal->id_gerencia != ''){
			$gerencias = implode(",", $informeGlobal->id_gerencia);
			$where .= " and id_gerencia in ($gerencias) ";

		}

		if($informeGlobal->id_jefatura != ''){
			$jefaturas = $informeGlobal->id_jefatura;
			$where .= " and id_jefatura in ($jefaturas) ";
		}

		if($informeGlobal->tipo_negociacion != ''){
			$tipos_wh = implode(',', $informeGlobal->tipo_negociacion);
			$where .= " and tipo_negociacion in ($tipos_wh) ";

		}
		
		$criteria->select = ' sum(total) as suma';
		$total = Yii::app()->db->createCommand("select sum(total) as suma from informe_gerencias $where")->queryScalar();
		

		return Yii::app()->format->number($total);
	}
}