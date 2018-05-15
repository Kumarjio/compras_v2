<?php
class InformeGlobalForm extends CFormModel
{
    public $tipo_informe;
    public $tipo_negociacion;
    public $fecha_inicio;
    public $fecha_fin;
    public $id_gerencia;
    public $id_jefatura;
    public $negociador;
 
 
    public function rules()
    {
        return array(
            array('tipo_informe, fecha_inicio, fecha_fin', 'required'),
            array('negociador', 'required', 'on'=>'negociador'),   
            array('negociador, id_gerencia, id_jefatura, tipo_negociacion, tipo_informe, fecha_inicio, fecha_fin', 'safe'),   
            //array('password', 'authenticate'),
       
        );
    }

    public function tiposInforme(){
        return array(
            'N'=>'Por Negociador',
            'G'=>'Por Gerencias'
        );
    }
 
}