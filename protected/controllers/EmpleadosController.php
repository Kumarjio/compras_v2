<?php

class EmpleadosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'admin';
	public $model;

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
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
                  'actions'=>array('view','create','update','admin','delete','ausentismo','deleteAusentismo'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'actions' => array('index'),
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Empleados;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        $cargos = Cargos::model()->findAll();

		if(isset($_POST['Empleados']))
		{
			$model->attributes=$_POST['Empleados'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

        $c = Contratos::model()->findByAttributes(array('id_empleado' => $model->id));
        $model->cargo = $c->id_cargo;
		if(isset($_POST['Empleados']))
		{
			$model->attributes=$_POST['Empleados'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model

		));
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
          $c = Contratos::model()->findByAttributes(array('id_empleado' => $id));
          $c->delete();
          $this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	public function actionDeleteAusentismo($ausente)
	{
		if(Yii::app()->request->isPostRequest)
		{

			$transaction=Yii::app()->db->beginTransaction();
			try{

				$c = Empleados::model()->findByPk($ausente);
	            
	            $reemplazo = $c->reemplazo;


	            $total = Yii::app()->db->createCommand("update 
							orden 
							set id_usuario_reemplazado = null, 
							usuario_actual = id_usuario_reemplazado 
							where 
							id_usuario_reemplazado = $ausente and 
							usuario_actual = $reemplazo")->execute();

	            $c->setScenario("reemplazo");
	            $c->reemplazo = null;
	            $c->save();

	            if(!isset($_GET['ajax']))
            		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

				$transaction->commit();
			}catch(Exception $e){
				echo $e;
				$transaction->rollback();
			}
			// we only allow deletion via POST request
          


			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
          
		}
		
        else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Empleados');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//$this->layout = '//layouts/listar';
		$model=new Empleados('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Empleados']))
			$model->attributes=$_GET['Empleados'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionAusentismo()
	{
		$this->layout = '/layouts/main_fix';
		$model=new Empleados('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Empleados']))
			$model->attributes=$_GET['Empleados'];

        if(isset($_POST['ausente_id']) && isset($_POST['reemplazo_id'])){
            
          $transaction=Yii::app()->db->beginTransaction();
          try{
            $ausente = Empleados::model()->findByPk($_POST['ausente_id']);
            $ausente->reemplazo = $_POST['reemplazo_id'];
            $ausente->setScenario("reemplazo");
            $ausente->save();
            $cuales = Orden::model()->findAll(array('condition' => 'usuario_actual = :u and paso_wf != :p',
                                                    'params'    => array(":u" => $_POST['ausente_id'],
                                                                         ":p" => "swOrden/llenaroc")
                                                    ));
            $emails = $this->generarEmails($cuales,$_POST['reemplazo_id']);
                                                       
            $cuantas = Orden::model()->updateAll(array('usuario_actual' => $_POST['reemplazo_id'],
            										   'id_usuario_reemplazado' => $_POST['ausente_id']),
                                                 "usuario_actual = :u",
                                                 array(":u" => $_POST['ausente_id']));

            $transaction->commit();

            foreach($emails as $e){
              Yii::app()->mailer->compraAsignada($e['email'], 
                                                 $e['nombre_compra'], 
                                                 $e['estado'], 
                                                 $e['id_compra'],
                                                 $e['url']);
            }

          }catch (Exception $e){
            $transaction->rollback();
            throw new CHttpException(500, "No se pudo hacer el reemplazo");
          }

            

          if(count($ausente->errors)>0){
            throw new CHttpException(500, "No se pudo hacer el reemplazo");
          }else{
            Yii::app()->user->setFlash("success", "El reemplazo fue creado con éxito. 
                                        Se reasignaron $cuantas solicitudes de compra");
          }

        }

		$this->model = $model;
		$this->render('ausentismos',array(
			'model'=>$model,
		));
	}


    public function generarEmails($ordenes,$usuario_nuevo){
      $emp = Empleados::model()->findByPk($usuario_nuevo);
      $emails = array();
      foreach($ordenes as $n => $o){
        $emails[$n] = array(
                            'email' => $emp->email,
                            'nombre_compra' => $o->nombre_compra,
                            'estado' => $o->proximoPaso($o->paso_wf),
                            'id_compra' => $o->id,
                            'url' => $o->urlMail()
                            );
      }

      return $emails;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Empleados::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='empleados-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
