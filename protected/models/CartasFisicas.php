<?php

/**
 * This is the model class for table "cartas_fisicas".
 *
 * The followings are the available columns in table 'cartas_fisicas':
 * @property string $id
 * @property string $id_cartas
 * @property integer $firma
 * @property string $direccion
 * @property string $ciudad
 *
 * The followings are the available model relations:
 * @property Cartas $idCartas
 * @property Ciudades $ciudad0
 * @property Firmas $firma0
 */
class CartasFisicas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cartas_fisicas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firma, direccion, ciudad', 'required'),
			array('firma', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cartas, firma, direccion, ciudad', 'safe', 'on'=>'search'),
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
			'idCartas' => array(self::BELONGS_TO, 'Cartas', 'id_cartas'),
			'ciudad0' => array(self::BELONGS_TO, 'Ciudades', 'ciudad'),
			'firma0' => array(self::BELONGS_TO, 'Firmas', 'firma'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_cartas' => 'Id Cartas',
			'firma' => 'Firma',
			'direccion' => 'Direccion',
			'ciudad' => 'Ciudad',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_cartas',$this->id_cartas,true);
		$criteria->compare('firma', 2);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->with = array('idCartas','idCartas.na0.tipologia0','idCartas.na0.tipologia0.area0','idCartas.na0');
		$criteria->addCondition(array('"idCartas"."punteo" = 1', '"idCartas"."entrega" = 2' ));
		if(!empty($_GET['destinatario'])){
			$destinatario = $_GET['destinatario'];
			$criteria->addCondition(array('"idCartas"."nombre_destinatario" ilike \'%'.$destinatario.'%\''));
		}
		if(!empty($_GET['na'])){
			$na = $_GET['na'];
			$criteria->addCondition(array('"idCartas"."na" = '.$na ));
		}
		if(!empty($_GET['principal'])){
			$principal = $_GET['principal'];
			$criteria->addCondition(array('"idCartas"."principal" = \''.$principal.'\''));
		}
		if(!empty($_GET['proveedor'])){
			$proveedor = $_GET['proveedor'];
			$criteria->addCondition(array('"idCartas"."proveedor"  = '.$proveedor));
		}
		if(!empty($_GET['direcccion'])){
			$direcccion = $_GET['direcccion'];
			$criteria->addCondition(array('"t"."direccion" ilike \'%'.$direcccion.'%\''));
		}
		if(!empty($_GET['tipologia'])){
			$tipologia = $_GET['tipologia'];
			$criteria->addCondition(array('"tipologia0"."tipologia" ilike \'%'.$tipologia.'%\''));
		}
		if(!empty($_GET['area'])){
			$area = $_GET['area'];
			$criteria->addCondition(array('"area0"."area" ilike \'%'.$area.'%\''));
		}
		if(!empty($_GET['fecha'])){
			$fecha = $_GET['fecha'];
			$criteria->addCondition(array('"na0"."fecha_entrega" = '.$fecha));
		}
		if(!empty($_GET['hora'])){
			$hora = $_GET['hora'];
			$criteria->addCondition(array('"na0"."hora_entrega" ilike \'%'.$hora.'%\''));
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CartasFisicas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function guardaFisico($id_cartas,$firma,$direccion,$ciudad)
	{
		$model = new CartasFisicas;
		$model->id_cartas = $id_cartas;
		$model->firma = $firma;
		$model->direccion = $direccion;
		$model->ciudad = $ciudad;
		if($model->save()){
			return true;
		}else{
			return false;
		}
	}
	public function search_impresion()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id,true);
        $criteria->compare('id_cartas',$this->id_cartas,true);
        $criteria->compare('direccion',$this->direccion,true);
        $criteria->compare('ciudad',$this->ciudad,true);
        $criteria->with = array('idCartas');
        $criteria->addCondition(array('"t"."firma" = 1' ,'firma = 3'),'OR');
        $criteria->addCondition(array('"idCartas"."punteo" = 1', '"idCartas"."entrega" = 2', '"idCartas"."impreso" = 0' ));
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    public function excel_punteo()
    {
    	$criteria=new CDbCriteria;
    	$criteria->compare('id',$this->id,true);
		$criteria->compare('id_cartas',$this->id_cartas,true);
		$criteria->compare('firma', 2);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->with = array('idCartas','idCartas.na0.tipologia0','idCartas.na0.tipologia0.area0','idCartas.na0');
		$criteria->addCondition(array('"idCartas"."punteo" = 2', '"idCartas"."entrega" = 2','"idCartas"."proveedor" = 2' ));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    public static function consultaExcel()
	{
		return CartasFisicas::model()->with( array('idCartas'=>array("alias"=>"c",'condition'=>'c.punteo = 2 AND c.entrega = 2')))->findAll("t.firma = :u", array(":u"=>"2"));
	}
	public static function actualizaPunteo($id)
	{	
		return Cartas::model()->updateAll(array('punteo'=>'3'),'id ='.$id);
	}
	public static function consultaExcel472()
	{
		return CartasFisicas::model()->with( array('idCartas'=>array("alias"=>"c",'condition'=>'c.punteo = 2 AND c.entrega = 2 AND c.proveedor = 1')))->findAll("t.firma = :u", array(":u"=>"2"));
	}
}
