<?php

class PacientesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','search','admin','nueva','consulta'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	private function ajaxyForm($model){
		if(isset($_POST['Pacientes']))
		{
			
			$model->attributes=$_POST['Pacientes'];
			if($model->save()){
	            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_form_ajaxy', array('model' => $model), true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_form_ajaxy', array('model' => $model), true)));
			}
		
		}else{
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_form_ajaxy', array('model' => $model), true)));
		}
	}

	public function actionSearch()
	{
		$total = 0;
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_GET['query']) && isset($_GET['query']) != ''){
				$c = new CDbCriteria;
				$c->condition = "nombre like :a";
				$c->params = array(":a" => '%'.$_GET['query'].'%');
				$total = Pacientes::model()->findAll($c);
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_autocomplete', array('total' => $total), true)));
			}else{
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_autocomplete', array('total' => $total), true)));
			}
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($cedula = null)
	{
		$model=new Pacientes;
                $model->cedula = $cedula;
		
		if(Yii::app()->request->isAjaxRequest){
			$this->_ajaxyForm($model);
		}else{
			
			if(isset($_POST['Pacientes']))
			{
				$model->attributes=$_POST['Pacientes'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id_paciente));
			}

			$this->render('create',array(
				'model'=>$model,
			));
	    }
		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(Yii::app()->request->isAjaxRequest){
			$this->_ajaxyForm($model);
		}else{
			if(isset($_POST['Pacientes']))
			{
				$model->attributes=$_POST['Pacientes'];
				if($model->save())
					$this->redirect(array('admin'));
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pacientes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pacientes']))
			$model->attributes=$_GET['Pacientes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Pacientes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionNueva(){
		
		$model = new Pacientes;
		
		if(isset($_POST['Pacientes'])){
			$model->attributes=$_POST['Pacientes'];
			//if($model->save())
			//	$this->redirect(array('view','id'=>$model->id_paciente));
		}

		$this->render('nueva',array(
			'model'=>$model,
		));
	}
        
        public function actionConsulta(){
		
		$model = new Pacientes;
		
		if(isset($_POST['Pacientes'])){
			$cedula = $_POST['Pacientes']['cedula'];
                        $paciente = Pacientes::model()->findByAttributes(array('cedula'=>$cedula));
                        if($paciente === null){
                            $this->redirect(array('create','cedula'=>$cedula));
                        }
                        else
                        {
                            $this->redirect(array('/citas/cita/create','id'=>$paciente->id_paciente));
                        }
			//if($model->save())
			//	$this->redirect(array('view','id'=>$model->id_paciente));
		}

		$this->render('consulta',array(
			'model'=>$model,
		));
	}
}
