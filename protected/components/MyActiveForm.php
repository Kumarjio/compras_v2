<?php
class MyActiveForm extends CActiveForm
{
    public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true,$enableClientValidation=true)
    {
        $html = '<div class="error-left">';
        $html .= parent::error($model, $attribute, $htmlOptions, $enableAjaxValidation,$enableClientValidatin);
        
        return $html;
    }
}