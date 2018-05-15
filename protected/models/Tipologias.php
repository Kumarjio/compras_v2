<?php
/**
 * This is the model class for table "tipologias".
 *
 * The followings are the available columns in table 'tipologias':
 * @property integer $id
 * @property string $tipologia
 * @property integer $area
 * @property boolean $activa
 * @property boolean $operacion
 * @property boolean $en_espera
 * @property integer $tiempo_cliente
 * @property boolean $tutela
 * @property boolean $cargue
 *
 * The followings are the available model relations:
 * @property ActividadTipologia[] $actividadTipologias
 * @property Flujo[] $flujos
 * @property PlantillaTipologia[] $plantillaTipologias
 * @property Recepcion[] $recepcions
 * @property Areas $area0
 */
class Tipologias extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipologias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tipologia, area', 'required'),
            array('area', 'numerical', 'integerOnly'=>true),
            array('activa, operacion, en_espera, tutela, cargue', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, tipologia, area, activa, operacion, en_espera, tiempo_cliente, tutela, cargue', 'safe', 'on'=>'search'),
            array('tipologia', 'validaUnico'),
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
            'actividadTipologias' => array(self::HAS_MANY, 'ActividadTipologia', 'id_tipologia'),
            'flujos' => array(self::HAS_MANY, 'Flujo', 'tipologia'),
            'recepcions' => array(self::HAS_MANY, 'Recepcion', 'tipologia'),
            'area0' => array(self::BELONGS_TO, 'Areas', 'area'),
            'plantillaTipologias' => array(self::HAS_MANY, 'PlantillaTipologia', 'id_tipologia'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => 'No.',
            'tipologia' => 'Tipologia',
            'area' => 'Area',
            'activa' => 'Activa',
            'operacion' => 'Operacion',
            'en_espera' => 'En Espera',
            'tutela' => 'Tutela',
            'cargue' => 'Cargue',
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

        $criteria->compare('id',$this->id);
        //$criteria->compare('tipologia',$this->tipologia,true);
        $criteria->compare('area',$this->area);
        //$criteria->compare('activa',1);
        $criteria->compare('operacion',$this->operacion);
        $criteria->compare('en_espera',$this->en_espera);
        $criteria->compare('cargue',0);
        if(!empty($this->tipologia)){
			$criteria->addCondition("tipologia in (select tipologia from usuario where tipologia ilike '%".$this->tipologia."%')");
		}
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
				'defaultOrder'=>'id ASC',
			)
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tipologias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function cargaTipologias()
	{
	 	//return CHtml::listData(Tipologias::model()->findAll(array('order' => 'tipologia','condition'=>'activa=:D','params'=>array(':D'=>'true'))),'id','tipologia');
	 	return CHtml::listData(Tipologias::model()->findAll(array("condition"=>"activa =  true AND id <> 23 AND id <> 24",'order' => 't.tipologia')),'id',CHtml::encode('tipologia'),true);
	 	//return CHtml::listData(Tipologias::model()->findAll('activa = :act AND operacion = :ope', array(':act'=>true, ':ope'=>true)),'id','tipologia');
	}
	public static function getTipologia($na)
	{
	 	$tipologia = Recepcion::model()->findByAttributes(array("na"=>$na));
	 	return $tipologia->tipologia;
	}
	public static function informacionTipologia($tipologia)
	{
	 	$tipologia = Tipologias::model()->findByAttributes(array("id"=>$tipologia));
	 	return $tipologia;
	}
	public static function nombreTipologia($tipologia)
	{
		$tipologia = base64_decode($tipologia);	
		$model=Tipologias::model()->findByPk($tipologia);
		return ucwords(strtolower($model->tipologia));
	}
	public static function traerTiempo($tipologia)
	{
		$model=Tipologias::model()->findByPk($tipologia);
		return $model->tiempo_cliente;
	}
	public function validaUnico(){
		$criteriaVal = new CDbCriteria;
		$criteriaVal->addCondition("TRIM(tipologia) ILIKE '".trim($this->tipologia)."'");
		if(!$this->isNewRecord){
			$criteriaVal->addNotInCondition('id', array($this->id));
		}
		$duplicados = Tipologias::model()->findAll($criteriaVal);
		if($duplicados){
			$this->addError('tipologia', 'El nombre de la tipologia ya existe en el sistema.');
		}
	}
}
