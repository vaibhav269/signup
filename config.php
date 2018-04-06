<?php
	session_start();

	require_once "./Facebook/autoload.php";

	$FB = new \Facebook\Facebook([		
		'app_id' => '192421934895078',
		'app_secret' => '14dfe50d7f609e86cc183751336857c1',
		'default_graph_version' => 'v2.10'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>
