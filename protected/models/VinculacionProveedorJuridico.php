<?php

/**
 * This is the model class for table "vinculacion_proveedor_juridico".
 *
 * The followings are the available columns in table 'vinculacion_proveedor_juridico':
 * @property integer $id
 * @property integer $id_orden
 * @property string $paso_wf
 * @property integer $usuario_actual
 * @property integer $id_proveedor
 */
class VinculacionProveedorJuridico extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VinculacionProveedorJuridico the static model class
	 */
	
	public $observacion;
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
		return 'vinculacion_proveedor_juridico';
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
			array('id_orden, usuario_actual, id_proveedor', 'numerical', 'integerOnly'=>true),
			array('paso_wf', 'length', 'max'=>255),
			array('observacion', 'required', 'on' => array('sw:recepcion_documentacion_verificar_vinculacion')),
			array('observacion', 'required', 'on' => array('sw:revision_contrato_ajustes_contrato')),
			array('observacion', 'required', 'on' => array('sw:enviar_firmas_revision_contrato')),
			array('observacion', 'required', 'on' => array('sw:revision_contrato_firmado_enviar_firmas')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden, paso_wf, usuario_actual, id_proveedor, razon_social', 'safe', 'on'=>'search'),
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
		$criteria->addCondition("t.id IN (select t.idmodel from trazabiliadwfs t where model='VinculacionProveedorJuridico' and usuario_anterior = :u)");
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
				case 'swVinculacionProveedorJuridico/verificar_vinculacion':
					$this->asignarAnalistaCompras();
					break;
				case 'swVinculacionProveedorJuridico/recepcion_documentacion':
					$this->asignarAJuridico();
					break;
				case 'swVinculacionProveedorJuridico/listo_para_contrato':			
					if((!$this->requiereContrato()) and (!$this->requierePolizaOAcuerdo())){
						$this->paso_wf = 'swVinculacionProveedorJuridico/enviar_a_thomas';
						$this->usuario_actual = 0;
						$this->willies();
					}else{
						$this->asignarAnalistaCompras();
					}
					break;
				case 'swVinculacionProveedorJuridico/revision_contrato':
					$this->asignarAJuridico();
					break;
				case 'swVinculacionProveedorJuridico/ok_sin_contrato':
					$this->asignarAnalistaCompras();
					break;
				case 'swVinculacionProveedorJuridico/ajustes_contrato':
					$this->asignarAnalistaCompras();
					$this->willies();
					break;
				case 'swVinculacionProveedorJuridico/enviar_firmas':
					$this->asignarAnalistaCompras();
					break;
				case 'swVinculacionProveedorJuridico/revision_contrato_firmado':
					$this->asignarAJuridico();
					break;
				case 'swVinculacionProveedorJuridico/enviar_a_thomas':
					$this->usuario_actual = 0;
					break;
				case 'swVinculacionProveedorJuridico/cancelado':
					$this->usuario_actual = 0;
					$w = Willies::model()->findByAttributes(array('id_vpj' => $this->id));
					if($w != null){
						$w->paso_wf = "swWillies/cancelado";
						$w->save();
					}
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
	
	protected function afterSave(){
	  parent::afterSave();
		switch ($this->paso_wf) {
			case 'swVinculacionProveedorJuridico/verificar_vinculacion':
				$this->unirPolizas();
				break;
			default:
				break;
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

      if($email != "" and $this->usuario_actual != 0){
        if(false){

        }else{
          $html = '';
          Yii::app()->mailer->compraAsignada($email, $nombre_compra, $proximo, $id, $urlFin, $html);
        }
      }
    }

    public function urlMail(){
      $url = "/VinculacionProveedorJuridico/update";
      $parametro = 'id';
      $parametro_value = $this->id;
      if(in_array($this->paso_wf, array("swVinculacionProveedorJuridico/verificar_vinculacion", "swVinculacionProveedorJuridico/listo_para_contrato", "swVinculacionProveedorJuridico/ajustes_contrato", "swVinculacionProveedorJuridico/enviar_firmas"))){
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
	
	public function asignarAJuridico()
	{
		$au = AdministracionUsuario::model()->findbyAttributes(array('tipo_usuario' => "Juridico"));
		if($au != null){
			$this->usuario_actual = $au->id_usuario;
		}
	}
	public function willies(){
		$w = Willies::model()->findByAttributes(array('id_vpj' => $this->id));
		if($w == null){
			$willies = new Willies;
			$willies->id_orden = $this->id_orden;
			$willies->id_proveedor = $this->id_proveedor;
			$willies->id_vpj = $this->id;
			if(!$this->requierePolizas()){
				$willies->paso_wf = "swWillies/enviar_a_thomas";
			}else{
				$willies->paso_wf = "swWillies/ajustes_contrato";
			}
			$willies->save();
		}
	}
	
	public function unirPolizas(){
		$q = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $this->id));
		if($q == null){
			$d = new DocumentosVpj;
			$d->id_vpj = $this->id;
			$a = $this->dbConnection->createCommand("select * from orden_solicitud os inner join producto_orden po inner join cotizacion c on (c.producto_orden = po.id) on (po.orden_solicitud = os.id) where c.nit=".$this->id_proveedor." and c.elegido_comite=1 and po.orden = ".$this->id_orden.";")->queryAll();
			if(count($a) > 0){
				foreach($a as $b){
					if($b['requiere_acuerdo_servicios'] == 1 or $this->requierePoliza('acuerdo_servicios')){
						$d->requiere_acuerdo_servicios = 1;
					}
					if($b['requiere_polizas_cumplimiento'] == 1 or $this->requierePoliza('polizas_cumplimiento')){
						$d->requiere_polizas_cumplimiento = 1;
					}
					if($b['requiere_contrato'] == 1 or $this->requierePoliza('contrato')){
						$d->requiere_contrato = 1;
					}
					if($b['requiere_acuerdo_confidencialidad'] == 1 or $this->requierePoliza('acuerdo_confidencialidad')){
						$d->requiere_acuerdo_confidencialidad = 1;
					}
					if($b['requiere_seriedad_oferta'] == 1 or $this->requierePoliza('seriedad_oferta')){
						$d->requiere_seriedad_oferta = 1;
					}
					if($b['requiere_buen_manejo_anticipo'] == 1 or $this->requierePoliza('buen_manejo_anticipo')){
						$d->requiere_buen_manejo_anticipo = 1;
					}
					if($b['requiere_calidad_suministro'] == 1 or $this->requierePoliza('calidad_suministro')){
						$d->requiere_calidad_suministro = 1;
					}
					if($b['requiere_calidad_correcto_funcionamiento'] == 1 or $this->requierePoliza('calidad_correcto_funcionamiento')){
						$d->requiere_calidad_correcto_funcionamiento = 1;
					}
					if($b['requiere_pago_salario_prestaciones'] == 1 or $this->requierePoliza('pago_salario_prestaciones')){
						$d->requiere_pago_salario_prestaciones = 1;
					}
					if($b['requiere_estabilidad_oferta'] == 1 or $this->requierePoliza('estabilidad_oferta')){
						$d->requiere_estabilidad_oferta = 1;
					}
					if($b['requiere_calidad_obra'] == 1 or $this->requierePoliza('calidad_obra')){
						$d->requiere_calidad_obra = 1;
					}
					if($b['requiere_responsabilidad_civil_extracontractual'] == 1 or $this->requierePoliza('responsabilidad_civil_extracontractual')){
						$d->requiere_responsabilidad_civil_extracontractual = 1;
					}
				}
				$d->save();
			}
		}
	}
	
	public function requierePoliza($tipo){
		
		$a = $this->dbConnection->createCommand("select * from cotizacion c inner join producto_orden po on (c.producto_orden = po.id) where c.nit=".$this->id_proveedor." and c.elegido_comite=1 and po.orden = ".$this->id_orden.";")->queryAll();
		$total_pesos = 0;
		$salario_minimo = 566700;
		$salario_minimoq = SalarioMinimo::model()->findAllByAttributes(array(),array('order' => 'ano desc', 'limit' => 1));
		if(count($salario_minimoq) > 0){
			$s = $salario_minimoq[0];
			$salario_minimo = $s->salario;
		}
		foreach($a as $b){
			$total_pesos += $b['total_compra_pesos'];
		}
		if(($salario_minimo * 100) > $total_pesos){
			return false;
		}else{
			switch ($tipo) {
				case 'contrato':
					return true;
					break;
				case 'polizas_cumplimiento':
					return true;
					break;
				case 'buen_manejo_anticipo':
					return true;
					break;
				case 'estabilidad_oferta':
					if(($salario_minimo * 500) <= $total_pesos){
						return true;
					}
					break;
				default:
					break;
			}
			return false;
		}	
	}
	
	public function requiereContrato(){
		$dvpj = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $this->id));
		if($dvpj != null){
			if($dvpj->requiere_contrato == 1){
				return true;
			}
		}
		return false;
	}
	
	public function requierePolizaOAcuerdo(){
		$dvpj = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $this->id));
		if($dvpj != null){
			if($dvpj->requiere_acuerdo_servicios == 1){
				return true;
			}
			if($dvpj->requiere_polizas_cumplimiento == 1){
				return true;
			}
			if($dvpj->requiere_seriedad_oferta == 1){
				return true;
			}
			if($dvpj->requiere_buen_manejo_anticipo == 1){
				return true;
			}
			if($dvpj->requiere_calidad_suministro == 1){
				return true;
			}
			if($dvpj->requiere_calidad_correcto_funcionamiento == 1){
				return true;
			}
			if($dvpj->requiere_pago_salario_prestaciones == 1){
				return true;
			}
			if($dvpj->requiere_estabilidad_oferta == 1){
				return true;
			}
			if($dvpj->requiere_calidad_obra == 1){
				return true;
			}
			if($dvpj->requiere_responsabilidad_civil_extracontractual == 1){
				return true;
			}
		}
		return false;
	}
	
	public function requierePolizas(){
		$dvpj = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $this->id));
		if($dvpj != null){
			if($dvpj->requiere_polizas_cumplimiento == 1){
				return true;
			}
			if($dvpj->requiere_seriedad_oferta == 1){
				return true;
			}
			if($dvpj->requiere_buen_manejo_anticipo == 1){
				return true;
			}
			if($dvpj->requiere_calidad_suministro == 1){
				return true;
			}
			if($dvpj->requiere_calidad_correcto_funcionamiento == 1){
				return true;
			}
			if($dvpj->requiere_pago_salario_prestaciones == 1){
				return true;
			}
			if($dvpj->requiere_estabilidad_oferta == 1){
				return true;
			}
			if($dvpj->requiere_calidad_obra == 1){
				return true;
			}
			if($dvpj->requiere_responsabilidad_civil_extracontractual == 1){
				return true;
			}
		}
		return false;
	}
		
}