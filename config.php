<?php
	session_start();

	require_once "./Facebook/autoload.php";

	$FB = new \Facebook\Facebook([		
		'app_id' => '307443493121913',
		'app_secret' => 'f13d9ae841293d2bfc3616ee165b62cd',
		'default_graph_version' => 'v2.10'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>
