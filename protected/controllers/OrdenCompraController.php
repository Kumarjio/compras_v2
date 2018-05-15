<?php

class OrdenCompraController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
                  'actions'=>array('create','update','admin', 'print'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
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
		$model=new OrdenCompra;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrdenCompra']))
		{
			$model->attributes=$_POST['OrdenCompra'];
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

		if(isset($_POST['OrdenCompra']))
		{
			$model->attributes=$_POST['OrdenCompra'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('OrdenCompra');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id_orden)
	{
		$this->layout = '//layouts/listar';
		$model=new OrdenCompra('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenCompra']))
			$model->attributes=$_GET['OrdenCompra'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
			'id_orden' => $id_orden
		));
	}

    public function actionPrint($id){

      $model = $this->loadModel($id);
      $pdf = new mypdf('P', 'mm', 'Letter', true, 'UTF-8');
      $this->ocpdf($pdf, $model);
      $pdf->Output();
    }

    public function ocpdf(&$pdf, $model) {

        $pdf->SetTextColor(0, 0, 0);
        $pdf->setPrintHeader(true);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        $doc = DetalleOrdenCompraOp::model()->findByAttributes(array('id_orden_compra' => $model->id));
        if($doc->id_cotizacion_om != "")
          $marco = true;
        else
          $marco = false;
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFillColor(255, 255, 255);
        //$pdf->SetFont('helvetica', 'B', 10);
        //$pdf->Text(20, 30, date("j") . " - " . date('m') . " - " . date("Y"));
        $pdf->SetFont('helvetica', 'B', 20);
        $format = '%1$03d';
        $consecutivo = sprintf($format, count($doc));
        $pdf->Text(70, 40, "Orden de compra #".$model->orden->id."-".$consecutivo);
        
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Text(20, 55, "Fecha Orden de Compra:");
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Text(20, 60, date('Y-m-d'));

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Text(20, 70, "Proveedor:");
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Text(20, 75, $doc->idProveedor->razon_social);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Text(20, 85, "NIT:");
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Text(20, 90, $doc->id_proveedor);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Text(20, 100, "Nombre Contacto:");
        $pdf->SetFont('helvetica', '', 10);

        $pdf->Text(20, 105, $marco ? $doc->idCotizacionOm->idContacto->id : $doc->idCotizacion->idContacto->id." ".$marco ? $doc->idCotizacionOm->idContacto->apellido : $doc->idCotizacion->idContacto->apellido);
        if($marco){
          if($doc->idCotizacionOm->idContacto->email != "notiene@notiene.com"){
              $tam_name = strlen($doc->idCotizacionOm->idContacto->nombre." ".$doc->idCotizacionOm->idContacto->apellido);
              $pdf->Text(50 + $tam_name, 105, "(".$doc->idCotizacionOm->idContacto->email.")");
          }
        }
        else{
          if($doc->idCotizacion->idContacto->email != "notiene@notiene.com"){
              $tam_name = strlen($doc->idCotizacion->idContacto->nombre." ".$doc->idCotizacion->idContacto->apellido);
              $pdf->Text(50 + $tam_name, 105, "(".$doc->idCotizacion->idContacto->email.")");
          }
          
        }


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Text(20, 115, "Ciudad:");
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Text(20, 120, $marco ? $doc->idCotizacionOm->idContacto->ciudad :  $doc->idCotizacion->idContacto->ciudad);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Text(20, 130, "Telefono:");
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Text(20, 135, $marco ? $doc->idCotizacionOm->idContacto->telefono :  $doc->idCotizacion->idContacto->telefono);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Text(20, 145, "Celular:");
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Text(20, 150, $marco ? $doc->idCotizacionOm->idContacto->celular :  $doc->idCotizacion->idContacto->celular);

        $y = 165;
        $total = 0;
        $detalle_orden = DetalleOrdenCompraOp::model()->findAllByAttributes(array('id_orden_compra' => $model->id));
        foreach($detalle_orden as $do){
          if($do->id_cotizacion_om != "")
            $marco = true;
          else
            $marco = false;
          $pdf->SetFont('helvetica', 'B', 15);
          $pdf->Text(20, $y, $do->idProducto->nombre .":");
          $this->increaseY($y, $pdf, 10);

          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Número de Cotización:");
          $this->increaseY($y, $pdf, 5);
          $pdf->SetFont('helvetica', '', 10);
          if($marco)
            $pdf->Text(20, $y, ($do->idCotizacionOm->numero == null or $do->idCotizacionOm->numero == '')?'N/A':$do->idCotizacionOm->numero);
          else
            $pdf->Text(20, $y, ($do->idCotizacion->numero == null or $do->idCotizacion->numero == '')?'N/A':$do->idCotizacion->numero);
          $this->increaseY($y, $pdf, 5);

          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Descripción:");
          $y += 5;
          $pdf->SetFont('helvetica', '', 10);
          $lines = str_split($do->idOrdenProducto->detalle, 115);
          foreach($lines as $line){
            $pdf->Text(20, $y, $line);
            $this->increaseY($y, $pdf, 5);
          }

          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Cantidad:");
          $this->increaseY($y, $pdf, 5);
          $pdf->SetFont('helvetica', '', 10);
          $pdf->Text(20, $y, $do->cantidad);
          $this->increaseY($y, $pdf, 5);

          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Valor Unitario:");
          $this->increaseY($y, $pdf, 5);
          $pdf->SetFont('helvetica', '', 10);
          if($marco)
            $pdf->Text(20, $y, str_replace(".000","","$".number_format($do->idCotizacionOm->valor_unitario, 3)));
          else
            $pdf->Text(20, $y, str_replace(".000","","$".number_format($do->idCotizacion->valor_unitario, 3)));
          $this->increaseY($y, $pdf, 5);

          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Valor Total (Producto/Direccion):");
          $this->increaseY($y, $pdf, 5);
          $pdf->SetFont('helvetica', '', 10);
          if($marco)
            $pdf->Text(20, $y, str_replace(".000","","$".number_format($do->idCotizacionOm->valor_unitario * $do->cantidad, 3)));
          else
            $pdf->Text(20, $y, str_replace(".000","","$".number_format($do->idCotizacion->valor_unitario * $do->cantidad, 3)));
          $this->increaseY($y, $pdf, 5);

          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Moneda:");
          $this->increaseY($y, $pdf, 5);
          $pdf->SetFont('helvetica', '', 10);
          if($marco)
            $pdf->Text(20, $y, $do->idCotizacionOm->moneda.(($do->idCotizacionOm->moneda != "Peso")?(", TRM: $".$do->idCotizacionOm->trm):""));
          else  
            $pdf->Text(20, $y, $do->idCotizacion->moneda.(($do->idCotizacion->moneda != "Peso")?(", TRM: $".$do->idCotizacion->trm):""));
          $this->increaseY($y, $pdf, 5);
          if($marco)
          
          $total += ($do->idCotizacion->valor_unitario * $do->cantidad * $do->idCotizacion->trm);
          if($marco)
            $pagos = OmCotizacionPagos::model()->findAllByAttributes(array('id_om_cotizacion' => $do->id_cotizacion_om));
          else
            $pagos = CotizacionPagosOp::model()->findAllByAttributes(array('id_cotizacion_op' => $do->id_cotizacion));
          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Forma de Pago:");
          $this->increaseY($y, $pdf, 5);
          $pdf->Text(20, $y, "Tipo");
          $pdf->Text(40, $y, "Porcentaje");
          $pdf->Text(70, $y, "Observación");
          $this->increaseY($y, $pdf, 5);
          foreach($pagos as $pago){
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Text(20, $y, $pago->tipo);
            $pdf->Text(40, $y, $pago->porcentaje."%");
            $pdf->Text(70, $y, $pago->observacion);
            $this->increaseY($y, $pdf, 5);
          }
          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Fecha de Entrega:");
          $this->increaseY($y, $pdf, 5);
          $pdf->SetFont('helvetica', '', 10);
          $pdf->Text(20, $y, $do->fecha_entrega);
          $this->increaseY($y, $pdf, 5);

          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Direccion de Entrega:");
          $this->increaseY($y, $pdf, 5);
          $pdf->SetFont('helvetica', '', 10);
          $pdf->Text(20, $y, $do->idOrdenProducto->direccion_entrega.', '.$do->idOrdenProducto->ciudad.', '.$do->idOrdenProducto->departamento);
          $this->increaseY($y, $pdf, 5);

          $pdf->SetFont('helvetica', 'B', 10);
          $pdf->Text(20, $y, "Contacto:");
          $this->increaseY($y, $pdf, 5);
          $pdf->SetFont('helvetica', '', 10);
          $pdf->Text(20, $y, $do->idOrdenProducto->responsable.'  -  Telefono: '.$do->idOrdenProducto->telefono);
          $this->increaseY($y, $pdf, 5);

        }
        $this->increaseY($y, $pdf, 10);
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Text(20, $y, "Valor Total (Orden de Compra) en pesos:");
        $pdf->SetFont('helvetica', '', 15);
        $pdf->Text(130, $y, str_replace(".000","","$".number_format($total, 3)));
        $this->increaseY($y, $pdf, 15);
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Text(20, $y, "Observaciones:");
        $this->increaseY($y, $pdf, 5);
        $pdf->SetFont('helvetica', '', 9);
        $observaciones = array();
        $observaciones[] = '• La factura debe hacerse a nombre de TUYA S.A, nit 860.032.330-3,  la factura se debe enviar a la calle 4 sur numero ';
        $observaciones[] = '43 A 109, Medellín, Contacto: '. $model->orden->idUsuario->nombre_completo .', Teléfono 3198210.';
        $observaciones[] = '• Las condiciones pactadas en esta orden de compra, en cuanto a especificaciones, cantidades, precios, pagos y plazos ';
        $observaciones[] = 'de entrega, no podrán ser modificadas unilateralmente.';
        $observaciones[] = '• La entrega de la mercancía debe efectuarse dentro de la fecha límite pactada previamente.  Si en la fecha no se ha ';
        $observaciones[] = 'cumplido con la entrega, TUYA se reserva el derecho de cancelar esta orden de compra o prorrogar el plazo.';
        $observaciones[] = '• Toda mercancía que no cumpla con las especificaciones indicadas en esta orden de compra, con la calidad debidamente ';
        $observaciones[] = 'aprobada por TUYA, o con el empaque convenido, será devuelta por cuenta y riesgo del proveedor.  En este caso TUYA se ';
        $observaciones[] = 'reserva el derecho de cancelar la orden de compra, o prorrogar el plazo para su reposición.';
        $observaciones[] = '• La mercancía viajara siempre por cuenta y riesgo del proveedor, hasta el momento en el cual TUYA firme algún documen-';
        $observaciones[] = 'to como constancia de recibo de la misma.  Solo se aceptara pago de fletes, cuando aparezca como condición pactada ';
        $observaciones[] = 'previamente.';
        $observaciones[] = '• La mercancía debe llegar siempre acompañada de remisión y lista de empaque, en la cual se debe citar claramente: ';
        $observaciones[] = 'Nombre o razón social del proveedor, cantidad entregada y descripción del artículo.';
        $observaciones[] = '• Para el tramite interno de las facturas es indispensable que se reúna los siguientes requisitos: Cumplir con todas las ';
        $observaciones[] = 'normas tributarias relacionadas con la facturación, vigentes a la fecha de la expedición de la factura., deberán llegar ';
        $observaciones[] = 'acompañadas del original de la remisión firmada y sellada por quien recibe la mercancía.  Los pagos se efectuaran de ';
        $observaciones[] = 'acuerdo con las políticas de pago y solo sobre las facturas originales, no se efectuaran pagos parciales, si estos no estaban ';
        $observaciones[] = 'previamente establecidos. La factura generada debe tener el numero de orden de compra.';
        $observaciones[] = '• Para el pago de la factura es indispensable tener actualizado el registro de proveedor según formatos y requisitos ';
        $observaciones[] = 'entregados por TUYA.';
        $observaciones[] = '• Fecha máxima de recepción de factura día 23 de cada mes, exceptuando diciembre que es el 15.';
        
        foreach($observaciones as $observacion){
          $pdf->Text(20, $y, $observacion);
          $this->increaseY($y, $pdf, 4);
        }

    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */

    public function increaseY(&$y, &$pdf, $num){
      $y += $num;
      if($y >= 230) {
        $pdf->AddPage('P', 'Letter');
        $y = 30;
      }
    }
	public function loadModel($id)
	{
		$model=OrdenCompra::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='orden-compra-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
