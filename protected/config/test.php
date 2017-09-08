<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
            'log'=>array(
                         'class'=>'CLogRouter',
                         'routes'=>array(
                                         array(
                                               'class'=>'CFileLogRoute',
                                               'levels'=>'error, warning',
                                               ),
                                         /*
                                         array(
                                               'class'=>'CWebLogRoute',
                                               )
                                         */

			),
		),

			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
		),

        'params'=>array(
                        // this is used in contact page
                        'adminEmail'=>'webmaster@example.com',
                        'cambioclave'=>'http://10.169.4.41/SistemaSeguridad/script/CambioClave.aspx',
                        'wsdl'=>'http://10.169.4.41/wsseguridad/webservice/ayaservice.asmx?WSDL',
                        'wsdl2'=>'http://10.169.4.41/wsseguridad/webservice/service.asmx?WSDL',
                        'urlretorno' => 'http://pruebasviajes.tuya.corp/index.php/site/login',
                        'compra_software'=>'1',
                        'salario_minimo'=>'566700',
                        'salarios_atribuciones' => 100,
                        'development' => 0,
                        'test' => 0,
                        'testemail' => 'santios@gmail.com',
                        'test_cuenta_email' => 1
                        )
   )
);
