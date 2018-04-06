<?php
	session_start();

	if (!isset($_SESSION['email'])) {
		header('Location: ./index.php');
		exit();
	}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<script src="./scripts/jquery.min.js"></script>
</head>
<body>
	<div class="container" style="margin-top: 100px">
		<div class="row justify-content-center">
			<div class="col">
				<?php echo $_SESSION['email'] ?>
			</div>
			<div class="col">
				<?php echo $_SESSION['name'] ?>
			</div
			<div class="col">
				<button class="btn btn-primary" onclick="logout()">Logout</button>
			</div>		
		</div>
	</div>
	<script>
	function logout(){
		$.post("logout.php", {
                                    task:"logout"
                                },
                                function(data, status){
									alert(data);
                                  if(status==="success"){
                                    window.location.href = "./index.php";
                                  }                                    
                                });
	}	
	</script>
</body>
</html>