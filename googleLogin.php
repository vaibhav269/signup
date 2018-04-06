<?php
     session_start();
     require_once './googleLoginLibrary/vendor/autoload.php';
     $id_token = $_POST['id_token'];
     $CLIENT_ID="214752247233-5eik393o7nhcs6ohu5391oektamvf5of.apps.googleusercontent.com";
     $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
     $payload = $client->verifyIdToken($id_token);
     if ($payload) {
                    $email = $payload['email'];
                    $name = $payload['name'];
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
                         echo "logged in succesfully with google";
                    }
     } else {
       // Invalid ID token
     }
 ?>
