<?php
return array(
	'application'	=> array(
		'useLayout'		=> true,
		'defaultLayoutTemplate' => 'layout/layout',
		'loginttl' => 600, //Nach 10 Min (60 Sekunden * 10) erfolgt automatischer logout
		'baseUrl' => 'http://praxis-wenger.local:8080'
	),
	'user'		=> false,
	'debug' => true
);
