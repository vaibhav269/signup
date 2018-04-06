<?php
	require_once "./config.php";

	if (isset($_SESSION['access_token'])) {
		header('Location: ./indexed.php');
		exit();
	}	
	$redirectURL = "https://facebookloginapp.herokuapp.com/fb-callback.php";
	$permissions = ['email'];
	$loginURL = $helper->getLoginUrl($redirectURL, $permissions);
?>

<!DOCTYPE html>
<html >
     <head>
          <meta charset="utf-8">
          <meta name="google-signin-client_id" content="214752247233-5eik393o7nhcs6ohu5391oektamvf5of.apps.googleusercontent.com">
          <title>Signup form</title>
          <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
          <script src="./scripts/jquery.min.js"></script>
          <script src="./bootstrap/js/bootstrap.min.js"></script>
          <script>
               function onSignIn(googleUser) {
                        var id_token = googleUser.getAuthResponse().id_token;
                        $.post("data.php",
                            {
                                id_token:id_token
                            },
                            function(data, status){
                                console.log(data);
                            });
                        }
          </script>
     </head>

     <body>
          <?php

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }

               if(isset($_POST['submitEmail']) || isset($_POST['submitDatabase'])){
                    $nameErr = $emailErr =  $mobileErr = $addressErr = "";
                    $name = $email = $mobile = $address = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                      if (empty($_POST["name"])) {
                        $nameErr = "Name is required";
                      } else {
                        $name = test_input($_POST["name"]);
                        // check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                          $nameErr = "Only letters and white space allowed";
                        }
                      }

                      if (empty($_POST["email"])) {
                        $emailErr = "Email is required";
                      } else {
                        $email = test_input($_POST["email"]);
                        // check if e-mail address is well-formed
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                          $emailErr = "Invalid email format";
                        }
                      }

                      if (empty($_POST["mobile"])) {
                       $mobileErr = "Mobile is required";
                      } else {
                       $mobile = test_input($_POST["mobile"]);
                       if (!preg_match('/^\d{10}$/',$mobile)) {
                         $mobileErr = "Invalid mobile number";
                       }
                      }

                      if (empty($_POST["address"])) {
                       $addressErr = "address is required";
                      } else {
                       $address = test_input($_POST["address"]);
                       // check if name only contains numbers,letters,whitespace and -.
                       if (!preg_match('/^[a-z0-9 .\-\,]+$/i',$address)) {
                         $addressErr = "Invalid address";
                       }
                      }

                      if ($nameErr == "" && $emailErr == "" && $addressErr == "" && $mobileErr == "" ){
                           if(isset($_POST['submitEmail']))
                           {
                                    $headers = "From: webmaster@example.com";
                                    $mailData="name:$name \r\n email:$email \r\n mobile:$mobile \r\n address:$address";
                                    $status=mail("vaibhav.verma2697@gmail.com","user signup details",$mailData,$headers);
                                    echo $status;
                                    if($status==1){
                                         echo "succesfully mailed";
                                    }
                           }else{
                                     $dbc=mysqli_connect('localhost','vaibhav','tester','signup')  or die("Could not conect");
                                    if(mysqli_query($dbc,"INSERT INTO signup VALUES('$name','$email','$mobile','$address')") or die("could not query"))
                                     {
                                            echo "succesfully submitted ";
                                     }
                           }
                      }
                      else{
                           echo $nameErr."\n".$emailErr."\n".$mobileErr."\n"."$addressErr";
                      }

                    }
               }
               else{
          ?>
                         <div class="container">
                                   <div class="row justify-content-center mt-3">
                                        <h1 class="col-md-6 text-center">A simple signup form</h1>
                                   </div>

                                   <div class="row justify-content-center mt-3">
                                             <form class="col-md-6 border p-3" action="index.php" method="POST">
                                                         <div class="form-group">
                                                                <label for="name">Enter name</label>
                                                                <input type="text" name="name" class="form-control" placeholder="Enter name">
                                                           </div>

                                                           <div class="form-group">
                                                                 <label for="email">Enter email</label>
                                                                 <input type="email" name="email" class="form-control" placeholder="Enter email">
                                                          </div>

                                                          <div class="form-group">
                                                                <label for="mobile">Enter mobile</label>
                                                                 <input type="text" name="mobile" class="form-control" placeholder="Enter mobile">
                                                         </div>

                                                         <div class="form-group">
                                                               <label for="address">Enter address</label>

                                                                <textarea name="address" class="form-control" placeholder="Enter address"></textarea>
                                                        </div>
                                                        <div class="row justify-content-around">
                                                            <button type="submit" name="submitDatabase" class="btn btn-primary text-center col-auto">Submit to Database</button>
                                                            <button type="submit" name="submitEmail" class="btn btn-primary text-center col-auto">Send to Email</button>
                                                       </div>
                                             </form>
                                   </div>

                                        <div class="row justify-content-center mt-1">
                                             <div class="display"> OR </div>
                                        </div>

                                        <div class="row justify-content-center mt-1">
                                             <div class="col-6 row">
                                                 <button onclick="window.location = '<?php echo $loginURL ?>';" class="btn col-12 bg-lg btn-outline-primary">continue with facebook</button>
                                                 <div class="col-12 border p-0 mt-2" id="my-signin2"></div>
                                            </div>
                                       </div>
                              </div>
          <?php
               }
          ?>

          <script>
                    function onSuccess(googleUser) {
                         var id_token = googleUser.getAuthResponse().id_token;
                            $.post("data.php",
                                {
                                    id_token:id_token
                                },
                                function(data, status){
                                    alert(data);
                                });
                    }
                    function onFailure(error) {
                      console.log(error);
                    }
                    function renderButton() {
                    let wid= $("#my-signin2").width();
                      gapi.signin2.render('my-signin2', {
                        'scope': 'profile email',
                       'width': wid,
                       'height': 50,
                       'longtitle': true,
                       'theme': 'dark',
                        'onsuccess': onSuccess,
                        'onfailure': onFailure
                      });
                    }
          </script>
          <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
     </body>
</html>
