<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Android portal',
    'sourceLanguage'=>'ru',
    'aliases' => array(
        'bootstrap'=> realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
        'yiistrap'=> realpath(__DIR__ . '/../extensions/yiistrap')
    ),
	// preloading 'log' component
	'preload'=>array('log', 'booster'),


	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'bootstrap.helpers.*',
        'yiistrap.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
            'generatorPaths' => array('bootstrap.gii'),
			'password'=>'LiOn8411',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
            /*'ipFilters'=>array(),
            'ipFilters'=>false,*/
            'generatorPaths' => array('yiistrap.gii'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

        'booster' => array(
            'class' => 'bootstrap.components.Booster',
        ),

        'bootstrap' => array(
            'class' => 'yiistrap.components.TbApi',
        ),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),


		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=db_mobilemarketing',
			'emulatePrepare' => true,
			'username' => 'dbu_mobmark',
			'password' => 'VacuoUs62=',
			'charset' => 'utf8',
            'enableParamLogging'=>true
		),
		
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
		'adminEmail'=>'aslantorret@gmail.com',
        'timeout'=>'86400',

   /////////////////////////////////LIPTON PROMO//////////////////////////
        'cities'=>array(
            ''=>'Выберите город',
            '0'=>'Алматы',
            '1'=>'Астана',
            '2'=>'Шымкент',
            '3'=>'Актобе',
            '4'=>'Караганда'
        ),
        'cities_int'=>array(
            ''=>'-----все-----',
            '0'=>'Алматы',
            '1'=>'Астана',
            '2'=>'Шымкент',
            '3'=>'Актобе',
            '4'=>'Караганда'
        ),
        'promo_spot'=>array(
            ''=>'Выберите промо точку',
            '0'=>'Dostyk Plaza',
            '1'=>'Khan Shatyr',
            '2'=>'Mega',
            '3'=>'Mega',
            '4'=>'City mall'
        ),

        'def_codes'=>array(
            '+7700'=>'+7700',
            '+7708'=>'+7708',
            '+7701'=>'+7701',
            '+7702'=>'+7702',
            '+7775'=>'+7775',
            '+7778'=>'+7778',
            '+7777'=>'+7777',
            '+7705'=>'+7705',
            '+7776'=>'+7776',
            '+7771'=>'+7771',
            '+7707'=>'+7707',
            '+7747'=>'+7747'
        ),
        'timeout2'=>'300'

	),
);