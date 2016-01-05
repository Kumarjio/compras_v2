<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		//Yii::app()->whatsapp->enviaMsgText(array('573193970237'),'mensaje de prueba ');	
		$this->render('index'); 
	}
}