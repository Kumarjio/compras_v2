<?php

/**
 * This is the model class for table "facturas".
 *
 * The followings are the available columns in table 'facturas':
 * @property integer $id_factura
 * @property integer $id_orden
 * @property integer $nit_proveedor
 * @property integer $cant_productos
 * @property string $valor_productos
 * @property string $rte_fte
 * @property string $valor_rte_fte
 * @property string $rte_iva
 * @property string $valor_rte_iva
 * @property string $rte_ica
 * @property string $valor_rte_ica
 * @property string $rte_timbre
 * @property string $valor_rte_timbre
 * @property integer $id_centro_costos
 * @property integer $nro_pagos
 * @property integer $cuenta_x_pagar
 * @property integer $id_cuenta_contable
 * @property integer $analista_encargado
 * @property string $fecha_vencimiento
 * @property string $fecha_factura
 * @property string $fecha_recibido
 * @property string $path_imagen
 * @property string $paso_wf
 * @property integer $usuario_actual
 * @property integer $id_usuario_reemplazado
 * @property string $creacion
 * @property string $actualizacion
 *
 * The followings are the available model relations:
 * @property IvaFacturas[] $ivaFacturases
 * @property Proveedor $nitProveedor
 * @property CuentaContable $idCuentaContable
 */

Yii::import('application.extensions.SWebServiceFacturacion');
class Facturas extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Facturas the static model class
     */
    public $observacion;
        public $nombre_ctaxp;
        public $paso_actual;
        public $_aya;
        public $fake;
        public $nombre_analista;
        public $razon_social;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'facturacion.facturas';
    }
        
        public function behaviors()
        {
            return array(
                'swBehavior'=>array(
                    'class' => 'application.extensions.simpleWorkflow.SWActiveRecordBehavior'
                ),

                'ActiveRecordLogableBehavior'=>array(
                    'class' => 'application.components.behavior.ActiveRecordLogableBehavior',
                ),

                'WorkflowTrazabilidad'=>array(
                    'class' => 'application.components.behavior.WorkflowTrazabilidad',
                ),

                'WorkflowObservaciones'=>array(
                    'class' => 'application.components.behavior.WorkflowObservaciones',
                ),

            );
        }
    /**
     * @return array validation rules for model attributes.
     */
        
        protected function beforeValidate()
    {       
        
            if($this->analista_encargado != ""){
                $this->nombre_analista = Empleados::model()->findByPk($this->analista_encargado)->nombre_completo;
            }
            $factura = $this->findByPk($this->id_factura);
            $this->paso_actual = $factura->paso_wf;
            $this->cant_productos = (empty($this->cant_productos))? null : $this->cant_productos;
            $this->valor_productos = (empty($this->valor_productos))? null : str_replace(',', '', $this->valor_productos);
            $this->cant_productos = (empty($this->cant_productos))? null : $this->cant_productos;   
            $this->fecha_vencimiento = (empty($this->fecha_vencimiento))? null : $this->fecha_vencimiento;
            $this->fecha_factura = (empty($this->fecha_factura))? null : $this->fecha_factura; 

            return parent::beforeValidate();
    }
        
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('paso_wf', 'SWValidator','enableSwValidation'=>true, 'match'=>true),
                        array('nit_proveedor, tipo_identificacion','required','on'=>array('insert')),
                        array('nit_proveedor','numerical', 'integerOnly'=>true,'on'=>array('insert')),
                        array('nit_proveedor','findProveedor','on'=>array('insert')),
                        array('path_imagen','file', 'types'=>'pdf, jpg, jpeg','on'=>array('insert')),
                        array('fuente, agencia, descripcion_lote,fecha_limite_pago','required','on'=>array('sw:/.*_generacion_lote/') ),
                        array('fecha_limite_pago,fecha_efectiva,fecha_proceso', 'type', 'type' => 'date', 'message' => '{attribute} no es una fecha valida', 'dateFormat' => 'yyyyMMdd','on'=>array('sw:/.*_generacion_lote/')),
                        
                        array('fecha_proceso','validarFechas','on'=>array('sw:/.*_generacion_lote/') ),
                        array('fake','validarCcyAgencia','on'=>array('sw:/.*_generacion_lote/', 'sw:/.*_modificar_registros_tipificada/') ),
                        array('fake','validarValores','on'=>array('sw:/.*_generacion_lote/', 'sw:/.*_modificar_registros_tipificada/') ),
                        array('nombre_analista,fecha_vencimiento, fecha_factura,nro_factura','required','on'=>array('sw:/.*_revisionanalista/') ),
                        array('valor_productos','required','on'=>array('sw:/.*_enviar_fra/') ),
                        array('valor_productos','required','on'=>array('sw:/.*_aprobar_jefe/') ),
                        array('fake','valoresCentros','on'=>array('sw:/.*_aprobar_jefe/','sw:/.*_enviar_fra/','sw:/.*_generacion_lote/') ),
                        array('fake','validarCuentas','on'=>array('sw:/.*_aprobar_jefe/') ),
                        array('fake','necesitaModificacion','on'=>array('sw:/.*_jefatura/') ),
                        array('valor_productos', 'numerical', 'integerOnly'=>false, 'min'=>1 ),
                        array('observacion','required','on'=>array('sw:/.*_devolver_indexacion/','sw:/.*_devolver_revision_analista/','sw:/.*_devolver_aprobar_jefe/','sw:/.*_devolver_causacion/')),
                        array('cant_productos,valor_productos','numerical','min'=>1,'on'=>'update'),
            array('id_orden, cant_productos, analista_encargado, usuario_actual, id_usuario_reemplazado', 'numerical', 'integerOnly'=>true),
            array('valor_productos, fecha_vencimiento, fecha_factura, fecha_recibido, path_imagen, paso_wf, creacion, actualizacion, nro_factura, observacion, usuario_actual,fuente, agencia, descripcion_lote,fecha_limite_pago,fecha_efectiva,fecha_proceso,parametro, fake, lote, vr_codigo_cuentas,tipo_consulta,nombre_analista, cuenta_x_pagar, fecha_pago, valor_pagado, username, razon_social', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_factura, id_orden, nit_proveedor, cant_productos, valor_productos, analista_encargado, fecha_vencimiento, fecha_factura, fecha_recibido, path_imagen, paso_wf, usuario_actual, id_usuario_reemplazado, creacion, actualizacion, lote, vr_codigo_cuentas,tipo_consulta, cuenta_x_pagar, fecha_pago, valor_pagado, username, razon_social', 'safe', 'on'=>'search'),
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
            'ivaFacturases' => array(self::HAS_MANY, 'IvaFacturas', 'id_factura'),
            'nitProveedor' => array(self::BELONGS_TO, 'Proveedor', 'nit_proveedor'),
            'idOrden' => array(self::BELONGS_TO, 'OrdenCompra', 'id_orden'),
            'idCuentaContable' => array(self::BELONGS_TO, 'CuentaContable', 'id_cuenta_contable'),
            'centroCostos' => array(self::HAS_MANY, 'CentroCostosFacturas', 'id_factura'),
            'usuarioActual' => array(self::BELONGS_TO, 'Empleados', 'usuario_actual'),
            'observacionesCount'=>array(self::STAT, 'ObservacionesWfs', 'idmodel'),
            'cuentasFacturas' => array(self::HAS_MANY, 'CuentasFacturas', 'id_factura'),
            'tipificadaFras' =>array(self::HAS_MANY, 'TipificadasFacturas', 'id_factura', 'order'=>'codigo_tipificada, consecutivo_valor') ,
            'responsable' => array(self::BELONGS_TO, 'Empleados', 'analista_encargado'),                
        );
    }

    public function agregarValidacionesAdicionales() {
        
            $this->validatorList->add(CValidator::createValidator('generarLote', $this, 'fake', array('on' =>array('sw:/devolver_enviar_fra_generacion_lote/', 'sw:/enviar_fra_generacion_lote/'))));
            $this->validatorList->add(CValidator::createValidator('modificarLote', $this, 'fake', array('on' =>array('sw:/.*_modificar_registros_tipificada/'))));
            $this->validatorList->add(CValidator::createValidator('modificarFecha', $this, 'fake', array('on' =>array('sw:/.*_modificar_fecha_normal/','sw:/.*_modificar_todas_fechas/'))));    
            $this->validatorList->add(CValidator::createValidator('eliminarLote', $this, 'fake', array('on' =>array('sw:/.*_eliminacion_lote/'))));     
            $this->validatorList->add(CValidator::createValidator('cuentasTipificadas', $this, 'fake', array('on' =>array('sw:/.*_enviar_fra/'))));         
            $this->validatorList->add(CValidator::createValidator('aprobarLote', $this, 'fake', array('on' =>array('sw:/.*_aprobada/'))));  
        }
        
        public function validarCcyAgencia() {
            $tipificadas = TipificadasFacturas::model()->findAllByAttributes(array('id_factura'=>  $this->id_factura));
            foreach ($tipificadas as $t) {
                if($t->valor*1 >0){
                    if($t->centro_costos =='' || $t->agencia == ''){
                        $this->addError("fake", "Tiene registros con valor sin selecionar Centro de Costos o Agencia.");
                        break;
                    }
                }
            }
        }
        
        public function necesitaModificacion() {
            $count_tipi = TipificadasFacturas::model()->countByAttributes(array('id_factura'=>  $this->id_factura, 'tipo_consulta'=>1),' valor is not null');
            $count_tmp = TmpTipificadas::model()->countByAttributes(array('id_factura'=>  $this->id_factura));
            if($count_tmp == $count_tipi){
                $tipi = TipificadasFacturas::model()->findAllByAttributes(array('id_factura'=>  $this->id_factura, 'tipo_consulta'=>1),' valor is not null');
                foreach ($tipi as $t) {
                    $tmp = TmpTipificadas::model()->findByAttributes(array('id_tipificada'=>$t->id_tipificadas_facturas));
                    if($tmp->valor != $t->valor){
                        $this->addError("fake", "Se modificaron algunos valores por favor enviar a Modificar Registros Tipificada.");
                    }
                }
            }
            else {
                $this->addError("fake", "Primero debe enviar a Modificar Registros Tipificada.");
            }
        }
        
        public function validarCuentas() {
            $cuentas = CuentasFacturas::model()->findAllByAttributes(array('id_factura'=>  $this->id_factura));
            if(!$cuentas){
                $this->addError("fake", "Por favor ingrese al menos una cuenta contable.");
            }
            $costos = CentroCostosFacturas::model()->findAllByAttributes(array('id_factura'=>  $this->id_factura));
            if(!$costos){
                $this->addError("fake", "Por favor ingrese al menos un centro de costos.");
            }
            
        }
        public function validarValores() {
            $tipificadas = TipificadasFacturas::model()->findAllByAttributes(array('id_factura'=>  $this->id_factura),'valor is not null');
            foreach ($tipificadas as $t) {
                if($t->valor*1 >0){
                    $valor += str_replace(",", "", $t->valor)*1; 
                }
            }
            if($this->valor_productos*1 != $valor){
                $this->addError("fake", "La suma de los valores en las tipificadas debe ser igual a ".$this->getAttributeLabel('valor_productos').".");
            }
        }
        
        public function valoresCentros() {
            $centros = CentroCostosFacturas::model()->findAllByAttributes(array('id_factura'=>  $this->id_factura));
            foreach ($centros as $t) {
                if($t->valor*1 >0){
                    $valor += str_replace(",", "", $t->valor)*1; 
                }
                else{
                    $this->addError("fake", "Por favor indique un valor para cada Centro de Costos.");
                    return;
                }
            }
            if($this->valor_productos*1 != $valor){
                $this->addError("fake", "La suma de los valores en los Centros de Costos debe ser igual a ".$this->getAttributeLabel('valor_productos').".");
            }
        }
        
        public function validarFechas(){
            if ($this->parametro == 1){
                if ($this->fecha_proceso == ''){
                    $this->addError("fecha_proceso", $this->getAttributeLabel('fecha_proceso')." no puede ser nulo.");
                }
                else {
                    $fecha = date('Ymd');
                    if($this->fecha_proceso > $fecha ){
                        $this->addError("fecha_proceso", $this->getAttributeLabel('fecha_proceso')." no puede ser posterior a hoy.");
                    }
                }
                if ($this->fecha_efectiva == ''){
                    $this->addError("fecha_efectiva", $this->getAttributeLabel('fecha_efectiva')." no puede ser nulo.");
                }
                else {
                    $fecha = date('Ymd');
                    if($this->fecha_efectiva > $fecha ){
                        $this->addError("fecha_efectiva", $this->getAttributeLabel('fecha_efectiva')." no puede ser posterior a hoy.");
                    }
                }
            }
            else {
                if ($this->fecha_efectiva == '')
                    $this->fecha_efectiva = date('Ymd');
                if ($this->fecha_proceso == '')
                    $this->fecha_proceso = date('Ymd'); 
            }
            
            if ($this->fecha_limite_pago == ''){
                $this->addError("fecha_limite_pago", $this->getAttributeLabel('fecha_limite_pago')." no puede ser nulo.");
            }
            else {
                $fecha = date('Ymd');
                if($this->fecha_limite_pago < $fecha ){
                    $this->addError("fecha_limite_pago", $this->getAttributeLabel('fecha_limite_pago')." no puede ser inferior a hoy.");
                }
            }
            
        }
        
        public function findProveedor(){
            if ($this->tipo_identificacion != '' && $this->nit_proveedor != ''){
                if($this->nit_proveedor <= 2147483647 and is_numeric($this->nit_proveedor)){
                    
                    $proveedor = Proveedor::model()->findByAttributes(array('nit'=>  $this->nit_proveedor));
                    if (!$proveedor){
                        $this->_aya = new SWebServiceFacturacion;
                        $respuesta = $this->_aya->consultaCentrales($this->tipo_identificacion, $this->nit_proveedor);
                        if ($respuesta) {
                            if ($respuesta['Indicador1ArchivodeCliente'] == '1') {
                                $proveedor = new Proveedor;
                                $proveedor->nit = $respuesta['NumeroDeIdentificacion'];
                                $proveedor->razon_social = $respuesta['NombreoRazonSocial'];
                                $proveedor->save();
                            }
                            else if(isset($respuesta['errores'])){
                                foreach ($respuesta['errores'] as $value) {
                                    $this->addError('fake', $value);
                                }
                            }  
                            else {
                                $this->addError("nit_proveedor", $this->getAttributeLabel('nit_proveedor')." No existe en imagine ni en As400.");                        
                            }
                        }
                        else {
                            $this->addError('fake', 'El servicio con AS400 no responde');
                        }
                    }
                }
                else {
                    $this->addError("nit_proveedor", $this->getAttributeLabel('nit_proveedor')." por favor digite un número valido.");
                }    
            }
        }
        
//        public function valorFactura() {
//            $valor = $this->valor_productos * 1;
//            if($this->valor_productos = 0 ){
//                $detalle = DetalleOrdenCompra::model()->findAllByAttributes(array('id_orden_compra' => $model->id_orden));
//                foreach ($detalle as $do) {
//                    $total += ($do->cotizacion->valor_unitario * $do->cantidad * $do->cotizacion->trm);
//                }
//                if($this->valor_productos > $total){
//                    $this->addError("valor_productos", $this->getAttributeLabel('valor_productos')." no debe superar el valor total de la Orden de Compra.");
//                }
//            }
//        }
        
    public function attributeLabels()
    {
        return array(
            'id_factura' => 'Id Factura',
            'id_orden' => 'Id Orden',
            'nit_proveedor' => 'Nit Proveedor',
            'cant_productos' => 'Cant Productos',
            'valor_productos' => 'Valor Productos',
            'id_centro_costos' => 'Centro Costos',
            'nro_pagos' => 'Nro Pagos',
            'cuenta_x_pagar' => 'Cuenta X Pagar',
            'id_cuenta_contable' => 'Id Cuenta Contable',
            'analista_encargado' => 'Responsable',
            'fecha_vencimiento' => 'Fecha Vencimiento',
            'fecha_factura' => 'Fecha Factura',
            'fecha_recibido' => 'Fecha Recibido',
            'path_imagen' => 'Imagen',
            'paso_wf' => 'Estado',
            'usuario_actual' => 'Usuario Actual',
            'id_usuario_reemplazado' => 'Id Usuario Reemplazado',
            'creacion' => 'Creacion',
            'actualizacion' => 'Actualizacion',
                        'nro_factura' => 'Número de Factura',
                        'nombre_ctaxp'=> 'Cuenta por Pagar',
                        'vr_codigo_cuentas'=>'Valor Calculado',
                        'nombre_analista'=>'Responsable',
                        'cuenta_x_pagar'=>'Cuenta Por Pagar',
                        'tipo_identificacion'=>'Tipo Identificación',
                        'observacion'=>'Observación',
                        'descripcion_lote'=>'Descripción Lote',
                        'fecha_limite_pago'=>'Fecha Límite Pago',
                        'parametro'=>'Parámetro'
        );
    }
        
        public function tieneOrden() {
            $ordenes = OrdenesFactura::model()->findAllByAttributes(array('id_factura'=>$this->id_factura));
            if($ordenes){
                return true;
            }
            else {
                return false;
            }
        }
    
        protected function afterSave(){
            parent::afterSave();
//            if($this->paso_wf == 'swFacturas/enviar_fra'){
//                
//                if($this->paso_actual != $this->paso_wf){
//                    $cuentas = array();
//                    foreach ($this->cuentasFacturas as $value) {
//                        array_push($cuentas, $value->idCuentaContable->codigo);
//                    }
//                    $this->cuentasTipificadas($cuentas);
//                }
//                
//                
//            }
            $this->enviarEmail();
            return true;
        }
        
        public function beforeSave() {
            $factura = $this->findByPk($this->id_factura);
            $this->paso_actual = $factura->paso_wf;
            parent::beforeSave();
            return true;
        }
        
    public function enviarEmail(){
            if(($this->paso_wf != "swFacturas/indexacion" && $this->paso_wf != "swFacturas/recepcion_documento" && $this->paso_wf != "" && $this->paso_actual != $this->paso_wf)){
                
                    $this->sendEmail($this->id_factura);    
        }
    }
        
        public function proximoPaso($id_paso){
          $estados = SWHelper::allStatuslistData($this);
          $proximo = $estados[$id_paso];
          return $proximo;
        }

        public function urlMail($id = false){
            $url = "/facturacion/factura/update";
            $parametro = 'id'; 
            if($id){
                $urlFin = "http://".$_SERVER['HTTP_HOST']."/index.php".$url."/".$parametro."/".$id;
            }else{
                $urlFin = "http://".$_SERVER['HTTP_HOST']."/index.php".$url."/".$parametro."/".$this->id_factura;
            }
            return $urlFin;
          }

        protected function sendEmail($id){
            $estados = SWHelper::allStatuslistData($this);
            $proximo = $this->proximoPaso($this->paso_wf);
            $empleado = Empleados::model()->findByPk($this->usuario_actual);
            $email = $empleado->email;

            $urlFin = $this->urlMail();

            if($email != ""){
                $html = Yii::app()->controller->renderPartial("emailview", array('factura'=>$this),true);
                Yii::app()->mailer->facturaAsignada($email, $this->nro_factura, $proximo, $urlFin, $html);
                
            }

        }

    public function search($paso = null)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
                switch ($paso) {
                    case 'causacion':
                        $criteria->addInCondition('paso_wf', array('swFacturas/causacion','swFacturas/devolver_causacion'));
                        break;
                    case 'tipificadas':
                        $criteria->addInCondition('paso_wf', array('swFacturas/enviar_fra','swFacturas/devolver_enviar_fra'));
                        break;
                    case 'lote':
                        $criteria->addInCondition('paso_wf', array('swFacturas/generacion_devolver_lote','swFacturas/generacion_lote'));
                        break;
                    default:
                        break;
                }
        if($this->razon_social != ""){
            $razon = strtoupper($this->razon_social);
            $criteria->addCondition("nit_proveedor in (select nit from proveedor where upper(razon_social) like '%".$razon."%')");
        }
        $criteria->compare('nro_factura',$this->nro_factura, true);
        $criteria->compare('id_factura',$this->id_factura);
        $criteria->compare('id_orden',$this->id_orden);
        $criteria->compare('cant_productos',$this->cant_productos);
        $criteria->compare('nit_proveedor',$this->nit_proveedor);
        $criteria->compare('valor_productos',$this->valor_productos);
        $criteria->compare('paso_wf',$this->paso_wf, true);
//      $criteria->compare('rte_fte',$this->rte_fte,true);
//      $criteria->compare('valor_rte_fte',$this->valor_rte_fte,true);
//      $criteria->compare('rte_iva',$this->rte_iva,true);
//      $criteria->compare('valor_rte_iva',$this->valor_rte_iva,true);
//      $criteria->compare('rte_ica',$this->rte_ica,true);
//      $criteria->compare('valor_rte_ica',$this->valor_rte_ica,true);
//      $criteria->compare('rte_timbre',$this->rte_timbre,true);
//      $criteria->compare('valor_rte_timbre',$this->valor_rte_timbre,true);
//      $criteria->compare('id_centro_costos',$this->id_centro_costos);
//      $criteria->compare('nro_pagos',$this->nro_pagos);
//      $criteria->compare('cuenta_x_pagar',$this->cuenta_x_pagar);
//      $criteria->compare('id_cuenta_contable',$this->id_cuenta_contable);
        $criteria->compare('analista_encargado',$this->analista_encargado);
        $criteria->compare('fecha_vencimiento',$this->fecha_vencimiento,true);
        $criteria->compare('fecha_factura',$this->fecha_factura,true);
        $criteria->compare('fecha_recibido',$this->fecha_recibido,true);
        $criteria->compare('path_imagen',$this->path_imagen,true);
        $criteria->compare('usuario_actual',Yii::app()->user->getState('id_empleado'));
        $criteria->compare('id_usuario_reemplazado',$this->id_usuario_reemplazado);
        $criteria->compare('creacion',$this->creacion,true);
        $criteria->compare('actualizacion',$this->actualizacion,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
    public function search_causacion()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id_factura',$this->id_factura);
        $criteria->compare('id_orden',$this->id_orden);
        $criteria->compare('nit_proveedor',$this->nit_proveedor);
        $criteria->compare('cant_productos',$this->cant_productos);
        $criteria->compare('valor_productos',$this->valor_productos);
        $criteria->compare('analista_encargado',$this->analista_encargado);
        $criteria->compare('fecha_vencimiento',$this->fecha_vencimiento,true);
        $criteria->compare('fecha_factura',$this->fecha_factura,true);
        $criteria->compare('fecha_recibido',$this->fecha_recibido,true);
        $criteria->compare('path_imagen',$this->path_imagen,true);
        $criteria->compare('paso_wf',$this->paso_wf,true);
        $criteria->compare('usuario_actual',-1);
        $criteria->compare('id_usuario_reemplazado',$this->id_usuario_reemplazado);
        $criteria->compare('creacion',$this->creacion,true);
        $criteria->compare('actualizacion',$this->actualizacion,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
           
    public function search_administrativo()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id_factura',$this->id_factura);
        $criteria->compare('id_orden',$this->id_orden);
        $criteria->compare('nit_proveedor',$this->nit_proveedor);
        $criteria->compare('cant_productos',$this->cant_productos);
        $criteria->compare('valor_productos',$this->valor_productos);
        $criteria->compare('analista_encargado',$this->analista_encargado);
        $criteria->compare('fecha_vencimiento',$this->fecha_vencimiento,true);
        $criteria->compare('fecha_factura',$this->fecha_factura,true);
        $criteria->compare('fecha_recibido',$this->fecha_recibido,true);
        $criteria->compare('path_imagen',$this->path_imagen,true);
        $criteria->compare('paso_wf',$this->paso_wf,true);
        $criteria->compare('usuario_actual',-2);
        $criteria->compare('id_usuario_reemplazado',$this->id_usuario_reemplazado);
        $criteria->compare('creacion',$this->creacion,true);
        $criteria->compare('actualizacion',$this->actualizacion,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
    public function search_operaciones()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
                
        $criteria->addCondition("id_factura in ( select id_factura from facturacion.factura_cxp where estado = '1' or estado = '2' group by 1)");
        if(!empty($this->razon_social)) {
            $prov = strtoupper($this->razon_social);
            $criteria->addCondition("nit_proveedor in ( select nit from proveedor where upper(razon_social) like '%$prov%')");
        }
        if(is_numeric($this->nit_proveedor)){
            $criteria->compare('nit_proveedor',$this->nit_proveedor);
        }
        $criteria->compare('id_factura',$this->id_factura);
        $criteria->compare('id_orden',$this->id_orden);
        $criteria->compare('nit_proveedor',$this->nit_proveedor);
        $criteria->compare('cant_productos',$this->cant_productos);
        $criteria->compare('valor_productos',$this->valor_productos);
        $criteria->compare('analista_encargado',$this->analista_encargado);
        $criteria->compare('fecha_vencimiento',$this->fecha_vencimiento,true);
        $criteria->compare('fecha_factura',$this->fecha_factura,true);
        $criteria->compare('fecha_recibido',$this->fecha_recibido,true);
        $criteria->compare('path_imagen',$this->path_imagen,true);
        $criteria->compare('paso_wf',$this->paso_wf,true);
        $criteria->compare('id_usuario_reemplazado',$this->id_usuario_reemplazado);
        $criteria->compare('creacion',$this->creacion,true);
        $criteria->compare('actualizacion',$this->actualizacion,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
    public function search_operaciones_pagadas()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->addCondition("id_factura in ( select id_factura from facturacion.factura_cxp where estado = '3' or estado = '4' group by 1)");
        if(!empty($this->razon_social)) {
            $prov = strtoupper($this->razon_social);
            $criteria->addCondition("nit_proveedor in ( select nit from proveedor where upper(razon_social) like '%$prov%')");
        }
        if(is_numeric($this->nit_proveedor)){
            $criteria->compare('nit_proveedor',$this->nit_proveedor);
        }
        $criteria->compare('id_factura',$this->id_factura);
        $criteria->compare('id_orden',$this->id_orden);
        $criteria->compare('nit_proveedor',$this->nit_proveedor);
        $criteria->compare('cant_productos',$this->cant_productos);
        $criteria->compare('valor_productos',$this->valor_productos);
        $criteria->compare('analista_encargado',$this->analista_encargado);
        $criteria->compare('fecha_vencimiento',$this->fecha_vencimiento,true);
        $criteria->compare('fecha_factura',$this->fecha_factura,true);
        $criteria->compare('fecha_recibido',$this->fecha_recibido,true);
        $criteria->compare('path_imagen',$this->path_imagen,true);
        $criteria->compare('paso_wf',$this->paso_wf,true);
        $criteria->compare('id_usuario_reemplazado',$this->id_usuario_reemplazado);
        $criteria->compare('creacion',$this->creacion,true);
        $criteria->compare('actualizacion',$this->actualizacion,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,

        ));
    }

    public function search_consulta()
    {

        $criteria=new CDbCriteria;

        if($this->razon_social != ""){
            $razon = strtoupper($this->razon_social);
            $criteria->addCondition("nit_proveedor in (select nit from proveedor where upper(razon_social) like '%".$razon."%')");
        }

        if($this->usuario_actual != ""){
            $usu_actual = strtoupper($this->usuario_actual);
            $criteria->addCondition("usuario_actual in (select id from empleados where upper(nombre_completo) like '%".$usu_actual."%')");
        }

        if($this->analista_encargado != ""){
            $analista = strtoupper($this->analista_encargado);
            $criteria->addCondition("analista_encargado in (select id from empleados where upper(nombre_completo) like '%".$analista."%')");
        }

        if( !array_intersect(array('CYC401'), Yii::app()->user->permisos) ){
            if($empleado->contratoses[0]->idCargo->es_jefe == 'Si'){
                 $criteria->addCondition("analista_encargado in (select e.id from empleados as e inner join contratos as c on  e.id = c.id_empleado inner join cargos as ca on c.id_cargo = ca.id where ca.id_jefatura = ".$empleado->contratoses[0]->idCargo->id_jefatura.")");
            }
            else if($empleado->contratoses[0]->idCargo->es_gerente == 'Si'){
                $criteria->addCondition("analista_encargado in (select e.id from empleados as e inner join contratos as c on  e.id = c.id_empleado inner join cargos as ca on c.id_cargo = ca.id where ca.id_gerencia = ".$empleado->contratoses[0]->idCargo->id_gerencia.")");   
            }
        }

        $criteria->compare('nro_factura',$this->nro_factura, true);
        $criteria->compare('id_factura',$this->id_factura);
        $criteria->compare('id_orden',$this->id_orden);
        $criteria->compare('cant_productos',$this->cant_productos);
        $criteria->compare('nit_proveedor',$this->nit_proveedor);
        $criteria->compare('valor_productos',$this->valor_productos);
        $criteria->compare('paso_wf',$this->paso_wf, true);
                                                                           
        $criteria->compare('fecha_vencimiento::text',$this->fecha_vencimiento,true);
        $criteria->compare('fecha_factura',$this->fecha_factura,true);
        $criteria->compare('fecha_recibido',$this->fecha_recibido,true);
        $criteria->compare('path_imagen',$this->path_imagen,true);
        $criteria->compare('id_usuario_reemplazado',$this->id_usuario_reemplazado);
        $criteria->compare('creacion',$this->creacion,true);
        $criteria->compare('actualizacion',$this->actualizacion,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
        public function getCuenta(){
        $query = Yii::app()->db->createCommand("select id, codigo || ' - ' || nombre as dato from cuenta_contable")->queryAll();
        return CHtml::listData($query, 'id', 'dato');
    }
        
        public function estadoLote(){
            $estado = FacturaCxp::model()->find('id_factura = '.$this->id_factura)->estado;
            switch ($estado) {
                case '1':
                    return 'Cuenta por pagar';
                    break;
                case '2':
                    return 'Cuenta por pagar';
                    break;
                case '3':
                    return 'Pagado';
                    break;
                case '4':
                    return 'Contabilizado';
                    break;
            }
        }
        
        public function getOrdenesCompra($proveedor){
//            $criteria = new CDbCriteria;
//            $criteria->join = 
//      $query = Yii::app()->db->createCommand()->queryAll();
//      return CHtml::listData($query, 'id_orden', 'dato');
            $count=Yii::app()->db->createCommand("select distinct o.id as id_orden, o.id || ' - '||o.nombre_compra ||' - '||o.fecha_solicitud::date as dato from cotizacion as c inner join producto_orden as po on po.id= c.producto_orden inner join orden as o on o.id=po.orden  where c.nit= '$proveedor' and o.paso_wf <>'swOrden/cancelada' order by o.id desc")->queryScalar();
            $sql="select distinct o.id as id_orden, o.id || ' - '||o.nombre_compra ||' - '||o.fecha_solicitud::date as dato from cotizacion as c inner join producto_orden as po on po.id= c.producto_orden inner join orden as o on o.id=po.orden  where c.nit= '$proveedor' and o.paso_wf <>'swOrden/cancelada' order by o.id desc";
            return new CSqlDataProvider($sql, array(
                'totalItemCount'=>$count,
                
                'pagination'=>array(
                    'pageSize'=>10,
                ),
            ));
            // $dataProvider->getData() will return a list of arrays.
    }
        
    public function getProveedor(){
        $query = Yii::app()->db->createCommand("select distinct p.nit as nit, p.nit || ' - '||p.razon_social  as dato from proveedor as p ;")->queryAll();
        return CHtml::listData($query, 'nit', 'dato');
    }
        
    public function getCentroCosto(){
            $query = Yii::app()->db->createCommand("select id, codigo || ' - ' || nombre as dato from centro_costos where activo = 'Si'")->queryAll();
            return CHtml::listData($query, 'id', 'dato');
    }

        public function getAnalista() {
            $query = Yii::app()->db->createCommand("select id, numero_identificacion || ' - ' || nombre_completo as dato from empleados where activo = 'Si'")->queryAll();
            return CHtml::listData($query, 'id', 'dato');
        }
    public function labelEstado($id_estado){
        $estados = SWHelper::allStatuslistData($this);
        return $estados[$id_estado];
    }
    
        public function estadoFactura() {
            $estado = FacturaCxp::model()->findByAttributes(array('id_factura'=>$this->id_factura));
            switch ($estado) {
                case 1:
                    return "CxP Sin Autorización";
                    break;
                case 2:
                    return "Pendiente Por Pagar";
                    break;
                case 3:
                    return "Pagado";
                    break;
                case 4:
                    return "Contabilizado";
                    break;
                default:
                    return "Sin Estado";
                    break;
            }
        }
        
        public function paraIndexacion(){
            $this->usuario_actual = Yii::app()->user->getState('id_empleado');
            $this->verificarReemplazo();
        }
        
        public function devolverIndexacion(){
            $this->usuario_actual = $this->id_usuario_solicitante;
            $this->verificarReemplazo();
        }
        
        public function paraAnalista(){
            $this->usuario_actual = $this->analista_encargado;
            $this->verificarReemplazo();
        }
        
        public function paraJefe(){
            $empleado = $this->analista_encargado;
      
            $query = "select max(fecha_inicio),id_cargo,id_jefatura, id_gerencia from cargos ca inner join contratos co on (ca.id = co.id_cargo) where id_empleado = $empleado group by id_cargo, id_jefatura, id_gerencia";

            $res =  $this->dbConnection->createCommand($query)->queryAll();


            $decir_jefe = "select id_empleado from contratos where id_cargo = (select id from cargos where id_jefatura = {$res[0]['id_jefatura']} and es_jefe = 'Si')";

            $decir_gerente = "select id_empleado from contratos where id_cargo = (select id from cargos where id_gerencia = {$res[0]['id_gerencia']} and es_gerente = 'Si')";
      
      
            if($res[0]['id_jefatura'] != ""){
              $jefe = $this->dbConnection->createCommand($decir_jefe)->queryAll();
              $usuario = $jefe[0]['id_empleado'];
            }else{
                $gerente = $this->dbConnection->createCommand($decir_gerente)->queryAll();    
                $usuario = $gerente[0]['id_empleado'];
            }
            
            $this->usuario_actual = $usuario;
            $this->verificarReemplazo();
        }
        
        public function paraGerente(){
            $empleado = $this->analista_encargado;
      
            $query = "select max(fecha_inicio),id_cargo,id_jefatura, id_gerencia from cargos ca inner join contratos co on (ca.id = co.id_cargo) where id_empleado = $empleado group by id_cargo, id_jefatura, id_gerencia";

            $res =  $this->dbConnection->createCommand($query)->queryAll();


            $decir_gerente = "select id_empleado from contratos where id_cargo = (select id from cargos where id_gerencia = {$res[0]['id_gerencia']} and es_gerente = 'Si')";
      
      
            $gerente = $this->dbConnection->createCommand($decir_gerente)->queryAll();    
            $usuario = $gerente[0]['id_empleado'];
            
            $this->usuario_actual = $usuario;
            $this->verificarReemplazo();
        }
        
        public function paraCausacion(){
            $this->usuario_actual = -1;
        }
        
        public function devolucionCausacion(){
            TipificadasFacturas::model()->deleteAllByAttributes(array('id_factura'=>  $this->id_factura));
        }
        
        
        public function para_generar_lote_dev() {
            $this->usuario_actual = TrazabilidadWfs::model()->findByAttributes(
                    array(
                        'model'=>'Facturas', 
                        'idmodel'=>  $this->id_factura, 
                        'estado_nuevo'=>'swFacturas/generacion_lote'))->usuario_nuevo;
            $this->verificarReemplazo();
        }
        
        public function paraAdministrativo() {
            $this->usuario_actual = -2;
            //$this->usuario_actual = Contratos::model()->findByAttributes(array('id_cargo'=>509))->id_empleado;
            //+$this->verificarReemplazo();
        }
        
        public function paraOperaciones() {
            $this->usuario_actual = -3;
            $this->verificarReemplazo();
        }
        
        public function guardarListas($respuesta) {
            
            $lista = ListasEspeciales::model()->findByAttributes(array('id_factura'=>$this->id_factura));
            if(!$lista)
                $lista = new ListasEspeciales;
            $lista->id_factura = $this->id_factura;
            $lista->tipo_identificacion = $respuesta['TipoDeIdentificacion'];
            $lista->numero_identificacion = $respuesta['NumeroDeIdentificacion'];
            $lista->razon_social = $respuesta['NombreoRazonSocial'];  
            $lista->indicador1 = $respuesta['Indicador1ArchivodeCliente'];    
            $lista->indicador2 = $respuesta['Indicador2ListasEspeciales'];   
            $lista->indicador3 = $respuesta['Indicador3DocumentoCompleto'];   
            $lista->indicador4 = $respuesta['Indicador4Documentos'];  
            $lista->save(); 
            if($this->paso_actual == 'swFacturas/recepcion_documento' && $model->paso_wf == 'swFacturas/indexacion'){
                if($lista->indicador1 == '2' || $lista->indicador3 == '2' || $lista->indicador4 == '2'){
                    $empleado = Empleados::model()->findByPk(Parametros::model()->findByPk(1)->id_empl_clientes);
                    $html = Yii::app()->controller->renderPartial("email_alertas", array('factura'=>$this, 'lista'=>$lista),true);
                    Yii::app()->mailer->alertasNit($empleado->email, $html);
                }
                if($lista->indicador2 == '1' ){
                    $empleado = Empleados::model()->findByPk(Parametros::model()->findByPk(1)->id_empl_listas);
                    $html = Yii::app()->controller->renderPartial("email_alertas_2", array('factura'=>$this, 'lista'=>$lista),true);
                    Yii::app()->mailer->alertasNit($empleado->email, $html);
                }
            }
            
            
        }
        
        public function procesarConsultaRiesgos() {
            $this->_aya = new SWebServiceFacturacion;   
            $respuesta = $this->_aya->consultaCentrales($this->tipo_identificacion, $this->nit_proveedor); 
            if($respuesta){
                $this->guardarListas($respuesta);
            }
        }
        
        public function cuentasTipificadas() {
            $ctas = array();
            foreach ($this->cuentasFacturas as $value) {
                array_push($ctas, $value->idCuentaContable->codigo);
            }
            $this->_aya = new SWebServiceFacturacion;
            $respuesta = $this->_aya->cuentasTipificadas($ctas); 
            if($respuesta){
                
                if(isset($respuesta['errores'])){
                    foreach ($respuesta['errores'] as $value) {
                        $this->addError('fake', $value);
                    }
                }
                else {
                    foreach ($respuesta as $nodo) {
                        $cuenta = $nodo['NumerodeCuenta']*1;
                        if($nodo['CodigoTipificado'] != ''){
                            $factura_tipi = TipificadasFacturas::model()->findByAttributes(array(
                                'id_factura'=>$this->id_factura, 
                                'cuenta'=>$cuenta, 
                                'codigo_tipificada'=>$nodo['CodigoTipificado'],
                                'consecutivo_valor'=>$nodo['ConsecutivoValor']
                            ));
                            if(!$factura_tipi){
                                $factura_tipi = new TipificadasFacturas;
                                $factura_tipi->id_factura = $this->id_factura;
                                $factura_tipi->cuenta = $cuenta;
                                $factura_tipi->codigo_tipificada = $nodo['CodigoTipificado'];
                                $factura_tipi->descripcion_tipificada = $nodo['DescripcionTipificada'];
                                $factura_tipi->consecutivo_valor = $nodo['ConsecutivoValor'];
                                $factura_tipi->descripcion_valor = $nodo['DescripcionValor'];   
                                $factura_tipi->cuenta_por_pagar = $this->nit_proveedor;
                                $factura_tipi->tipo_consulta = 1;
                                $factura_tipi->save();
                            }
                        }
                    }
                }
                
            }
            else {
                $this->addError('fake', 'El servicio con AS400 no responde');
            }
        }
        
        public function aprobarLote() {
            $anterior = Facturas::model()->findByPk($this->id_factura);
            if($anterior->paso_wf != $this->paso_wf){
                $this->_aya = new SWebServiceFacturacion;
                $respuesta = $this->_aya->aprobarLote($this); 
                if($respuesta){
                    
                    if(isset($respuesta['errores'])){
                        foreach ($respuesta['errores'] as $value) {
                            $this->addError('fake', $value);
                        }
                    }
                    else if(isset($respuesta['creado'])){
                        $listas = $respuesta['creado']['InformacionCab'];
                        $this->guardarListas($listas);
                        
                        $repeticiones = $respuesta['creado']['Repeticiones']['InformacionRep'];
                        //print_r($repeticiones);die;
                        $valor_aprobado = 0;
                        if(isset($repeticiones[0])){
                            foreach ($repeticiones as $nodo){
                                if($nodo['Valor']!=""){
                                    $cxp = new FacturaCxp;
                                    $cxp->id_factura = $this->id_factura;
                                    $cxp->identificacion = $nodo['NumerodeIdentificacion2'];
                                    $cxp->razon_social = $nodo['NombreoRazonSocial'];
                                    $cxp->valor_aprobado = $nodo['Valor'];
                                    $valor_aprobado += $nodo['Valor'];
                                    $cxp->estado = $nodo['Estado'];
                                    $cxp->fecha_limite_pago = trim(str_replace("/", "", $nodo['FechaLimitedePago']));
                                    if (!$cxp->save()) {
                                        //print_r($cxp->getErrors());die('con nodo');
                                    }
                                }
                                
                            }
                            $this->valor_aprobado = $valor_aprobado;
                        }
                        else {
                            if($repeticiones['Valor'] != ""){
                                $cxp = new FacturaCxp;
                                $cxp->id_factura = $this->id_factura;
                                $cxp->identificacion = $repeticiones['NumerodeIdentificacion2'];
                                $cxp->razon_social = $repeticiones['NombreoRazonSocial'];
                                $cxp->valor_aprobado = $repeticiones['Valor'];
                                $cxp->estado = $repeticiones['Estado'];
                                $cxp->fecha_limite_pago = trim(str_replace("/", "", $repeticiones['FechaLimitedePago']));
                                if (!$cxp->save()) {
                                    //print_r($cxp->getErrors('sin nodo'));die;
                                }
                                $this->valor_aprobado = $repeticiones['Valor'];
                            }
                            
                        }
                    }
                }
                else {
                    $this->addError('fake', 'El servicio con AS400 no responde');
                }
            }
        }
        public function consultarFacturas() {
            
            $this->_aya = new SWebServiceFacturacion;
            $respuesta = $this->_aya->consultaFactura(); 
            if($respuesta){
                
                if(isset($respuesta['errores'])){
                    return $respuesta;
                }
                else if(isset($respuesta['creado'])){
                    
                    $repeticiones = $respuesta['creado']['Repeticiones']['InformacionRep'];
                    
//                    echo '<pre>';
//                    print_r($repeticiones);
//                    echo'</pre>';die;
                    if(isset($repeticiones[0])){
                        foreach ($repeticiones as $nodo){
                            if($nodo['Estado'] !== ''){
                                $fra = Facturas::model()->find("upper(nro_factura) = '".$nodo['NumerodeFactura']."'");
                                if(!$fra){
                                    die($nodo['NumerodeFactura']);
                                }
                                $cxp = FacturaCxp::model()->updateAll(array('estado'=>$nodo['Estado']), "id_factura = ".$fra->id_factura);
                                $fra->valor_pagado = $nodo['ValorPagado'];
                                if(trim($nodo['FechadePago']) != '0000/00/00')
                                    $fra->fecha_pago = trim($nodo['FechadePago']);
                                $fra->paso_wf = 'swFacturas/pagada';
                                if(!$fra->save()){
                                    print_r($fra->getErrors());die;
                                }
//                                echo 'si entro';
                            }
                            else {
//                                echo'no entro';
                            }
                        }
//                        die;
                    }
                    else {
                        if($nodo['Estado'] !== ''){
                            $fra = Facturas::model()->findByAttributes(array('nro_factura'=>$repeticiones['NumerodeFactura']));
                            $cxp = FacturaCxp::model()->updateAll(array('estado'=>$repeticiones['Estado']), "id_factura = ".$fra->id_factura);
                            $fra->valor_pagado = $repeticiones['ValorPagado'];
                            if(trim($repeticiones['FechadePago']) != '0000/00/00')
                                $fra->fecha_pago = trim($repeticiones['FechadePago']);
                            $fra->paso_wf = 'swFacturas/pagada';
                            if($fra->save()){
                                    print_r($fra->getErrors());die;
                                }
                        }
                    }
                }
            }
            else {
                return 'El servicio con AS400 no responde';
            }
            
        }
        public function generarLote() {
            
                $this->_aya = new SWebServiceFacturacion;
                $cabecera = array();
                $respuesta = $this->_aya->causarFactura($this); 

    //                print_r($respuesta);die;
                if(isset($respuesta['errores'])){
                    foreach ($respuesta['errores'] as $value) {
                        $this->addError('fake', $value);
                    }
                }
                else if(isset($respuesta['creado'])){
                    $listas = $respuesta['creado']['InformacionCab'];
                    $this->guardarListas($listas);
                    if($listas['Lote']!= ''){
                        $this->lote = $listas['Lote'];
                        $this->fecha_proceso = str_replace("/", "", $listas['FechadeProceso']);
                        $this->fecha_efectiva = str_replace("/", "", $listas['FechaEfectiva']);
                        $this->username = $listas['Usuario'];
                    }
                    $lista = ListasEspeciales::model()->findByAttributes(array('id_factura'=>$this->id_factura));
                    if($lista->indicador1 == 2)
                        $this->addError('fake', 'El nit '.$lista->numero_identificacion.' no existe en AS400<br>');
                    if($lista->indicador2 == 1)
                        $this->addError('fake', 'El nit '.$lista->numero_identificacion.' se encuentra en al menos una lista de clientes no deseables<br>');
    //                if($lista->indicador3 == 2)
    //                    $this->addError('fake', 'El proveedor tiene documentos incompletos<br>');
    //                if($lista->indicador4 == 2)
    //                    $this->addError('fake', 'El proveedor tiene documentos vencidos<br>');
                    $repeticiones = $respuesta['creado']['Repeticiones']['InformacionRep'];
                    foreach ($repeticiones as $nodo) {
                        $cuenta = $nodo['Cuentas'];
                        if($nodo['CodigodeTipificada']  != ''){
                            $factura_tipi = TipificadasFacturas::model()->findByAttributes(array(
                                'id_factura'=>$this->id_factura, 
                                'codigo_tipificada'=>$nodo['CodigodeTipificada'],
                                'consecutivo_valor'=>$nodo['CodigodeConsecutivo'],
                                'centro_costos'=>$nodo['CentrodeCostosTip'],
                                'agencia'=>$nodo['AgenciaTip']
                            ));
                            if(!$factura_tipi){
                                $factura_tipi = new TipificadasFacturas;
                                $factura_tipi->id_factura = $this->id_factura;
                                $factura_tipi->codigo_tipificada = $nodo['CodigodeTipificada'];
                                $factura_tipi->consecutivo_valor = $nodo['CodigodeConsecutivo'];
                                $factura_tipi->tipo_consulta = 2;
                            }
                            $factura_tipi->secuencia = $nodo['Secuencia'];
                            $factura_tipi->descripcion_valor = $nodo['Concepto'];  
                            $factura_tipi->vr_codigo_cuentas = $nodo['ValordelCodigodeCuentas']; 
                            $factura_tipi->cuentas = $nodo['Cuentas'];
                            $factura_tipi->naturaleza = $nodo['Naturaleza'];
                            $factura_tipi->save();

                        }
                    }
                    $this->crearRegistrosTemporales();
                }
                else {
                    $this->addError('fake', 'El servicio con AS400 no responde');
                }
//            }
            
        }
        
        public function crearRegistrosTemporales() {
            $tipi = TipificadasFacturas::model()->findAllByAttributes(array('id_factura'=>  $this->id_factura, 'tipo_consulta'=>1),' valor is not null');
            foreach ($tipi as $t) {
                $tmp = TmpTipificadas::model()->findByAttributes(array('id_factura'=>  $this->id_factura, 'id_tipificada'=>$t->id_tipificadas_facturas));
                if(!$tmp){
                    $tmp = new TmpTipificadas;
                    $tmp->id_factura = $this->id_factura;
                    $tmp->id_tipificada = $t->id_tipificadas_facturas;
                }
                $tmp->valor = $t->valor;
                $tmp->save();
            }
        }
        
        public function modificarLote() {
            
            $this->_aya = new SWebServiceFacturacion;
            $cabecera = array();
            $respuesta = $this->_aya->modificacionLote($this); 
            $eliminar = TipificadasFacturas::model()->deleteAllByAttributes(array('id_factura'=>$this->id_factura, 'tipo_consulta'=>2));
            
            if(isset($respuesta['errores'])){
                foreach ($respuesta['errores'] as $value) {
                    $this->addError('fake', $value);
                }
            }
            else if(isset($respuesta['creado'])){
                $listas = $respuesta['creado']['InformacionCab'];
                
                if($listas['Lote']!= ''){
                    $this->lote = $listas['Lote'];
                    $this->fecha_proceso = date('Ymd', strtotime($listas['FechadeProceso']));
                    $this->fecha_efectiva = date('Ymd', strtotime($listas['FechaEfectiva']));
                }
                $repeticiones = $respuesta['creado']['Repeticiones']['InformacionRep'];
                $tipi_borrar = TipificadasFacturas::model()->findAllByAttributes(array('id_factura'=>$this->id_factura, 'tipo_consulta'=>2));

                foreach ($tipi_borrar as $t) {
                    $t->delete();
                }
                //$borrar = TipificadasFacturas::model()->deleteAll('id_factura = :fra and tipo_consulta = 2', array(':fra'=>$this->id_factura));
                
                //die($this->id_factura.'borradas'.$borrar);
                $borrar2 = TipificadasFacturas::model()->findAll('(valor is null or valor = \'0\') and id_factura = :fra', array(':fra'=>$this->id_factura));
                foreach ($borrar2 as $t) {
                    $t->delete();
                }

                foreach ($repeticiones as $nodo) {
                    $cuenta = $nodo['Cuentas'];
                    if($nodo['CodigodeTipificada']  != ''){
                        $factura_tipi = TipificadasFacturas::model()->findByAttributes(array(
                            'id_factura'=>$this->id_factura, 
                            'codigo_tipificada'=>$nodo['CodigodeTipificada'],
                            'consecutivo_valor'=>$nodo['CodigodeConsecutivo'],
                            'centro_costos'=>$nodo['CentrodeCostosTip'],
                            'agencia'=>$nodo['AgenciaTip'],

                        ));
                        if(!$factura_tipi){
                            $factura_tipi = new TipificadasFacturas;
                            $factura_tipi->id_factura = $this->id_factura;
                            $factura_tipi->codigo_tipificada = $nodo['CodigodeTipificada'];
                            $factura_tipi->consecutivo_valor = $nodo['CodigodeConsecutivo'];
                            $factura_tipi->tipo_consulta = 2;
                        }
                        $factura_tipi->secuencia = $nodo['Secuencia'];
                        $factura_tipi->descripcion_valor = $nodo['Concepto'];  
                        $factura_tipi->vr_codigo_cuentas = $nodo['ValordelCodigodeCuentas']; 
                        $factura_tipi->cuentas = $nodo['Cuentas'];
                        $factura_tipi->naturaleza = $nodo['Naturaleza'];
                        $factura_tipi->save();
                        
                    }
                }
                $this->crearRegistrosTemporales();
            }
            else {
                $this->addError('fake', 'El servicio con AS400 no responde');
            }
        }
        
        public function modificarFecha() {
            if($this->parametro == 2 && $this->paso_wf == 'swFacturas/modificar_fecha_normal'){
                $this->addError('fake', "Para modificar fecha normal el parametro debe ser Fecha Normal");
            }
            else if($this->parametro == 1 && $this->paso_wf == 'swFacturas/modificar_todas_fechas'){
                $this->addError('fake', "Para modificar todas las fechas el parametro debe ser Todas las Fechas");
            }
            else {
                $this->_aya = new SWebServiceFacturacion;
                $cabecera = array();
                $respuesta = $this->_aya->modificarFecha($this); 

                if(isset($respuesta['errores'])){
                    foreach ($respuesta['errores'] as $value) {
                        $this->addError('fake', $value);
                    }
                }
                else if(isset($respuesta['modificado'])){
                    $info = $respuesta['modificado']['InformacionCab'];

                    if($info['Lote']!= ''){
                        $this->lote = $info['Lote'];
                        $this->fecha_proceso = date('Ymd', strtotime($info['FechadeProceso']));
                        $this->fecha_efectiva = date('Ymd', strtotime($info['FechaEfectiva']));
                    }
                }
                else {
                    $this->addError('fake', 'El servicio con AS400 no responde');
                }
            }
            
        }
        
        public function eliminarLote() {
            $this->_aya = new SWebServiceFacturacion;
            $cabecera = array();
            $respuesta = $this->_aya->eliminarLote($this);
            
            if(isset($respuesta['errores'])){
                foreach ($respuesta['errores'] as $value) {
                    $this->addError('fake', $value);
                }
            }
        }

    public function verificarReemplazo(){
      $e = Empleados::model()->findByPk($this->usuario_actual);
      if($e->reemplazo != ""){
        $this->id_usuario_reemplazado = $this->usuario_actual;
        $this->usuario_actual = $e->reemplazo;
      }
    }
        
}