<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $breadcrums;
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
	public function actionIndex(){
		$model= new Recepcion();
		$this->render('index',array('model'=>$model));
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
	 * Displays the login page
	 */
	public function actionLogin()
	{
	  //if(Yii::app()->user->isGuest)
	    //$this->redirect($this->createUrl('agendamiento'));
	  /*
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
	  */
	  
		if(!Yii::app()->user->isGuest){
			$this->redirect($this->createUrl('site/index'));
		}
        $form = new LoginForm;

        if(isset($_POST['LoginForm'])){

            $form->attributes = $_POST['LoginForm'];
            //$form->username = strtolower($form->username);

          	if($form->validate() && $form->login()){
              	$this->redirect(Yii::app()->user->returnUrl);
          	}
        }
        $this->render('login',array('form'=>$form));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}