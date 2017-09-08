<?php

/**
 * This is the model class for table "cartas".
 *
 * The followings are the available columns in table 'cartas':
 * @property string $id
 * @property string $carta
 * @property string $na
 * @property string $fecha_insert
 * @property integer $nombre_destinatario
 * @property integer $entrega
 * @property integer $proveedor
 *
 * The followings are the available model relations:
 * @property CartasMail[] $cartasMails
 * @property CartasFisicas[] $cartasFisicases
 * @property TelefonosCartas[] $telefonosCartases
 * @property Recepcion $na0
 * @property TipoEntrega $entrega0
 * @property Proveedores $proveedor0
 */
class Cartas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cartas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $trazabilidad;
	public $plantilla;
	public $area_carta;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carta, na, entrega, proveedor, nombre_destinatario, plantilla, trazabilidad', 'required'),
			array('entrega, proveedor', 'numerical', 'integerOnly'=>true),
			//array('direccion, mail', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, carta, na, fecha_insert, nombre_destinatario, entrega, proveedor, area_carta', 'safe', 'on'=>'search'),
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
            'cartasMails' => array(self::HAS_MANY, 'CartasMail', 'id_cartas'),
            'cartasFisicases' => array(self::HAS_MANY, 'CartasFisicas', 'id_cartas'),
            'telefonosCartases' => array(self::HAS_MANY, 'TelefonosCartas', 'id_carta'),
			'na0' => array(self::BELONGS_TO, 'Recepcion', 'na'),
			'entrega0' => array(self::BELONGS_TO, 'TipoEntrega', 'entrega'),
			'proveedor0' => array(self::BELONGS_TO, 'Proveedores', 'proveedor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'carta' => 'Carta',
			'na' => 'Na',
			'fecha_insert' => 'Fecha Insert',
			'nombre_destinatario' => 'Nombre Destinatario:',
			'entrega' => 'Entrega',
			'proveedor' => 'Proveedor',
			'plantilla' => 'Plantilla',
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
		$criteria->compare('carta',$this->carta,true);
		$criteria->compare('na',$this->na);
		$criteria->compare('fecha_insert',$this->fecha_insert,true);
		$criteria->compare('nombre_destinatario',$this->nombre_destinatario);
		$criteria->compare('entrega',$this->entrega);
		$criteria->compare('proveedor',$this->proveedor);
		$criteria->compare('punteo',$this->punteo=1);
		$criteria->with = array('na0');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cartas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function actualizaCarta($na,$carta)
	{
		$actualiza = Cartas::model()->updateAll(array('carta'=>$carta),'na = '.$na.'');
		if($actualiza){
			return true;
		}else{
			return false;
		}
	}
	public static function clasificacionCarta($na)
	{
		$consulta = Cartas::model()->findAllByAttributes(array("na"=>$na));
    	foreach ($consulta as $campo){
			if($campo->entrega == "1"){
				CartasMail::envioCartasMail($campo->id,$campo->carta,$campo->proveedor,$na);
			}elseif($campo->entrega == "2"){
				Cartas::model()->updateAll(array('punteo'=>'1'),'id ='.$campo->id);
			}
		}
		return true;
	}
}
