<?php
require '../vendor/autoload.php';
include '../Configs.php';
use Parse\ParseUser;
use Parse\ParseException;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Access-Control-Allow-Method,Authorization, X-Requested-With');
$data = json_decode(file_get_contents("php://input"),true);

if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
// $name=$_GET['name'];
// $row = array("message"=>"insert data", "name"=>$name);

// echo json_encode($row);

// if(isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    try {
        $user = ParseUser::logIn($username, $password);

        $currUser = ParseUser::getCurrentUser();

      
   $row = array("message"=>"LoginDone","Authorization"=>$user->get('authData'),"SessionToken",$currUser -> getSessionToken(),"username"=>$user->get('username'),"first_name"=>$user->get('first_name'),'last_name'=>$user->get('last_name'),"email_public"=>$user->get('email_public'),"about"=>$user->get('aboutMe'),'gender'=>$user->get('gender'));

               
                 echo json_encode($row);
           

            // showSweetAlert("Error!", "You are not authorized", "error");

            // { header('Refresh:0; url=../auth/logout.php'); }
        }

        // showSweetAlert("Success!", "Logged In, Wait...", "success");

        // error
     catch (ParseException $error) {

        $e = $error->getMessage();

        // showSweetAlert("Error!", $e, "error");
            $row = array("error"=>$e);
            echo json_encode($row);  

    } catch (Exception $e) {
    }
}
?>
