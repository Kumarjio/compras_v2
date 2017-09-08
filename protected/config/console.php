<?php
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return 
  array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Console Application',
    // application components
    'import'=>array(
      'application.models.*',
      'application.components.*',
      'application.extensions.simpleWorkflow.*',
      'application.components.behavior.*',
      'application.commands.RenderReadyConsoleCommand'    
    ),
    'modules'=>array(
      // uncomment the following to enable the Gii tool
      'administracion',
      'agendamiento',
      'paciente',
      'callcenter',
      'citas',
      'admisiones',
      'medicos',
    ),
    'components'=>array(
      'mailer' => array(
        'class' => 'application.extensions.SMailSender',
      ),
      'db'=>array(
        'class'=>'CDbConnection',
        'connectionString'=>'pgsql:host=127.0.0.1;port=5432;dbname=img000',
        'username' => 'postgres',
        'password' => 'Imagine&*Linu',
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
      'whatsapp'=>array(
        'class'=>'ext.mensajeria.whatsapp'
      ),
      'acortarUrl'=>array(
        'class'=>'ext.Googl'
      ),
      'metadata'=>array('class'=>'Metadata'),
      'swSource'=> array(
        'class'=>'application.extensions.simpleWorkflow.SWPhpWorkflowSource',
      ) 
    ),
    'params'=>array(
      'adminEmail'=>'webmaster@example.com',
      'development' => 0,
      'test' => 0,
      'urlSitio'=>'http://ec2-54-94-148-171.sa-east-1.compute.amazonaws.com/',
      'keyUrl'=>'AIzaSyCE1B5yB1FR9Lqvo464yv8Wc6XCpIf0Pmg'
    )
  );