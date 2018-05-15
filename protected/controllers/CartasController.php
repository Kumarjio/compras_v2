<?php

class CartasController extends Controller
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
				'actions'=>array('create','update','delete','search','admin','creaRespuesta','cargaCiudades','editaRespuesta','punteoFisicas','consultaRegistros','punteoExcel','punteoExcel472','punteo','impresion','activaImpresion','generaImpresion','consultaRegistrosImp','punteoExcelImp','punteoExcel472Imp'),
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
		if(isset($_POST['Cartas']))
		{
			
			$model->attributes=$_POST['Cartas'];
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
				$total = Cartas::model()->findAll($c);
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
		$model=new Cartas;

		
		if(Yii::app()->request->isAjaxRequest){
			$this->_ajaxyForm($model);
		}else{
			
			if(isset($_POST['Cartas']))
			{
				$model->attributes=$_POST['Cartas'];
				if($model->save())
					$this->redirect(array('admin'));
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
			if(isset($_POST['Cartas']))
			{
				$model->attributes=$_POST['Cartas'];
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
		$model=new Cartas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cartas']))
			$model->attributes=$_GET['Cartas'];

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
		$model=Cartas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionCreaRespuesta(){
		if(Yii::App()->request->isAjaxRequest){
			$model = new Cartas;
			$aux = true;
			if(isset($_POST['Cartas'])){
				$model->attributes = $_POST['Cartas'];

				if($model->save()){
					$aux = true;
					$cartas = Cartas::model()->findAllByAttributes(array("na"=>$model->na, 'id_trazabilidad'=>$model->id_trazabilidad));

					if($cartas){
						foreach ($cartas as $carta){
							$carta->carta = $model->carta;
							$carta->update();
						}
					}
				}else{
					$aux = false;
				}
			}else{
				if( !empty($_POST['na']) && !empty($_POST['id_traza']) && !empty($_POST['carta']) && !empty($_POST['id_plantilla']) ){
					$model->na = $_POST['na'];			
					$model->id_trazabilidad = $_POST['id_traza'];
					$model->carta = $_POST['carta'];
					$model->id_plantilla = $_POST['id_plantilla'];
					
					$total = Cartas::model()->countByAttributes(array("id_trazabilidad"=>$model->id_trazabilidad, "principal"=>"Si"));
					if($total == 0){
						$model->principal = "Si";
						$modelRec = Recepcion::model()->findByPk($model->na);
						$persona = EmpresaPersona::model()->findByAttributes(array("documento"=>$modelRec->documento));
						if($persona){
							$model->nombre_destinatario = strtoupper($persona->razon);
						}
						if($modelRec->tipo_documento == 2){
							$mail = MailRecepcion::model()->findByAttributes(array("na"=>$modelRec->na));
							$model->correo = $mail->mail;
						}						
					}else{
						$model->principal = "No";
					}
				}
			}		
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_createRespuesta', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_createRespuesta', array('model' => $model), true, true)));
			}
		}
	}
	public function actionEditaRespuesta(){
		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			if(isset($_POST['Cartas'])){
				$model = Cartas::model()->findByPk($_POST['Cartas']['id']);
				$model->attributes = $_POST['Cartas'];

				if($model->save()){
					$aux = true;
					$cartas = Cartas::model()->findAllByAttributes(array("na"=>$model->na, 'id_trazabilidad'=>$model->id_trazabilidad));

					if($cartas){
						foreach ($cartas as $carta){
							$carta->carta = $model->carta;
							$carta->update();
						}
					}
				}else{
					$aux = false;
				}
			}else{
				$id = $_POST["id"];
				$carta = $_POST['carta'];
				$id_plantilla = $_POST['id_plantilla'];
				$model = Cartas::model()->findByPk($id);
				$model->carta = $carta;
				$model->id_plantilla = $id_plantilla;
				$model->departamento = $model->idCiudad->id_departamento;
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_editaRespuesta', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_editaRespuesta', array('model' => $model), true, true)));
			}
		}
	}
	public function actionCargaCiudades(){
		$departamento = $_POST['departamento'];
		$id_ciudad = $_POST['id_ciudad'];

		if(!empty($departamento)){

			$ciudades = CHtml::listData(Ciudad::model()->findAll('id_departamento = :id', array(':id'=>$departamento)),'id_ciudad','nombre_ciudad');

		 	echo CHtml::tag('option',array('value'=>''),'Seleccione',true);
			if($ciudades){
				foreach ($ciudades as $id => $ciudad) {
					 if($id_ciudad == $id)
	                    echo CHtml::tag('option',array('value'=>$id, 'selected' => 'selected'),CHtml::encode($ciudad), true);
	                else
	                    echo CHtml::tag('option',array('value'=>$id),CHtml::encode($ciudad),true);
				}
			}	
		}else{
			echo CHtml::tag('option',array('value'=>''),'Seleccione',true);
		}
	}
	public function actionPunteoFisicas()
	{
		$model = new Cartas('search');
		$model->unsetAttributes();
		$model->id_tipo_entrega = 2;
		if(isset($_POST['Cartas']))
			$model->attributes = $_POST['Cartas'];

		$this->render('punteoFisicas',array(
			'model'=>$model,
		));
	}
	public function actionConsultaRegistros()
	{
		$consulta = Cartas::model()->findAllByAttributes(array("punteo"=>2, "id_tipo_entrega"=>2));
		if($consulta){
			die("ok");
		}else{
			die;
		}
	}
	public function actionPunteoExcel()
	{
		$model = Cartas::consultaExcel();
		if($model){
			$this->renderPartial('_punteo_excel',array('model'=>$model));
		}else{
			return false;	
		}
	}
	public function actionPunteoExcel472()
	{
		$courrier_472 = Cartas::consultaExcel472();
		if($courrier_472){
			$this->renderPartial('_punteo_exel_472',array('model'=>$courrier_472));
		}else{
			return false;
		}
	}
	public function actionPunteo()
	{
		if(Yii::App()->request->isAjaxRequest){
			$id = $_POST["id"];
			$model = Cartas::model()->findByAttributes(array("id"=>$id));
			$actualiza = Cartas::model()->updateAll(array('punteo'=>'2'),'id ='.$id);
			if($model){
				echo "<h5 align='center'>Carta punteada $model->id del Caso $model->na.</h5>";
			}else{
				echo "<h5 class='red' align='center'>Error al puntear la carta</h5>";
			}
		}
	}
	public function actionImpresion()
	{
		$model=new Cartas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['Cartas']))
			$model->attributes=$_POST['Cartas'];

		$this->render('_impresion',array(
			'model'=>$model,
		));
	}
	public function actionActivaImpresion()
	{
		if(Yii::App()->request->isAjaxRequest){
			$id_carta = $_POST["id_carta"];
			$model = Cartas::model()->findByPk($id_carta);
			if($model){
				$model->fecha_impresion = "now()";
				$model->impreso = 1;
				$model->departamento = $model->idCiudad->id_departamento;
				if($model->save()){
					echo "<h5 align='center'>Carta activa para impresión del Caso <b> $model->na</b>.</h5>";
				}else{
					echo "<h5 class='red' align='center'>Error al puntear la carta.</h5>";
				}				
			}else{
				echo "<h5 class='red' align='center'>Error al puntear la carta.</h5>";
			}
		}
	}
	public function actionGeneraImpresion()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('id_tipo_entrega = 2');
		$criteria->addCondition('punteo = 1');
		$criteria->addCondition('impreso = 1');
		$criteria->addInCondition('id_firma', array(1, 3));
		$cartas = Cartas::model()->findAll($criteria);

		if($cartas){
			$imagen = dirname(__FILE__).'/../images/';
			$ruta = '/vol2/img04/archivos_tmp/';
			$nombre_archivo = 'tmp_'.$this->id.'.pdf';
			$mPDF1 = Yii::app()->ePdf->mpdf();

			foreach($cartas as $carta){
				$mPDF1->WriteHTML($carta->carta);
				if($carta !== end($cartas)){
			        $mPDF1->AddPage();
			    }        		
        		$carta->impreso = 2;
        		$carta->departamento = $carta->idCiudad->id_departamento;
        		$carta->save();
			}
			$mPDF1->Output($ruta.$nombre_archivo, 'F');
			$path = 'http://'.$_SERVER['HTTP_HOST'].'/img04/archivos_tmp/'.$nombre_archivo;

			echo "<h5 align='center'>Impresión de cartas generada correctamente:</h5><br><div align='center'>".CHtml::link('<img src="/images/pdf.png" width="27px" height="27px">',$path, array('target'=>'_blank'))."</div>";
		}else{
			echo "<h5 class='red' align='center'>No se encontrarón cartas para generar impresión.</h5>";
		}
	}
	public function actionConsultaRegistrosImp()
	{
		$consulta = Cartas::model()->findAllByAttributes(array("impreso"=>2));
		if($consulta){
			die("ok");
		}else{
			die;
		}
	}
	public function actionPunteoExcelImp()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('id_tipo_entrega = 2');
		$criteria->addCondition('impreso = 2');
		$criteria->addCondition('id_proveedor = 2');
		$criteria->addInCondition('id_firma', array(1, 3));
		$model = Cartas::model()->findAll($criteria);

		if($model){
			$this->renderPartial('_punteo_excel',array('model'=>$model));
			Cartas::model()->updateAll($criteria, 'impreso = 3');
		}else{
			return false;	
		}
	}
	public function actionPunteoExcel472Imp()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('id_tipo_entrega = 2');
		$criteria->addCondition('impreso = 2');
		$criteria->addCondition('id_proveedor = 1');
		$criteria->addInCondition('id_firma', array(1, 3));
		$courrier_472 = Cartas::model()->findAll($criteria);

		if($courrier_472){
			$this->renderPartial('_punteo_exel_472',array('model'=>$courrier_472));
			Cartas::model()->updateAll($criteria, 'impreso = 3');
		}else{
			return false;
		}
	}
}
