<?php

class EmpleadosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','search','admin','ausentismo','deleteausentismo'),
				'users'=>array('@'),
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
		if(isset($_POST['Empleados']))
		{
			
			$model->attributes=$_POST['Empleados'];
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
				$c->condition = "nombre_completo like :a";
				$c->params = array(":a" => '%'.strtoupper($_GET['query']).'%');
				$total = Empleados::model()->findAll($c);
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
	public function actionCreate()
	{
		$model=new Empleados;

		
		if(Yii::app()->request->isAjaxRequest){
			$this->_ajaxyForm($model);
		}else{
			
			if(isset($_POST['Empleados']))
			{
				$model->attributes=$_POST['Empleados'];
				if($model->save())
					$this->redirect(array('admin'));
			}

			$this->render('create',array(
				'model'=>$model,
			));
	    }
		
	}

	public function actionAusentismo()
	{
		$this->layout = '//layouts/listar';
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
            $cuales = Viaje::model()->findAll(array('condition' => 'usuario_actual = :u and solicitante != :u and paso_wf != :p and paso_wf != :o',
                                                    'params'    => array(":u" => $_POST['ausente_id'],
                                                                         ":p" => "swViaje/solicitar_viaje",
                                                                         ":o" => "swViaje/vencido")
                                                    ));
            
            //Es un jefe reemplazado por el gerente
            if($_POST['reemplazo_id'] == $ausente->id_gerente){
            	$cuantas = Viaje::model()->updateAll(array('usuario_actual' => $_POST['reemplazo_id'],
	            										   'id_usuario_reemplazado' => $_POST['ausente_id'],
	            										   'paso_wf' => 'swViaje/segunda_instancia'),
	                                                 	   "usuario_actual = :u and solicitante != :u and paso_wf != :p and paso_wf != :o",
	                                                 	   array(":u" => $_POST['ausente_id'],
	                                                 	   		 ":p" => "swViaje/solicitar_viaje",
	                                                             ":o" => "swViaje/vencido"));

            }else{                                   
	            $cuantas = Viaje::model()->updateAll(array('usuario_actual' => $_POST['reemplazo_id'],
	            										   'id_usuario_reemplazado' => $_POST['ausente_id']),
	                                                 	   "usuario_actual = :u and solicitante != :u and paso_wf != :p and paso_wf != :o",
	                                                 	   array(":u" => $_POST['ausente_id'],
	                                                 	   		 ":p" => "swViaje/solicitar_viaje",
	                                                             ":o" => "swViaje/vencido"));
	        }

            $transaction->commit();

            $emails = $this->enviarEmails($cuales,$_POST['reemplazo_id']);

          }catch (Exception $e){
            $transaction->rollback();
            throw new CHttpException(500, "No se pudo hacer el reemplazo");
          }

            

          if(count($ausente->errors)>0){
            throw new CHttpException(500, "No se pudo hacer el reemplazo");
          }else{
            Yii::app()->user->setFlash("success", "El reemplazo fue creado con éxito. 
                                        Se reasignaron $cuantas solicitudes de viaje");
          }

        }

		$this->model = $model;
		$this->render('ausentismos',array(
			'model'=>$model,
		));
	}

	public function enviarEmails($viajes,$usuario_nuevo){
      
      $emp = Empleados::model()->findByPk($usuario_nuevo);

      foreach($viajes as $n => $o){
      	$url = sprintf("%s%s/viaje/update?id=%d",
      	 				Yii::app()->getRequest()->getHostInfo(), 
      	 	            Yii::app()->getRequest()->getScriptUrl(),
      	 	            $o->id);

      	$estados = SWHelper::allStatuslistData($o);

      	$estado = $estados[$o->paso_wf];

    	$body = $this->renderPartial("//viaje/_emailview", 
    												  array('model'=>$o, 
    												  	    'url' => $url, 
    												  	    'estado' => $estado),
    												  		true);

		Yii::app()->mailer->enviarCorreo($emp->email,$o->asuntoReal("Nuevo viaje asignado"),$body);
        
      }

    }

    public function actionDeleteAusentismo($ausente)
	{
		if(Yii::app()->request->isPostRequest)
		{

			$transaction=Yii::app()->db->beginTransaction();
			try{

				$c = Empleados::model()->findByPk($ausente);
	            
	            $reemplazo = $c->reemplazo;

	            //Entonces es un jefe reemplazado por gerente
	            if($reemplazo == $c->id_gerente){
	            	//Le cambiamos el paso a primera instancia (pues el jefe ya llegó)
	            	$total = Yii::app()->db->createCommand("update 
							viajes.viaje 
							set id_usuario_reemplazado = null, 
							usuario_actual = id_usuario_reemplazado,
							paso_wf = 'swViaje/primera_instancia' 
							where 
							id_usuario_reemplazado = $ausente and 
							usuario_actual = $reemplazo")->execute();
	            }else{

	            $total = Yii::app()->db->createCommand("update 
							viajes.viaje 
							set id_usuario_reemplazado = null, 
							usuario_actual = id_usuario_reemplazado 
							where 
							id_usuario_reemplazado = $ausente and 
							usuario_actual = $reemplazo")->execute();
	           	}

	            $c->setScenario("reemplazo");
	            $c->reemplazo = null;
	            $c->save();

	            $transaction->commit();

	            $cuales = Viaje::model()->findAll(array('condition' => 'usuario_actual = :u and paso_wf != :p and paso_wf != :o',
                                                    'params'    => array(":u" => $ausente,
                                                                         ":p" => "swViaje/solicitar_viaje",
                                                                         ":o" => "swViaje/vencido")
                                                    ));

	            $emails = $this->enviarEmails($cuales,$ausente);

	            if(!isset($_GET['ajax']))
            		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

				
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
			if(isset($_POST['Empleados']))
			{
				$model->attributes=$_POST['Empleados'];
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
		$model=new Empleados('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Empleados']))
			$model->attributes=$_GET['Empleados'];

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
		$model=Empleados::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El registro que está buscando no existe.');
		return $model;
	}

}
