<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Passwords',

    'preload' => array('log'),

    'language'=>'en_us',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'ext.giix-components.*' // giix components
	),

	'defaultController'=>'password',

	// application components
	'components'=>array(


		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=passwords',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
            'enableProfiling' => true,
            'enableParamLogging' => true
		),

        'ePdf' => array(
            'class'         => 'ext.yii-pdf.EYiiPdf',
            'params'        => array(
                'mpdf'     => array(
                    'librarySourcePath' => 'application.vendors.mpdf.*',
                    'constants'         => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                    /*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                        'mode'              => '', //  This parameter specifies the mode of the new document.
                        'format'            => 'A4', // format A4, A5, ...
                        'default_font_size' => 0, // Sets the default document font size in points (pt)
                        'default_font'      => '', // Sets the default font-family for the new document.
                        'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                        'mgr'               => 15, // margin_right
                        'mgt'               => 16, // margin_top
                        'mgb'               => 16, // margin_bottom
                        'mgh'               => 9, // margin_header
                        'mgf'               => 9, // margin_footer
                        'orientation'       => 'P', // landscape or portrait orientation
                    )*/
                )
            )
        ),

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    // Access is restricted by default to the localhost
                    //'ipFilters'=>array('127.0.0.1','192.168.1.*', 88.23.23.0/24),
                ),
            ),
        ),

        'urlManager'=>array(
            'urlFormat'=>'path'
        ),

        'authManager'=>array(
            'class'=>'RDbAuthManager',
        ),

        'user'=>array(
            'class'=>'RWebUser',
        )

	),


    'modules' => array(
        'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => '1234',
                'generatorPaths' => array(
                        'ext.giix-core', // giix generators
                ),
        ),
        'rights'=>array(
            'install'=>false,
        )
    )
);