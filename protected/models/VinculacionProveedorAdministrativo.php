<?php

/**
 * This is the model class for table "vinculacion_proveedor_administrativo".
 *
 * The followings are the available columns in table 'vinculacion_proveedor_administrativo':
 * @property integer $id
 * @property integer $id_orden
 * @property string $paso_wf
 * @property integer $usuario_actual
 * @property integer $id_proveedor
 */
class VinculacionProveedorAdministrativo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VinculacionProveedorAdministrativo the static model class
	 */
	
	public $observacion;
	public $listas_control;
	public $entrevista;
	public $razon_social;
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
		return 'vinculacion_proveedor_administrativo';
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
			array('id_orden, usuario_actual, id_proveedor, nivel_riesgo, listas_control', 'numerical', 'integerOnly'=>true),
			array('paso_wf, vinculado', 'length', 'max'=>255),
			array('listas_control','required','requiredValue'=>1, 'message'=>'Debe certificar que se verificó en las listas de control y que el proveedor no esta bloqueado', 'on'=>array('sw:en_vinculacion_listo_para_contrato')),
			array('observacion', 'required', 'on' => array('sw:en_vinculacion_cancelado')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden, paso_wf, usuario_actual, razon_social, id_proveedor', 'safe', 'on'=>'search'),
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
			'paso_wf' => 'Paso Wf',
			'usuario_actual' => 'Usuario Actual',
			'id_proveedor' => 'Id Proveedor',
		);
	}
	
	public function labelEstado($id_estado){
		$estados = SWHelper::allStatuslistData($this);
		return $estados[$id_estado];
	}
	
	public function afterSave(){
        parent::afterSave();
		if($this->isNewRecord){
			$dvpa1 = new DocumentacionVinculacionProveedorAdministrativo;
			$dvpa1->id_vinculacion_proveedor_administrativo = $this->id;
			$dvpa1->analista_o_administrativo = "Analista";
			$dvpa1->save();
			$dvpa2 = new DocumentacionVinculacionProveedorAdministrativo;
			$dvpa2->id_vinculacion_proveedor_administrativo = $this->id;
			$dvpa2->analista_o_administrativo = "Administrativo";
			$dvpa2->save();
		}
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
      
      $nombre_compra = $this->orden->nombre_compra.", Vinculación del proveedor: ".$this->proveedor->razon_social;

      $urlFin = $this->urlMail();
      if($email != ""){
        if(false){

        }else{
          $html = '';
          Yii::app()->mailer->compraAsignada($email, $nombre_compra, $proximo, $id, $urlFin, $html);
        }
      }
    }

    public function urlMail(){
      $url = "/VinculacionProveedorAdministrativo/update";
      $parametro = 'id';
      $parametro_value = $this->id;
      if($this->paso_wf == "swVinculacionProveedorAdministrativo/verificar_vinculacion"){
        $url = '/Orden/Vincular';
        $parametro = 'id';
        $parametro_value = $this->orden->id;
        //echo $this->orden->id; exit;
      }
      $urlFin = "http://".$_SERVER['HTTP_HOST']."/index.php".$url."?".$parametro."=".$parametro_value;
      return $urlFin;
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
		$criteria->compare('paso_wf',$this->paso_wf,true);
		$criteria->compare('proveedor.razon_social',$this->razon_social,true);
		$criteria->compare('usuario_actual',Yii::app()->user->id_empleado);
		$criteria->compare('id_proveedor',$this->id_proveedor);

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
		$criteria->addCondition("t.id IN (select t.idmodel from trazabiliadwfs t where model='VinculacionProveedorAdministrativo' and usuario_anterior = :u)");
		$criteria->params = array(':u' => Yii::app()->user->getState('id_empleado'));
		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('paso_wf',$this->paso_wf,true);
		$criteria->compare('proveedor.razon_social',$this->razon_social,true);
		$criteria->compare('usuario_actual',Yii::app()->user->id_empleado);
		$criteria->compare('id_proveedor',$this->id_proveedor);

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
				case 'swVinculacionProveedorAdministrativo/verificar_vinculacion':
					$this->asignarAnalistaCompras();
					break;
				case 'swVinculacionProveedorAdministrativo/recepcion_documentacion':
					$this->asignarAAdministrativo();
					break;
				case 'swVinculacionProveedorAdministrativo/listo_para_contrato':
					$this->asignarAnalistaCompras();
					break;
				case 'swVinculacionProveedorAdministrativo/cancelada':
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
	
	public function asignarAnalistaCompras()
	{
		$orden = Orden::model()->findByPk($this->id_orden);
		$this->usuario_actual = $orden->usuario_actual;
	}
	
	public function asignarAAdministrativo()
	{
		$au = AdministracionUsuario::model()->findbyAttributes(array('tipo_usuario' => "Administrativo"));
		if($au != null){
			$this->usuario_actual = $au->id_usuario;
		}
	}
	
	public function verificarDocumentacion(){
		$d1 = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $this->id, 'analista_o_administrativo' => 'Analista'));
		$d2 = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $this->id, 'analista_o_administrativo' => 'Administrativo'));
		$iguales = true;
		$diferentes = array();
		if($d1->persona == "Natural"){
			if( 1 != $d2->formato_vinculacion){
				$d1->formato_vinculacion = 0;
				$iguales = false;
				$diferentes[] = 'Formato de vinculación de persona natural';
			}
			if(1 != $d2->formato_entrevista){
				$d1->formato_entrevista = 0;
				$iguales = false;
				$diferentes[] = 'Formato de entrevista de persona natural';
			}
		}else{
			if(1 != $d2->formato_vinculacion_persona_juridica){
				$d1->formato_vinculacion_persona_juridica = 0;
				$iguales = false;
				$diferentes[] = 'Formato de vinculacion de persona jurídica';
			}
			if(1 != $d2->formato_entrevista_persona_juridica){
				$d1->formato_entrevista_persona_juridica = 0;
				$iguales = false;
				$diferentes[] = 'Formato de entrevista de persona jurídica';
			}
			if(1 != $d2->camara_comercio){
				$d1->camara_comercio = 0;
				$iguales = false;
				$diferentes[] = 'Cámara de comercio';
			}
			if(1 != $d2->carta_relacion_socios){
				$d1->carta_relacion_socios = 0;
				$iguales = false;
				$diferentes[] = 'Carta de relacion de socios';
			}
		}
		if(1 != $d2->rut){
			$d1->rut = 0;
			$iguales = false;
			$diferentes[] = 'RUT';
		}
		if(1 != $d2->cedula_representante_legal){
			$d1->cedula_representante_legal = 0;
			$iguales = false;
			$diferentes[] = 'Cédula del representante legal / persona natural';
		}
		if(1 != $d2->certificacion_bancaria){
			$d1->certificacion_bancaria = 0;
			$iguales = false;
			$diferentes[] = 'Certificación bancaria';
		}
		if(!$iguales){
			$d1->save();
		}
		return $diferentes;
	}
	
}