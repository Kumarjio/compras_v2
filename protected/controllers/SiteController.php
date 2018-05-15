<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
      //Yii::app()->mailer->sendDocumentos("santios@gmail.com");
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
			   if($_SERVER['PHP_AUTH_USER'] !=""){
		   $usuario= $_SERVER['PHP_AUTH_USER'];
		   if(Yii::app()->params->development == 1){
				$form = new LoginFormDev;
				$post = $_POST['LoginFormDev'];
				$auth = array();
				// collect user input data
				if(isset($post))
				{
					$form->attributes=$post;
					// validate user input and redirect to previous page if valid
					if($form->validate()){
						  $auth = $form->authenticate();
						if(!is_array($auth))
						  if(isset(Yii::app()->user->returnUrl)){
							$this->redirect(Yii::app()->user->returnUrl);
						  }else{
							$this->redirect($this->createUrl('orden/admin'));
						  }
					}
				}
				$this->render('logindev',array('form'=>$form, 'auth'=>$auth));
			}else{
				$authDA = $this->autenticarDA($usuario);
				if($authDA[AutenticarUsuarioDAResult]){
					
				  if(isset(Yii::app()->user->returnUrl) and Yii::app()->user->returnUrl!="site/login"){
					$this->redirect(Yii::app()->user->returnUrl);
				  }else{
					$this->redirect($this->createUrl('orden/admin'));
				  }
				}
			}
		}else{
			if(!Yii::app()->user->isGuest){
				$this->redirect($this->createUrl('site/index'));
			}
			if(Yii::app()->params->development == 1){
				$form = new LoginFormDev;
				$post = $_POST['LoginFormDev'];
			}else{
				$form=new LoginForm;
				$post = $_POST['LoginForm'];
			}
			$auth = array();
			  // collect user input data
			  if(isset($post))
			{
				  $form->attributes=$post;
				  // validate user input and redirect to previous page if valid
				if($form->validate()){
					  $auth = $form->authenticate();
					if(!is_array($auth))
					  if(isset(Yii::app()->user->returnUrl)){
						$this->redirect(Yii::app()->user->returnUrl);
					  }else{
						$this->redirect($this->createUrl('orden/admin'));
					  }
				  }
			}
			  // display the login form
			  if(Yii::app()->params->development == 1){
				$this->render('logindev',array('form'=>$form, 'auth'=>$auth));
			  }else{
				$this->render('login',array('form'=>$form, 'auth'=>$auth));
			  }
		}
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function autenticarDA($username){

		$identity=new UserIdentityDA($username);
		$arreglo = $identity->authenticateDA();
		  switch($identity->errorCode)
		{
		case UserIdentity::ERROR_NONE:
	  $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
		  Yii::app()->user->login($identity,$duration);
		  break;
		case UserIdentity::ERROR_GRAVE_AUTH:
		  return $arreglo;
		  break;
		case UserIdentity::ACCION_O_CONTINUAR:
		  Yii::app()->user->login($identity,$duration);
		  return $arreglo;
		  break;
		case UserIdentity::REQUIERE_ACCION_USUARIO:
		  return $arreglo;
		  break;
		case UserIdentity::NO_EXISTE_EMPLEADO:
		  $error="No se encuentra registrado como empleado. Favor contactar al administrador del sitio.";
		  return $arreglo;
		  break;
		default: // UserIdentity::ERROR_PASSWORD_INVALID
		  $error='Password is incorrect.';
		  break;
		}
   }
}