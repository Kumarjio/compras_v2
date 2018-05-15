<?php

/**
 * This is the model class for table 'documento_proveedor'.
 *
 * The followings are the available columns in table 'documento_proveedor':
 * @property integer $id_docpro
 * @property integer $proveedor
 * @property integer $tipo_documento
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $objeto
 * @property string $valor
 * @property string $fecha_firma
 * @property integer $tiempo_preaviso
 * @property integer $cuerpo_contrato
 * @property string $anexos
 * @property string $polizas
 * @property integer $tiempo_proroga
 * @property integer $area
 * @property integer $proroga_automatica
 * @property integer $consecutivo_contrato
 * @property integer $responsable_compras
 * @property integer $responsable_proveedor
 * @property string $motivo_terminacion
 * @property string $fecha_terminacion
 * @property string $nombre_contrato
 *
 * The followings are the available model relations:
 * @property Proveedor $proveedor0
 */
class DocumentoProveedor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DocumentoProveedor the static model class
	 */
         public $name_proveedor;
         public $archivo_cambio;
         public $id_poldoc;
		 public $fecha_fin_pol;
         public $tipopol;
         public $provaux;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'documento_proveedor';
	}

	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
					array('proveedor','required'),
                    array('proveedor, tipo_documento, tiempo_preaviso, cuerpo_contrato, tiempo_proroga, area, proroga_automatica, consecutivo_contrato, responsable_compras',  'numerical', 'integerOnly'=>true),
                    array('objeto, valor, estado, fecha_firma, anexos, polizas, motivo_terminacion, fecha_terminacion,user_insert,fecha_fin_ind, parte_del_contrato, moneda, nombre_contrato, id_poldoc, tipopol', 'safe'),
					array('fecha_inicio, fecha_fin,fecha_firma, fecha_terminacion,fecha_inicio_otrosi,fecha_fin_otrosi,fecha_recibido,fecha_alza', 'default','value'=>NULL),
					array('fecha_inicio, fecha_fin,fecha_firma, fecha_terminacion,fecha_inicio_otrosi,fecha_fin_otrosi,fecha_recibido,fecha_alza', 'date', 'format'=>'yyyy-mm-dd', 'on'=>'guardar_sin_enviar','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),
					array( 'valor,anexos, polizas,cuerpo_contrato','default','value'=>0),
                    /* oferta contrato */
                    array('objeto,responsable_compras,proroga_automatica,cuerpo_contrato,anexos,polizas,
                    id_gerencia, id_jefatura, responsable_proveedor,nombre_contrato,id_orden,oferta, oferta_mercantil, valor_indefinido', 'safe', 'on'=>'guardar_sin_enviar'),
                    array('objeto,responsable_compras,proroga_automatica,cuerpo_contrato,anexos,polizas,fecha_inicio,fecha_firma,
                    id_gerencia, id_jefatura, responsable_proveedor,nombre_contrato,tipo_documento', 'required', 'on'=>'oferta_contrato'),
                    array('valor','numerical','min'=>0, 'on'=>'oferta_contrato,guardar_sin_enviar'),
                    array('tiempo_pro_anio, tiempo_pro_mes, tiempo_pro_dia, tiempo_pre_anio, tiempo_pre_mes, tiempo_pre_dia,polizas,anexos,cuerpo_contrato','numerical','integerOnly'=>true,'on'=>'oferta_contrato,guardar_sin_enviar'),
                    array('fecha_inicio,fecha_fin,fecha_firma','date', 'format'=>'yyyy-mm-dd', 'on'=>'oferta_contrato','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),
                    array('id_orden,oferta, oferta_mercantil, valor_indefinido, terminar_cualquier_momento', 'safe', 'on'=>'oferta_contrato'),
                    /* Acuerdo de confidencialidad */
                    array('fecha_firma', 'required', 'on'=>'confidencialidad'),
                    array('fecha_firma', 'date', 'format'=>'yyyy-mm-dd','on'=>'confidencialidad','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),
                            // ------
                    array('nombre_contrato, objeto', 'required', 'on'=>'anexo'),
                    /* Carta de Aumento */
                    array('porc_incremento', 'numerical', 'integerOnly'=>false, 'min'=>0, 'max'=>100, 'on'=>'aumentoprecios,guardar_sin_enviar'),
                    array('fecha_recibido,fecha_alza', 'date', 'format'=>'yyyy-mm-dd', 'on'=>'aumentoprecios','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),
                    array('fecha_recibido,fecha_alza,porc_incremento', 'required', 'on'=>'aumentoprecios'),
                    // ------
                    array('motivo_terminacion,fecha_terminacion', 'required', 'on'=>'terminacion'),
                    array('fecha_terminacion', 'date', 'format'=>'yyyy-mm-dd', 'on'=>'terminacion','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),

                    array('fecha_aceptacion', 'required', 'on'=>'aceptacion'),
                    array('fecha_aceptacion',  'date', 'format'=>'yyyy-mm-dd', 'on'=>'aceptacion,guardar_sin_enviar','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),
                    array('objeto,responsable_compras,id_gerencia, id_jefatura, responsable_proveedor', 'required', 'on'=>'temporal'),
                    array('id_orden, name_proveedor', 'safe'),
                    array('tipo_documento', 'required', 'on'=>'adjunto'),
                    array('path_archivo', 'file','types'=>'jpg, jpeg, pdf', 'on'=>'adjunto'),
                    array('path_archivo', 'file','types'=>'jpg, jpeg, pdf', 'on'=>'adjunto_p'),
                    array('nombre_contrato,objeto', 'required', 'on'=>'otros'),
                    array('observacion_otrosi,fecha_firma', 'required', 'on'=>'otrosi'), //,fecha_inicio_otrosi,fecha_fin_otrosi
					array('fecha_fin_otrosi, fecha_fin_otrosi_ind', 'safe', 'on'=>'otrosi'),
                    array('fecha_inicio_otrosi,fecha_fin_otrosi,fecha_firma,fecha_fin', 'date','format'=>'yyyy-mm-dd', 'on'=>'otrosi','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),
//                  array('fecha_inicio, id_tipo_poliza', 'required', 'on'=>'poliza'),
//                  array('fecha_inicio, fecha_fin', 'date', 'format'=>'yyyy-mm-dd', 'on'=>'poliza','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),
					array('nombre_contrato', 'required', 'on'=>'propuesta'),
                    array('id_docpro, proveedor, provaux, tipo_documento, fecha_inicio, fecha_fin, objeto, valor, fecha_firma, tiempo_preaviso,
                    cuerpo_contrato, anexos, polizas, tiempo_proroga, area, proroga_automatica, consecutivo_contrato, responsable_compras,
                    responsable_proveedor, motivo_terminacion, fecha_terminacion, id_gerencia, id_jefatura, observacion_otrosi, valor_indefinido,
                    id_orden,nombre_contrato, name_proveedor', 'safe', 'on'=>'search'),
                    array('id_docpro, proveedor, provaux, tipo_documento, fecha_inicio, fecha_fin, objeto, valor, fecha_firma, tiempo_preaviso,
                    cuerpo_contrato, anexos, polizas, tiempo_proroga, area, proroga_automatica, consecutivo_contrato, responsable_compras,
                    responsable_proveedor, motivo_terminacion, fecha_terminacion, id_gerencia, id_jefatura, observacion_otrosi, valor_indefinido,
                    id_orden,nombre_contrato, id_poldoc, tipopol', 'safe', 'on'=>'search_detalle'),
                    array('id_docpro, proveedor, provaux, tipo_documento, fecha_inicio, fecha_fin, objeto, valor, fecha_firma, tiempo_preaviso,
                    cuerpo_contrato, anexos, polizas, tiempo_proroga, area, proroga_automatica, consecutivo_contrato, responsable_compras,
                    responsable_proveedor, motivo_terminacion, fecha_terminacion, id_gerencia, id_jefatura, observacion_otrosi, valor_indefinido,
                    id_orden,nombre_contrato', 'safe', 'on'=>'search_juridico'),
					array('id_docpro, proveedor, provaux, tipo_documento, fecha_inicio, fecha_fin, objeto, valor, fecha_firma, tiempo_preaviso,
                    cuerpo_contrato, anexos, polizas, tiempo_proroga, area, proroga_automatica, consecutivo_contrato, responsable_compras,
                    responsable_proveedor, motivo_terminacion, fecha_terminacion, id_gerencia, id_jefatura, observacion_otrosi, valor_indefinido,
                    id_orden,nombre_contrato', 'safe', 'on'=>'search_contratos'),
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
			'proveedor_rel' => array(self::BELONGS_TO, 'Proveedor', 'proveedor'),
			'tipo_documento_rel' => array(self::BELONGS_TO, 'TipoDocumentos', 'tipo_documento'),
			'responsable_compras_rel' => array(self::BELONGS_TO, 'DocumentoResponsableCompras', 'responsable_compras'),
			'tipo_poliza_rel' => array(self::BELONGS_TO, 'TipoPoliza', 'id_tipo_poliza'),
			'estado_rel' => array(self::BELONGS_TO, 'DocumentoProveedorEstado', 'estado'),
			'otrosProveedores' => array(self::HAS_MANY, 'DocumentoProveedorAdicional', 'id_docpro'),
			'jefatura' => array(self::BELONGS_TO, 'Jefaturas', 'id_jefatura'),
			'gerencia' => array(self::BELONGS_TO, 'Gerencias', 'id_gerencia'),
		);
	}

        public function conditionalValidations(){	

		if($this->valor > 0){
                    $this->validatorList->add(CValidator::createValidator('required', $this, 'moneda'));	
                }
	}
        
        protected function beforeValidate()
	{		
		$this->conditionalValidations();		
		return parent::beforeValidate();
	}
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_docpro' => 'Id Docpro',
			'proveedor' => 'Nit Proveedor',
			'provaux' => 'Nit Proveedor',
			'nombre_contrato'=>'Nombre',
			'tipo_documento' => 'Tipo Documento',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'objeto' => 'Objeto',
			'valor' => 'Valor',
			'fecha_firma' => 'Fecha Firma',
			'tiempo_preaviso' => 'Tiempo Preaviso Contrato',
			'cuerpo_contrato' => 'Cuerpo Contrato (No. Hojas)',
			'anexos' => 'No. de Anexos',
			'polizas' => 'No. de Pólizas',
			'tiempo_proroga' => 'Tiempo Prorroga Contrato',
			'area' => 'Área',
			'proroga_automatica' => 'Prorroga Automatica',
			'consecutivo_contrato' => 'Consecutivo Contrato',
			'responsable_compras' => 'Responsable Compras',
			'responsable_proveedor' => 'Responsable Proveedor',
			'motivo_terminacion' => 'Motivo Terminación',
			'fecha_terminacion' => 'Fecha Terminación',
			'path_archivo' => 'Documento',
			'id_jefatura' => 'Jefatura',
			'id_gerencia' => 'Gerencia',
			'id_orden' => 'Orden de Compra',
			'oferta_mercantil' => 'Oferta Mercantil',
			'tiempo_pro_anio' => 'Tiempo Prorroga Años',
			'tiempo_pro_mes' => 'Tiempo Prorroga Meses',
			'tiempo_pro_dia' => 'Tiempo Prorroga Días',
			'tiempo_pre_anio' => 'Tiempo Preaviso Años',
			'tiempo_pre_mes' => 'Tiempo Preaviso Meses',
			'tiempo_pre_dia' => 'Tiempo Preaviso Días',
			'porc_incremento' => 'Porcentaje de Incremento',
			'fecha_insert'=>'Fecha de Creación',
			'user_insert'=>'Usuario Ingresa',
			'observacion_otrosi'=>'Descripción de la Modificación',
			'fecha_inicio_otrosi'=>'Fecha Inicio Otrosi',
			'fecha_fin_otrosi'=>'Fecha Fin Otrosi',
			'id_tipo_poliza'=>'Tipo Póliza',
            'fecha_aceptacion' => 'Fecha Aceptación',
            'cancelado' => 'Estado Contrato',
			'proroga_automatica'=>'Prórroga Automática',
			'tiempo_proroga'=>'Tiempo de prórroga Contrato'
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

		$criteria->compare('id_docpro',$this->id_docpro);
		$criteria->compare('proveedor::text',$this->proveedor);
		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->addInCondition('estado',array(2,7,8));
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('estado::text',$this->estado,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('area',$this->area);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato::text',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_excel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->addInCondition('estado',array(1,2,7,8)); 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
            'keys'=>array()
		));
	}

	public function search_contratos($proveedor)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_docpro',$this->id_docpro);
		$criteria->compare('proveedor',$proveedor);
		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->addInCondition('estado',array(2));
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->compare('objeto',$this->objeto,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('area',$this->area);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_detalle($id_doc_pro_padre)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->select = array('t.*','pol.id_tipo_poliza AS tipopol','pol.id_poldoc','pol.fecha_fin as fecha_fin_pol');
		$criteria->join = 'LEFT JOIN poliza_documento AS pol ON pol.id_docpro = t.id_docpro ';

		$criteria->compare('id_doc_pro_padre',$id_doc_pro_padre);
		$criteria->compare('id_docpro',$this->id_docpro);
		$criteria->compare('proveedor',$this->proveedor);
		$criteria->compare('tipo_documento',$this->tipo_documento);
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->compare('objeto',$this->objeto,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma::date',$this->fecha_firma,true);
		$criteria->compare('t.tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato,true);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);

		//$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPolizas($id_doc_pro_padre) {
		$criteria=new CDbCriteria;
		$criteria->compare('id_doc_pro_padre',$id_doc_pro_padre);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
	public function search_gestion()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
		$this->proveedor = (intval($this->proveedor) == 0) ? '' : intval($this->proveedor);

		$criteria->compare('id_docpro',$this->id_docpro);
        if(!empty($this->proveedor))
           	$criteria->addCondition("id_docpro in (select id_docpro from documento_proveedor_adicional where proveedor = $this->proveedor) or proveedor = $this->proveedor");
        
        if($this->name_proveedor != ''){
            $criteria->addCondition("id_docpro in (select id_docpro from documento_proveedor_adicional where proveedor in (select nit from proveedor where UPPER(razon_social) like '%".  strtoupper($this->name_proveedor)."%')) or proveedor in (select nit from proveedor where UPPER(razon_social) like '%".  strtoupper($this->name_proveedor)."%')");
        }
		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->addInCondition('estado',array(0,3));
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('estado::text',$this->estado,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('area',$this->area);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_gestion_solicitados()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id_docpro',$this->id_docpro);
		$criteria->compare('proveedor::text',$this->provaux);
		$criteria->compare('proveedor',$this->proveedor);		
		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->addInCondition('estado',array(1));
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('area',$this->area);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_gestionJuridico()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$this->proveedor = (intval($this->proveedor) == 0) ? '' : intval($this->proveedor);

		$criteria->compare('id_docpro',$this->id_docpro);
        if(!empty($this->proveedor)){
            $criteria->addCondition("id_docpro in (select id_docpro from documento_proveedor_adicional where proveedor = $this->proveedor) or proveedor = $this->proveedor");
        }
        
        if($this->name_proveedor != ''){
            $criteria->addCondition("id_docpro in (select id_docpro from documento_proveedor_adicional where proveedor in (select nit from proveedor where UPPER(razon_social) like '%".  strtoupper($this->name_proveedor)."%')) or proveedor in (select nit from proveedor where UPPER(razon_social) like '%".  strtoupper($this->name_proveedor)."%')");
        }
		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->compare('estado',1);
		//$criteria->compare('fecha_inicio',$this->fecha_inicio);
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'LIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'LIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('area',$this->area);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato::text',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_finalizados()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$this->proveedor = (intval($this->proveedor) == 0) ? '' : intval($this->proveedor);

		$criteria->compare('id_docpro',$this->id_docpro);
        if(!empty($this->proveedor)){
            $criteria->addCondition("id_docpro in (select id_docpro from documento_proveedor_adicional where proveedor = $this->proveedor) or proveedor = $this->proveedor");
        }        
        if($this->name_proveedor != ''){
            $criteria->addCondition("id_docpro in (select id_docpro from documento_proveedor_adicional where proveedor in (select nit from proveedor where UPPER(razon_social) like '%".  strtoupper($this->name_proveedor)."%')) or proveedor in (select nit from proveedor where UPPER(razon_social) like '%".  strtoupper($this->name_proveedor)."%')");
        }
		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->addInCondition('estado',array(2,7,8));
		$criteria->addCondition('id_docpro in ( select id_docpro from (select id_docpro, user_insert from documento_proveedor_trazabilidad where user_insert=\''.Yii::app()->user->id.'\' group by id_docpro, user_insert ) as t1)');
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('estado::text',$this->estado,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('area',$this->area);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato::text',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchEliminados(){

		$criteria=new CDbCriteria;

		$criteria->compare('id_docpro',$this->id_docpro);
		$criteria->compare('proveedor::text',$this->proveedor);
		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->addInCondition('estado',array(4));
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('estado::text',$this->estado,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('area',$this->area);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato::text',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_informe(){

		$criteria = new CDbCriteria;

		$sql = "SELECT doc.id_docpro FROM documento_proveedor AS doc WHERE doc.estado = '2' AND doc.tipo_documento IN ('1','2')";
		$contratos = Yii::app()->db->createCommand($sql)->queryAll();
		$ids = array();
		$fecha = date('Y-m-j');
		$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

		foreach ($contratos as $con){
			
			$suma_fecha = $this->calculaFechaFin($con['id_docpro']);

			if( !empty($suma_fecha) ){
				$fechafin = $suma_fecha;

				if($fechafin >= $fecha && $fechafin <= $nuevafecha)
					$ids[] = $con['id_docpro'];

			}
		}

		$criteria->addInCondition('id_docpro',$ids);
		//$criteria->compare('id_docpro',$this->id_docpro);
		$criteria->compare('proveedor::text',$this->proveedor);
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('estado::text',$this->estado,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato::text',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.id_docpro ASC'),
		));
	}

	public function search_informe_preaviso(){

		$criteria = new CDbCriteria;

		$sql = "SELECT doc.id_docpro FROM documento_proveedor AS doc WHERE doc.estado = '2' AND doc.tipo_documento IN ('1','2')";
		$contratos = Yii::app()->db->createCommand($sql)->queryAll();
		$ids = array();
		$fecha = date('Y-m-j');
		$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

		foreach ($contratos as $con){
			
			$suma_fecha = $this->calculaFechaFin($con['id_docpro'], true);
			if( !empty($suma_fecha) ){
				$fechafin = $suma_fecha;

				if($fechafin >= $fecha && $fechafin <= $nuevafecha)
					$ids[] = $con['id_docpro'];
			}
		}

		$criteria->addInCondition('id_docpro',$ids);
		//$criteria->compare('id_docpro',$this->id_docpro);
		$criteria->compare('proveedor::text',$this->proveedor);
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('estado::text',$this->estado,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato::text',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.id_docpro ASC'),
		));
	}

	public function behaviors(){
		return array(
			'EdicionBehavior'=>array(
               	'class' => 'application.components.behavior.EdicionBehavior',
           	),
		);
	}

	public function getOrdenesCompra($proveedor){
		$query = Yii::app()->db->createCommand("select distinct o.id as id_orden, o.id || ' - '||o.nombre_compra ||' - '||o.fecha_solicitud::date as dato from cotizacion as c inner join producto_orden as po on po.id= c.producto_orden inner join orden as o on o.id=po.orden  where c.nit= '$proveedor' and o.paso_wf <>'swOrden/cancelada' order by o.id desc;")->queryAll();
		return CHtml::listData($query, 'id_orden', 'dato');
	}

	public function getOrdenesCompra2(){
		$query = Yii::app()->db->createCommand(
                    "select distinct oc.id as id_orden, oc.id || ' - '||o.nombre_compra ||' - '||o.fecha_solicitud::date as dato 
                            from cotizacion as c 
                            inner join producto_orden as po on po.id= c.producto_orden 
                            inner join orden as o on o.id=po.orden 
                            inner join orden_compra oc on oc.id_orden=o.id
                    where o.paso_wf <>'swOrden/cancelada' order by oc.id desc;")->queryAll();
		return CHtml::listData($query, 'id_orden', 'dato');
	}

	public static function traerNombreProveedor($nit){
		$model= new Proveedor();
		$model=$model->find('nit=:n',array(':n'=>$nit));
		return $model->razon_social." - ".$nit;
	}

	public function traeEstadoContrato($id){
		$contrato = DocumentoProveedor::model()->findByPk($id);
		return $contrato->estado;
	}

	public function traeEstado($id){
		$contrato = DocumentoProveedor::model()->findByPk($id);
		return $contrato->estado_rel->estado;
	}

	public function traeResponsable($id){
		$contrato = DocumentoProveedor::model()->findByPk($id);
		return $contrato->responsable_compras_rel->responsable_compras;
	}

	public function traerRazonsocial(){
                $model= new Proveedor();
                $model=$model->find('nit=:n',array(':n'=>$this->proveedor));
                if(count($this->otrosProveedores)){
                    $texto = '<ul>';
                    $texto .= '<li><strong>'.$model->razon_social.'</strong></li>';
                    foreach ($this->otrosProveedores as $prov) {
                        $texto .= '<li>'.$prov->idProveedor->razon_social.'</li>';
                    }
                    return $texto.'</ul>';
                }
                else{
                    return $model->razon_social;
                }
	}

	public function traerNits(){
                $model= new Proveedor();
                $model=$model->find('nit=:n',array(':n'=>$this->proveedor));
                if(count($this->otrosProveedores)){
                    $texto = '<ul>';
                    $texto .= '<li><strong>'.$model->nit.'</strong></li>';
                    foreach ($this->otrosProveedores as $prov) {
                        $texto .= '<li>'.$prov->idProveedor->nit.'</li>';
                    }
                    return $texto.'</ul>';
                }
                else{
                    return $model->nit;
                }
	}

	public static function numDocs($id_doc_pro_padre){
		$model= new DocumentoProveedor();
		return $model=$model->count('id_doc_pro_padre=:p',array(':p'=>$id_doc_pro_padre));
	}

	public static function traerTipoDocumento($id_doc_pro_padre){
		$model=DocumentoProveedor::model()->findByPk($id_doc_pro_padre);
		return $model[tipo_documento];
	}
	
	public function filtroProveedorSolicitados(){
		return CHtml::listData(Yii::app()->db->createCommand("select proveedor, razon_social  from (select proveedor from documento_proveedor where tipo_documento in (1,2,5) and estado in (1) group by proveedor) as t1 inner join proveedor on nit=t1.proveedor order by razon_social ")->queryAll(),'proveedor','razon_social');
	}
	
	public function filtroProveedorGestion(){
		return CHtml::listData(Yii::app()->db->createCommand("select proveedor, razon_social  from (select proveedor from documento_proveedor where tipo_documento in (1,2,5) and estado in (0,3) group by proveedor) as t1 inner join proveedor on nit=t1.proveedor order by razon_social")->queryAll(),'proveedor','razon_social');
	}
	
	public function filtroProveedorGestionJuridico(){
		return CHtml::listData(Yii::app()->db->createCommand("select proveedor, razon_social  from (select proveedor from documento_proveedor where tipo_documento in (1,2,5) and estado in (1) group by proveedor) as t1 inner join proveedor on nit=t1.proveedor order by razon_social")->queryAll(),'proveedor','razon_social');
	}
	
	public function filtroProveedorGestionFinalizados(){
		return CHtml::listData(Yii::app()->db->createCommand("select proveedor, razon_social  from (select proveedor from documento_proveedor where tipo_documento in (1,2,5) and estado in (2) group by proveedor) as t1 inner join proveedor on nit=t1.proveedor order by razon_social")->queryAll(),'proveedor','razon_social');
	}

	public function getNombreDoc($poliza){

		if($this->tipo_documento == '8')
			$nomDoc = TipoPoliza::model()->findByPk($poliza)->tipo_poliza;
		else
			$nomDoc = $this->nombre_contrato;

		return $nomDoc;
	}

	public function calculaFechaFin($id_doc, $pre = false){

		$sql = "SELECT doc.id_docpro, doc.fecha_fin, doc.proroga_automatica , doc.tiempo_proroga, doc.tiempo_preaviso,
					(SELECT fecha_fin FROM documento_proveedor 
						WHERE id_doc_pro_padre = doc.id_docpro AND tipo_documento = '6' 
				        AND (fecha_fin IS NOT NULL OR proroga_automatica > 0 OR tiempo_proroga > 0 OR tiempo_preaviso > 0)
						ORDER BY id_docpro DESC LIMIT 1) AS fecha_o,
				    (SELECT proroga_automatica FROM documento_proveedor 
						WHERE id_doc_pro_padre = doc.id_docpro AND tipo_documento = '6' 
				        AND (fecha_fin IS NOT NULL OR proroga_automatica > 0 OR tiempo_proroga > 0 OR tiempo_preaviso > 0)
						ORDER BY id_docpro DESC LIMIT 1) AS prorro,
				    (SELECT tiempo_proroga FROM documento_proveedor 
						WHERE id_doc_pro_padre = doc.id_docpro AND tipo_documento = '6' 
				        AND (fecha_fin IS NOT NULL OR proroga_automatica > 0 OR tiempo_proroga > 0 OR tiempo_preaviso > 0)
						ORDER BY id_docpro DESC LIMIT 1) AS tiempo,
					(SELECT tiempo_preaviso FROM documento_proveedor 
						WHERE id_doc_pro_padre = doc.id_docpro AND tipo_documento = '6' 
				        AND (fecha_fin IS NOT NULL OR proroga_automatica > 0 OR tiempo_proroga > 0 OR tiempo_preaviso > 0)
						ORDER BY id_docpro DESC LIMIT 1) AS tiempopre
				FROM documento_proveedor AS doc
				WHERE doc.estado = '2' 
				AND doc.tipo_documento IN ('1','2')
				AND doc.id_docpro = '".$id_doc."'";

		$con = Yii::app()->db->createCommand($sql)->queryRow();

		$suma_fecha = "";
		if(!empty($con['fecha_o']) || !empty($con['prorro']) || !empty($con['tiempo']) || !empty($con['tiempopre'])){

			if( $con['prorro'] != "3"){
				//Valida fecha otrosi
				if( !empty($con['fecha_o']) ){
					if($con['prorro'] == "1"){
						if( !empty($con['tiempo']) )
							$suma_fecha = date("Y-m-d", strtotime('+'.$con['tiempo'].' day', strtotime($con['fecha_o']) ) ); 
						else
							$suma_fecha = $con['fecha_o'];
					}else{
						$suma_fecha = $con['fecha_o'];
					}
				}else{
					if($con['prorro'] == "1"){
						if( !empty($con['tiempo']) )
							$suma_fecha = date("Y-m-d", strtotime('+'.$con['tiempo'].' day', strtotime($con['fecha_fin']) ) ); 
						else
							$suma_fecha = $con['fecha_fin'];
					}else{
						$suma_fecha = $con['fecha_fin'];
					}							
				}
				if( !empty($con['tiempopre']) ){
					if($pre)
						$suma_fecha = date("Y-m-d", strtotime('-'.$con['tiempopre'].' day', strtotime($suma_fecha)));
					else
						$suma_fecha = "";
				}else{
					if($pre)
						$suma_fecha = "";
				}
			}
		}else{
			if( $con['proroga_automatica'] != "3"){
				//Valida fecha final
				if( !empty($con['fecha_fin']) ){
					if($con['proroga_automatica'] == "1"){
						if( !empty($con['tiempo_proroga']) )
							$suma_fecha = date("Y-m-d", strtotime('+'.$con['tiempo_proroga'].' day', strtotime($con['fecha_fin']) ) ); 
						else
							$suma_fecha = $con['fecha_fin'];
					}else{
						$suma_fecha = $con['fecha_fin'];
					}		
					if( !empty($con['tiempo_preaviso']) ){
						if($pre)
							$suma_fecha = date("Y-m-d", strtotime('-'.$con['tiempo_preaviso'].' day', strtotime($suma_fecha)));
						else
							$suma_fecha = "";
					}else{
						if($pre)
							$suma_fecha = "";
					}					
				}
			}
		}

		return $suma_fecha;
	}

	public function search_area()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if(Yii::app()->user->getState('gerente')){
			$criteria->compare('id_gerencia',$empleado->contratoses[0]->idCargo->id_gerencia);
		}
		elseif (Yii::app()->user->getState('jefe')) {
			$criteria->compare('id_jefatura',$empleado->contratoses[0]->idCargo->id_jefatura);
		}

		$this->proveedor = (intval($this->proveedor) == 0) ? '' : intval($this->proveedor);

		$criteria->compare('id_docpro',$this->id_docpro);
        if(!empty($this->proveedor)){
            $criteria->addCondition("id_docpro in (select id_docpro from documento_proveedor_adicional where proveedor = $this->proveedor) or proveedor = $this->proveedor");
        }
        
        if($this->name_proveedor != ''){
            $criteria->addCondition("id_docpro in (select id_docpro from documento_proveedor_adicional where proveedor in (select nit from proveedor where UPPER(razon_social) like '%".  strtoupper($this->name_proveedor)."%')) or proveedor in (select nit from proveedor where UPPER(razon_social) like '%".  strtoupper($this->name_proveedor)."%')");
        }
		$criteria->addInCondition('tipo_documento',array(1,2,5));
		$criteria->compare('estado',1);
		//$criteria->compare('fecha_inicio',$this->fecha_inicio);
		$criteria->addSearchCondition('fecha_inicio::text', $this->fecha_inicio, true, 'AND', 'LIKE');
		$criteria->addSearchCondition('fecha_fin::text', $this->fecha_fin, true, 'AND', 'LIKE');
		$criteria->addSearchCondition('nombre_contrato', $this->nombre_contrato, true, 'AND', 'ILIKE');
		$criteria->addSearchCondition('objeto',$this->objeto,true, 'AND', 'ILIKE');
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('fecha_firma',$this->fecha_firma,true);
		$criteria->compare('tiempo_preaviso',$this->tiempo_preaviso);
		$criteria->compare('cuerpo_contrato',$this->cuerpo_contrato);
		$criteria->compare('anexos',$this->anexos,true);
		$criteria->compare('polizas',$this->polizas,true);
		$criteria->compare('tiempo_proroga',$this->tiempo_proroga);
		$criteria->compare('area',$this->area);
		$criteria->compare('proroga_automatica',$this->proroga_automatica);
		$criteria->compare('consecutivo_contrato::text',$this->consecutivo_contrato);
		$criteria->compare('responsable_compras',$this->responsable_compras);
		$criteria->compare('responsable_proveedor',$this->responsable_proveedor);
		$criteria->compare('motivo_terminacion',$this->motivo_terminacion,true);
		$criteria->compare('fecha_terminacion',$this->fecha_terminacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
