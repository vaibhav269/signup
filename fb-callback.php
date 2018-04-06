<?php
	require_once "./config.php";

	try {
		$accessToken = $helper->getAccessToken("https://signmeupapp.herokuapp.com/fb-callback.php");
	} catch (\Facebook\Exceptions\FacebookResponseException $e) {
		echo "Response Exception: " . $e->getMessage();
		exit();
	} catch (\Facebook\Exceptions\FacebookSDKException $e) {
		echo "SDK Exception: " . $e->getMessage();
		exit();
	}

	if (!$accessToken) {
		header('Location: ./index.php');
		exit();
	}

	$oAuth2Client = $FB->getOAuth2Client();
	if (!$accessToken->isLongLived())
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

	$response = $FB->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
	$userData = $response->getGraphNode()->asArray();
	$email = $userData['email'];
	$name = $userData['first_name']." ".$userData['last_name'];
	$bool=false;
	$dbc=mysqli_connect('localhost','vaibhav','tester','signup')  or die("Could not conect");
	$query="SELECT email FROM signup WHERE email='$email'";
	$result=mysqli_query($dbc,$query);
	$ifExist = mysqli_num_rows($result);
	if(!$ifExist){
		 if(mysqli_query($dbc,"INSERT INTO signup(name,email) VALUES('$name','$email')") or die("could not query"))
		  {
			   $bool = true;
				 echo "signup succesful";
		  }
	}
	if($ifExist || $bool){
		 $_SESSION['email'] = $email;
		 $_SESSION['name'] = $name;
		 echo "logged in succesfully with facebook";
	}	
	
	header('Location: ./indexed.php');
	exit();
?>
