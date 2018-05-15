<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Imagine',
	'language' => 'es',
	//'defaultController' => 'paciente/paciente/create',
	'defaultController' => 'orden/admin',
	// preloading 'log' component
	'preload'=>array('log','bootstrap','yiibooster'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.simpleWorkflow.*',
		'application.components.behavior.*',
        'application.components.tcpdf2.*',
        'application.extensions.select2.*',
        'application.extensions.tinymce.*',
        'application.extensions.xheditor.*',
        'application.extensions.EExcelView.*',
        'ext.pdffactory.*',
        'application.pdf.docs.*',
        'application.modules.facturacion.models.*'
	),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		//'administracion',
		'facturacion',
		'reportico' => array(),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'imagine2017*',
			'ipFilters'=>array('*'),
			'generatorPaths'=>array(
				'ext.yiibooster.gii',
			),
		),
	),
	// application components
	'components'=>array(
		'mailer' => array(
			  'class' => 'application.extensions.SMailSender',
			  ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
			//'loginRequiredAjaxResponse' => 'Inicio de sesión necesario'
		),
		'metadata'=>array('class'=>'Metadata'),
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap',
			'coreCss' => false,
			'yiiCss' => false // assuming you extracted bootstrap under extensions
		),
		'yiibooster'=>array(
			'class'=>'ext.yiibooster.components.Booster',
			'coreCss' => false,
			'yiiCss' => false // assuming you extracted bootstrap under extensions
		),
		'swSource'=> array(
			'class'=>'application.extensions.simpleWorkflow.SWPhpWorkflowSource',
		),
		'ETinyMce'=> array(
			'class'=>'application.extensions.tinymce.ETinyMce',
		),
		'EExcelView'=> array(
			'class'=>'application.extensions.EExcelView.EExcelView',
		),
		'dompdf'=>array(
			'class'=>'ext.yiidompdf.yiidompdf',
		),
		'ePdf' => array(
	        'class' => 'ext.yii-pdf.EYiiPdf',
	        'params' => array(
	            'mpdf' => array(
	                'librarySourcePath' => 'application.vendors.mpdf.*',
	                'constants'         => array(
	                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
	                ),
	                'class'=>'mpdf',
	            ),
	        ),
	    ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules' => array('<controller:\w+>/<action:\w+>' => '<controller>/<action>')
        ),
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString'=>'pgsql:host=127.0.0.1;port=5432;dbname=workflow',
			'username' => 'postgres',
			'password' => 'imagineLinux2017*',
			'schemaCachingDuration'=>86400, 
		),
		/*
		'dbSandiego'=>array(
			'class' => 'CDbConnection',
   			'connectionString' => 'dblib:host=190.0.57.106:2433;dbname=Prueba_Sandiego',
   			//'connectionString' => 'mssql:host=190.0.57.106:2433;dbname=Prueba_Sandiego',
   			//'connectionString' => 'sqlsrv:Server=190.0.57.106:2433;Database=Prueba_Sandiego',
      		'username' => 'imagine',
      		'password' => '!w@9!n32016*',
		),*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'development' => 0,
		'test' => 0
	),
	
);
