<?php

$basePath 		= dirname(__FILE__);
$appPath 		= (is_dir(realpath( $basePath.'/..' ))) ? realpath( $basePath.'/..' ) : '';
$controllerPath 	= (is_dir(realpath( $basePath.'/../app/controller' ))) ? PATH_SEPARATOR . realpath( $basePath.'/../app/controller' ) : '';
$modelPath 		= (is_dir(realpath( $basePath.'/../app/model' ))) ? PATH_SEPARATOR . realpath( $basePath.'/../app/model' ) : '';
$configPath 		= (is_dir(realpath( $basePath.'/../etc' ))) ? PATH_SEPARATOR . realpath( $basePath.'/../etc' ) : '';

set_include_path(get_include_path(). PATH_SEPARATOR . $appPath . $controllerPath . $configPath . $modelPath );

spl_autoload_register(function($className)
{
	if(!class_exists($className)) {
		$classFile = str_replace('\\', '/', ltrim($className, '\\')) . '.php';
		require($classFile);
	}
});

\lib\Application::getInstance()->run();