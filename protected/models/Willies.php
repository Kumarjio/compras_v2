<?php

/**
 * This is the model class for table "willies".
 *
 * The followings are the available columns in table 'willies':
 * @property integer $id
 * @property integer $id_orden
 * @property integer $id_proveedor
 * @property string $paso_wf
 * @property integer $usuario_actual
 * @property integer $id_vpj
 */
class Willies extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Willies the static model class
	 */
	public $razon_social;
	public $observacion;
    public $paso_actual;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'willies';
	}
	
	public function behaviors()
  {
      return array(
          'swBehavior'=>array(
              'class' => 'application.extensions.simpleWorkflow.SWActiveRecordBehavior',
          ),
          'WorkflowObservaciones'=>array(
              'class' => 'application.components.behavior.WorkflowObservaciones',
          ),
          'WorkflowTrazabilidad'=>array(
              'class' => 'application.components.behavior.WorkflowTrazabilidad',
          ),
      );
  }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('paso_wf', 'SWValidator','enableSwValidation'=>true),
			array('id_orden, id_proveedor, usuario_actual, id_vpj', 'numerical', 'integerOnly'=>true),
			array('paso_wf', 'length', 'max'=>255),
			array('observacion', 'required', 'on' => array('sw:revision_polizas_ajustes_contrato')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden, id_proveedor, paso_wf, usuario_actual, id_vpj, razon_social', 'safe', 'on'=>'search'),
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
			'orden' => array(self::BELONGS_TO, 'Orden', 'id_orden'),
			'proveedor' => array(self::BELONGS_TO, 'Proveedor', 'id_proveedor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden' => 'Id Orden',
			'id_proveedor' => 'Id Proveedor',
			'paso_wf' => 'Paso Wf',
			'usuario_actual' => 'Usuario Actual',
			'id_vpj' => 'Id Vpj',
		);
	}
	
	public function labelEstado($id_estado){
		$estados = SWHelper::allStatuslistData($this);
		return $estados[$id_estado];
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
		$criteria->with = array('proveedor');
		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		$criteria->compare('proveedor.razon_social',$this->razon_social, true);
		$criteria->compare('paso_wf',$this->paso_wf,true);
		$criteria->compare('usuario_actual',Yii::app()->user->id_empleado);
		$criteria->compare('id_vpj',$this->id_vpj);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
						'razon_social'=>array(
			                'asc'=>'proveedor.razon_social',
			                'desc'=>'proveedor.razon_social DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}
	
	public function search_anteriores()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('proveedor');
		$criteria->addCondition("t.id IN (select t.idmodel from trazabiliadwfs t where model='Willies' and usuario_anterior = :u)");
		$criteria->params = array(':u' => Yii::app()->user->getState('id_empleado'));
		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		$criteria->compare('proveedor.razon_social',$this->razon_social, true);
		$criteria->compare('paso_wf',$this->paso_wf,true);
		$criteria->compare('usuario_actual',Yii::app()->user->id_empleado);
		$criteria->compare('id_vpj',$this->id_vpj);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
						'razon_social'=>array(
			                'asc'=>'proveedor.razon_social',
			                'desc'=>'proveedor.razon_social DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}
	
	protected function beforeSave(){
		if($this->scenario != 'delegar'){
          $model = $this->findByPk($this->id);
          $this->paso_actual = $model->paso_wf;
			switch ($this->paso_wf) {
				case 'swWillies/ajustes_contrato':
					$this->asignarAnalistaCompras();
					break;
				case 'swWillies/revision_polizas':
					$this->asignarAWillies();
					break;
				case 'swWillies/enviar_a_thomas':
					$this->usuario_actual = 0;
					break;
				case 'swWillies/cancelada':
					$this->usuario_actual = 0;
					break;
				default:
					break;
			}
		}
		if($this->isNewRecord){
			$this->creacion = date("Y-m-d H:i:s");
		}
		return true;
	}
	
    public function afterSave(){
		parent::afterSave();
        if($this->paso_actual != $this->paso_wf){
          $this->sendEmail($this->id);
        }
		return true;
	}

    protected function sendEmail($id){
      $estados = SWHelper::allStatuslistData($this);
      $proximo = $estados[$this->paso_wf];
      
      $empleado = Empleados::model()->findByPk($this->usuario_actual);
      $email = $empleado->email;
      
      $nombre_compra = $this->orden->nombre_compra.", Proveedor: ".$this->proveedor->razon_social;

      $urlFin = $this->urlMail();

      if($email != "" and $this->usuario_actual != 0){
        if(false){

        }else{
          $html = '';
          Yii::app()->mailer->compraAsignada($email, $nombre_compra, $proximo, $id, $urlFin, $html);
        }
      }
    }

    public function urlMail(){
      $url = "/Willies/update";
      $parametro = 'id';
      $parametro_value = $this->id;
      if(in_array($this->paso_wf, array("swWillies/ajustes_contrato"))){
        $url = '/Orden/Vincular';
        $parametro = 'id';
        $parametro_value = $this->orden->id;
        //echo $this->orden->id; exit;
      }
      $urlFin = "http://".$_SERVER['HTTP_HOST']."/index.php".$url."?".$parametro."=".$parametro_value;
      return $urlFin;
    }

	public function asignarAnalistaCompras()
	{
		$orden = Orden::model()->findByPk($this->id_orden);
		$this->usuario_actual = $orden->usuario_actual;
	}
	
	public function asignarAWillies()
	{
		$au = AdministracionUsuario::model()->findbyAttributes(array('tipo_usuario' => "Willies"));
		if($au != null){
			$this->usuario_actual = $au->id_usuario;
		}
	}
}