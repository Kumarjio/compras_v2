<?php

/**
 * This is the model class for table "documentos_vpj".
 *
 * The followings are the available columns in table 'documentos_vpj':
 * @property integer $id
 * @property integer $id_vpj
 * @property integer $requiere_acuerdo_servicios
 * @property integer $requiere_contrato
 * @property integer $requiere_acuerdo_confidencialidad
 * @property integer $requiere_polizas_cumplimiento
 * @property string $fe_polizas_cumplimiento
 * @property string $fv_polizas_cumplimiento
 * @property integer $renovacion_polizas_cumplimiento
 * @property string $fr_polizas_cumplimiento
 * @property integer $requiere_seriedad_oferta
 * @property string $fe_seriedad_oferta
 * @property string $fv_seriedad_oferta
 * @property integer $renovacion_seriedad_oferta
 * @property string $fr_seriedad_oferta
 * @property integer $requiere_buen_manejo_anticipo
 * @property string $fe_buen_manejo_anticipo
 * @property string $fv_buen_manejo_anticipo
 * @property integer $renovacion_buen_manejo_anticipo
 * @property string $fr_buen_manejo_anticipo
 * @property integer $requiere_calidad_suministro
 * @property string $fe_calidad_suministro
 * @property string $fv_calidad_suministro
 * @property integer $renovacion_calidad_suministro
 * @property string $fr_calidad_suministro
 * @property integer $requiere_calidad_correcto_funcionamiento
 * @property string $fe_calidad_correcto_funcionamiento
 * @property string $fv_calidad_correcto_funcionamiento
 * @property integer $renovacion_calidad_correcto_funcionamiento
 * @property string $fr_calidad_correcto_funcionamiento
 * @property integer $requiere_pago_salario_prestaciones
 * @property string $fe_pago_salario_prestaciones
 * @property string $fv_pago_salario_prestaciones
 * @property integer $renovacion_pago_salario_prestaciones
 * @property string $fr_pago_salario_prestaciones
 * @property integer $requiere_estabilidad_oferta
 * @property string $fe_estabilidad_oferta
 * @property string $fv_estabilidad_oferta
 * @property integer $renovacion_estabilidad_oferta
 * @property string $fr_estabilidad_oferta
 * @property integer $requiere_responsabilidad_civil_extracontractual
 * @property string $fe_responsabilidad_civil_extracontractual
 * @property string $fv_responsabilidad_civil_extracontractual
 * @property integer $renovacion_responsabilidad_civil_extracontractual
 * @property string $fr_responsabilidad_civil_extracontractual
 * @property integer $requiere_calidad_obra
 * @property string $fe_calidad_obra
 * @property string $fv_calidad_obra
 * @property integer $renovacion_calidad_obra
 * @property string $fr_calidad_obra
 */
class DocumentosVpj extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DocumentosVpj the static model class
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
		return 'documentos_vpj';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_vpj, requiere_acuerdo_servicios, requiere_contrato, requiere_acuerdo_confidencialidad, requiere_polizas_cumplimiento, renovacion_polizas_cumplimiento, requiere_seriedad_oferta, renovacion_seriedad_oferta, requiere_buen_manejo_anticipo, renovacion_buen_manejo_anticipo, requiere_calidad_suministro, renovacion_calidad_suministro, requiere_calidad_correcto_funcionamiento, renovacion_calidad_correcto_funcionamiento, requiere_pago_salario_prestaciones, renovacion_pago_salario_prestaciones, requiere_estabilidad_oferta, renovacion_estabilidad_oferta, requiere_responsabilidad_civil_extracontractual, renovacion_responsabilidad_civil_extracontractual, requiere_calidad_obra, renovacion_calidad_obra', 'numerical', 'integerOnly'=>true),
			array('requiere_acuerdo_servicios, requiere_contrato, requiere_acuerdo_confidencialidad, requiere_polizas_cumplimiento, renovacion_polizas_cumplimiento, requiere_seriedad_oferta, renovacion_seriedad_oferta, requiere_buen_manejo_anticipo, renovacion_buen_manejo_anticipo, requiere_calidad_suministro, renovacion_calidad_suministro, requiere_calidad_correcto_funcionamiento, renovacion_calidad_correcto_funcionamiento, requiere_pago_salario_prestaciones, renovacion_pago_salario_prestaciones, requiere_estabilidad_oferta, renovacion_estabilidad_oferta, requiere_responsabilidad_civil_extracontractual, renovacion_responsabilidad_civil_extracontractual, requiere_calidad_obra, renovacion_calidad_obra', 'default', 'value' => 0),
			array('fe_polizas_cumplimiento, fv_polizas_cumplimiento, fr_polizas_cumplimiento, fe_seriedad_oferta, fv_seriedad_oferta, fr_seriedad_oferta, fe_buen_manejo_anticipo, fv_buen_manejo_anticipo, fr_buen_manejo_anticipo, fe_calidad_suministro, fv_calidad_suministro, fr_calidad_suministro, fe_calidad_correcto_funcionamiento, fv_calidad_correcto_funcionamiento, fr_calidad_correcto_funcionamiento, fe_pago_salario_prestaciones, fv_pago_salario_prestaciones, fr_pago_salario_prestaciones, fe_estabilidad_oferta, fv_estabilidad_oferta, fr_estabilidad_oferta, fe_responsabilidad_civil_extracontractual, fv_responsabilidad_civil_extracontractual, fr_responsabilidad_civil_extracontractual, fe_calidad_obra, fv_calidad_obra, fr_calidad_obra', 'default', 'value' => null),
			array('fe_polizas_cumplimiento, fv_polizas_cumplimiento, fr_polizas_cumplimiento, fe_seriedad_oferta, fv_seriedad_oferta, fr_seriedad_oferta, fe_buen_manejo_anticipo, fv_buen_manejo_anticipo, fr_buen_manejo_anticipo, fe_calidad_suministro, fv_calidad_suministro, fr_calidad_suministro, fe_calidad_correcto_funcionamiento, fv_calidad_correcto_funcionamiento, fr_calidad_correcto_funcionamiento, fe_pago_salario_prestaciones, fv_pago_salario_prestaciones, fr_pago_salario_prestaciones, fe_estabilidad_oferta, fv_estabilidad_oferta, fr_estabilidad_oferta, fe_responsabilidad_civil_extracontractual, fv_responsabilidad_civil_extracontractual, fr_responsabilidad_civil_extracontractual, fe_calidad_obra, fv_calidad_obra, fr_calidad_obra', 'date', 'format' => 'yyyy-MM-dd', 'message' => 'Formato de fecha inválido'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_vpj, requiere_acuerdo_servicios, requiere_contrato, requiere_acuerdo_confidencialidad, requiere_polizas_cumplimiento, fe_polizas_cumplimiento, fv_polizas_cumplimiento, renovacion_polizas_cumplimiento, fr_polizas_cumplimiento, requiere_seriedad_oferta, fe_seriedad_oferta, fv_seriedad_oferta, renovacion_seriedad_oferta, fr_seriedad_oferta, requiere_buen_manejo_anticipo, fe_buen_manejo_anticipo, fv_buen_manejo_anticipo, renovacion_buen_manejo_anticipo, fr_buen_manejo_anticipo, requiere_calidad_suministro, fe_calidad_suministro, fv_calidad_suministro, renovacion_calidad_suministro, fr_calidad_suministro, requiere_calidad_correcto_funcionamiento, fe_calidad_correcto_funcionamiento, fv_calidad_correcto_funcionamiento, renovacion_calidad_correcto_funcionamiento, fr_calidad_correcto_funcionamiento, requiere_pago_salario_prestaciones, fe_pago_salario_prestaciones, fv_pago_salario_prestaciones, renovacion_pago_salario_prestaciones, fr_pago_salario_prestaciones, requiere_estabilidad_oferta, fe_estabilidad_oferta, fv_estabilidad_oferta, renovacion_estabilidad_oferta, fr_estabilidad_oferta, requiere_responsabilidad_civil_extracontractual, fe_responsabilidad_civil_extracontractual, fv_responsabilidad_civil_extracontractual, renovacion_responsabilidad_civil_extracontractual, fr_responsabilidad_civil_extracontractual, requiere_calidad_obra, fe_calidad_obra, fv_calidad_obra, renovacion_calidad_obra, fr_calidad_obra', 'safe', 'on'=>'search'),
			array('requiere_polizas_cumplimiento', 'polizas_validation', 'on' => 'willies'),
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
			'id_vpj' => 'Id Vpj',
			'requiere_acuerdo_servicios' => 'Requiere Acuerdo Servicios',
			'requiere_contrato' => 'Requiere Contrato',
			'requiere_acuerdo_confidencialidad' => 'Requiere Acuerdo Confidencialidad',
			'requiere_polizas_cumplimiento' => 'Requiere Polizas Cumplimiento',
			'fe_polizas_cumplimiento' => 'Fecha Expedición Polizas Cumplimiento',
			'fv_polizas_cumplimiento' => 'Fecha Vencimiento Polizas Cumplimiento',
			'renovacion_polizas_cumplimiento' => 'Renovacion Polizas Cumplimiento',
			'fr_polizas_cumplimiento' => 'Fecha Renovación Polizas Cumplimiento',
			'requiere_seriedad_oferta' => 'Requiere Seriedad Oferta',
			'fe_seriedad_oferta' => 'Fecha Expedición Seriedad Oferta',
			'fv_seriedad_oferta' => 'Fecha Vencimiento Seriedad Oferta',
			'renovacion_seriedad_oferta' => 'Renovacion Seriedad Oferta',
			'fr_seriedad_oferta' => 'Fecha Renovación Seriedad Oferta',
			'requiere_buen_manejo_anticipo' => 'Requiere Buen Manejo Anticipo',
			'fe_buen_manejo_anticipo' => 'Fecha Expedición Buen Manejo Anticipo',
			'fv_buen_manejo_anticipo' => 'Fecha Vencimiento Buen Manejo Anticipo',
			'renovacion_buen_manejo_anticipo' => 'Renovacion Buen Manejo Anticipo',
			'fr_buen_manejo_anticipo' => 'Fecha Renovación Buen Manejo Anticipo',
			'requiere_calidad_suministro' => 'Requiere Calidad Suministro',
			'fe_calidad_suministro' => 'Fecha Expedición Calidad Suministro',
			'fv_calidad_suministro' => 'Fecha Vencimiento Calidad Suministro',
			'renovacion_calidad_suministro' => 'Renovacion Calidad Suministro',
			'fr_calidad_suministro' => 'Fecha Renovación Calidad Suministro',
			'requiere_calidad_correcto_funcionamiento' => 'Requiere Calidad Correcto Funcionamiento',
			'fe_calidad_correcto_funcionamiento' => 'Fecha Expedición Calidad Correcto Funcionamiento',
			'fv_calidad_correcto_funcionamiento' => 'Fecha Vencimiento Calidad Correcto Funcionamiento',
			'renovacion_calidad_correcto_funcionamiento' => 'Renovacion Calidad Correcto Funcionamiento',
			'fr_calidad_correcto_funcionamiento' => 'Fecha Renovación Calidad Correcto Funcionamiento',
			'requiere_pago_salario_prestaciones' => 'Requiere Pago Salario Prestaciones',
			'fe_pago_salario_prestaciones' => 'Fecha Expedición Pago Salario Prestaciones',
			'fv_pago_salario_prestaciones' => 'Fecha Vencimiento Pago Salario Prestaciones',
			'renovacion_pago_salario_prestaciones' => 'Renovacion Pago Salario Prestaciones',
			'fr_pago_salario_prestaciones' => 'Fecha Renovación Pago Salario Prestaciones',
			'requiere_estabilidad_oferta' => 'Requiere Estabilidad Obra',
			'fe_estabilidad_oferta' => 'Fecha Expedición Estabilidad Obra',
			'fv_estabilidad_oferta' => 'Fecha Vencimiento Estabilidad Obra',
			'renovacion_estabilidad_oferta' => 'Renovacion Estabilidad Obra',
			'fr_estabilidad_oferta' => 'Fecha Renovación Estabilidad Oferta',
			'requiere_responsabilidad_civil_extracontractual' => 'Requiere Responsabilidad Civil Extracontractual',
			'fe_responsabilidad_civil_extracontractual' => 'Fecha Expedición Responsabilidad Civil Extracontractual',
			'fv_responsabilidad_civil_extracontractual' => 'Fecha Vencimiento Responsabilidad Civil Extracontractual',
			'renovacion_responsabilidad_civil_extracontractual' => 'Renovacion Responsabilidad Civil Extracontractual',
			'fr_responsabilidad_civil_extracontractual' => 'Fecha Renovación Responsabilidad Civil Extracontractual',
			'requiere_calidad_obra' => 'Requiere Calidad Obra',
			'fe_calidad_obra' => 'Fecha Expedición Calidad Obra',
			'fv_calidad_obra' => 'Fecha Vencimiento Calidad Obra',
			'renovacion_calidad_obra' => 'Renovacion Calidad Obra',
			'fr_calidad_obra' => 'Fecha Renovación Calidad Obra',
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
		$criteria->compare('id_vpj',$this->id_vpj);
		$criteria->compare('requiere_acuerdo_servicios',$this->requiere_acuerdo_servicios);
		$criteria->compare('requiere_contrato',$this->requiere_contrato);
		$criteria->compare('requiere_acuerdo_confidencialidad',$this->requiere_acuerdo_confidencialidad);
		$criteria->compare('requiere_polizas_cumplimiento',$this->requiere_polizas_cumplimiento);
		$criteria->compare('fe_polizas_cumplimiento',$this->fe_polizas_cumplimiento,true);
		$criteria->compare('fv_polizas_cumplimiento',$this->fv_polizas_cumplimiento,true);
		$criteria->compare('renovacion_polizas_cumplimiento',$this->renovacion_polizas_cumplimiento);
		$criteria->compare('fr_polizas_cumplimiento',$this->fr_polizas_cumplimiento,true);
		$criteria->compare('requiere_seriedad_oferta',$this->requiere_seriedad_oferta);
		$criteria->compare('fe_seriedad_oferta',$this->fe_seriedad_oferta,true);
		$criteria->compare('fv_seriedad_oferta',$this->fv_seriedad_oferta,true);
		$criteria->compare('renovacion_seriedad_oferta',$this->renovacion_seriedad_oferta);
		$criteria->compare('fr_seriedad_oferta',$this->fr_seriedad_oferta,true);
		$criteria->compare('requiere_buen_manejo_anticipo',$this->requiere_buen_manejo_anticipo);
		$criteria->compare('fe_buen_manejo_anticipo',$this->fe_buen_manejo_anticipo,true);
		$criteria->compare('fv_buen_manejo_anticipo',$this->fv_buen_manejo_anticipo,true);
		$criteria->compare('renovacion_buen_manejo_anticipo',$this->renovacion_buen_manejo_anticipo);
		$criteria->compare('fr_buen_manejo_anticipo',$this->fr_buen_manejo_anticipo,true);
		$criteria->compare('requiere_calidad_suministro',$this->requiere_calidad_suministro);
		$criteria->compare('fe_calidad_suministro',$this->fe_calidad_suministro,true);
		$criteria->compare('fv_calidad_suministro',$this->fv_calidad_suministro,true);
		$criteria->compare('renovacion_calidad_suministro',$this->renovacion_calidad_suministro);
		$criteria->compare('fr_calidad_suministro',$this->fr_calidad_suministro,true);
		$criteria->compare('requiere_calidad_correcto_funcionamiento',$this->requiere_calidad_correcto_funcionamiento);
		$criteria->compare('fe_calidad_correcto_funcionamiento',$this->fe_calidad_correcto_funcionamiento,true);
		$criteria->compare('fv_calidad_correcto_funcionamiento',$this->fv_calidad_correcto_funcionamiento,true);
		$criteria->compare('renovacion_calidad_correcto_funcionamiento',$this->renovacion_calidad_correcto_funcionamiento);
		$criteria->compare('fr_calidad_correcto_funcionamiento',$this->fr_calidad_correcto_funcionamiento,true);
		$criteria->compare('requiere_pago_salario_prestaciones',$this->requiere_pago_salario_prestaciones);
		$criteria->compare('fe_pago_salario_prestaciones',$this->fe_pago_salario_prestaciones,true);
		$criteria->compare('fv_pago_salario_prestaciones',$this->fv_pago_salario_prestaciones,true);
		$criteria->compare('renovacion_pago_salario_prestaciones',$this->renovacion_pago_salario_prestaciones);
		$criteria->compare('fr_pago_salario_prestaciones',$this->fr_pago_salario_prestaciones,true);
		$criteria->compare('requiere_estabilidad_oferta',$this->requiere_estabilidad_oferta);
		$criteria->compare('fe_estabilidad_oferta',$this->fe_estabilidad_oferta,true);
		$criteria->compare('fv_estabilidad_oferta',$this->fv_estabilidad_oferta,true);
		$criteria->compare('renovacion_estabilidad_oferta',$this->renovacion_estabilidad_oferta);
		$criteria->compare('fr_estabilidad_oferta',$this->fr_estabilidad_oferta,true);
		$criteria->compare('requiere_responsabilidad_civil_extracontractual',$this->requiere_responsabilidad_civil_extracontractual);
		$criteria->compare('fe_responsabilidad_civil_extracontractual',$this->fe_responsabilidad_civil_extracontractual,true);
		$criteria->compare('fv_responsabilidad_civil_extracontractual',$this->fv_responsabilidad_civil_extracontractual,true);
		$criteria->compare('renovacion_responsabilidad_civil_extracontractual',$this->renovacion_responsabilidad_civil_extracontractual);
		$criteria->compare('fr_responsabilidad_civil_extracontractual',$this->fr_responsabilidad_civil_extracontractual,true);
		$criteria->compare('requiere_calidad_obra',$this->requiere_calidad_obra);
		$criteria->compare('fe_calidad_obra',$this->fe_calidad_obra,true);
		$criteria->compare('fv_calidad_obra',$this->fv_calidad_obra,true);
		$criteria->compare('renovacion_calidad_obra',$this->renovacion_calidad_obra);
		$criteria->compare('fr_calidad_obra',$this->fr_calidad_obra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function polizas(){
		$polizas = '';
		
		//if($this->requiere_acuerdo_servicios == 1){ $polizas .= $this->getAttributeLabel('requiere_acuerdo_servicios').'<br/>';}
	    //if($this->requiere_contrato == 1){ $polizas .= $this->getAttributeLabel('requiere_contrato').'<br/>';}
	    //if($this->requiere_acuerdo_confidencialidad == 1){ $polizas .= $this->getAttributeLabel('requiere_acuerdo_confidencialidad').'<br/>';}
	    if($this->requiere_polizas_cumplimiento == 1){ $polizas .= $this->getAttributeLabel('requiere_polizas_cumplimiento').'<br/>';}
	    if($this->requiere_seriedad_oferta == 1){ $polizas .= $this->getAttributeLabel('requiere_seriedad_oferta').'<br/>';}
	    if($this->requiere_buen_manejo_anticipo == 1){ $polizas .= $this->getAttributeLabel('requiere_buen_manejo_anticipo').'<br/>';}
	    if($this->requiere_calidad_suministro == 1){ $polizas .= $this->getAttributeLabel('requiere_calidad_suministro').'<br/>';}
	    if($this->requiere_calidad_correcto_funcionamiento == 1){ $polizas .= $this->getAttributeLabel('requiere_calidad_correcto_funcionamiento').'<br/>';}
	    if($this->requiere_pago_salario_prestaciones == 1){ $polizas .= $this->getAttributeLabel('requiere_pago_salario_prestaciones').'<br/>';}
	    if($this->requiere_estabilidad_oferta == 1){ $polizas .= $this->getAttributeLabel('requiere_estabilidad_oferta').'<br/>';}
	    if($this->requiere_responsabilidad_civil_extracontractual == 1){ $polizas .= $this->getAttributeLabel('requiere_responsabilidad_civil_extracontractual').'<br/>';}
	    if($this->requiere_calidad_obra == 1){ $polizas .= $this->getAttributeLabel('requiere_calidad_obra').'<br/>';}
		
		return $polizas;
	}
	
	protected function beforeValidate(){
		if($this->requiere_polizas_cumplimiento == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_polizas_cumplimiento',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_polizas_cumplimiento',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_polizas_cumplimiento == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_polizas_cumplimiento',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		if($this->requiere_seriedad_oferta == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_seriedad_oferta',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_seriedad_oferta',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_seriedad_oferta == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_seriedad_oferta',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		if($this->requiere_buen_manejo_anticipo == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_buen_manejo_anticipo',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_buen_manejo_anticipo',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_buen_manejo_anticipo == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_buen_manejo_anticipo',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		if($this->requiere_calidad_suministro == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_calidad_suministro',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_calidad_suministro',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_calidad_suministro == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_calidad_suministro',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		if($this->requiere_calidad_correcto_funcionamiento == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_calidad_correcto_funcionamiento',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_calidad_correcto_funcionamiento',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_calidad_correcto_funcionamiento == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_calidad_correcto_funcionamiento',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		if($this->requiere_pago_salario_prestaciones == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_pago_salario_prestaciones',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_pago_salario_prestaciones',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_pago_salario_prestaciones == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_pago_salario_prestaciones',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		if($this->requiere_estabilidad_oferta == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_estabilidad_oferta',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_estabilidad_oferta',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_estabilidad_oferta == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_estabilidad_oferta',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		if($this->requiere_responsabilidad_civil_extracontractual == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_responsabilidad_civil_extracontractual',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_responsabilidad_civil_extracontractual',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_responsabilidad_civil_extracontractual == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_responsabilidad_civil_extracontractual',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		if($this->requiere_calidad_obra == 1){
			$validator = CValidator::createValidator('required', $this, 'fe_calidad_obra',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			$validator = CValidator::createValidator('required', $this, 'fv_calidad_obra',array('on' => 'willies'));
			$this->getValidatorList()->add($validator);
			if($this->renovacion_calidad_obra == 1){
				$validator = CValidator::createValidator('required', $this, 'fr_calidad_obra',array('on' => 'willies'));
				$this->getValidatorList()->add($validator);
			}
		}
		return true;
	}
	
	public function polizas_validation(){
	}
	
}