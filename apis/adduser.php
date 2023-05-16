<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Access-Control-Allow-Method,Authorization, X-Requested-With');
$data = json_decode(file_get_contents("php://input"),true);

require '../vendor/autoload.php';
include '../Configs.php';

use Parse\ParseFile;
use Parse\ParseObject;
use Parse\ParseUser;


// session_start();
if(isset($_REQUEST['val-name']) && isset($_REQUEST['val-lname'])&& isset($_REQUEST['val-uname'])&&isset($_REQUEST['val-pass']) && isset($_REQUEST['val-email'])&& isset($_REQUEST['val-about'])&& isset($_REQUEST['role']) && isset($_REQUEST['val-gender']) && isset($_REQUEST['val-date'])){

    $name = $_REQUEST['val-name'];
    $lname = $_REQUEST['val-lname'];
    $uname = $_REQUEST['val-uname'];
    $pass = $_REQUEST['val-pass'];
    $email = $_REQUEST['val-email'];
    $about = $_REQUEST['val-about'];
    $role = $_REQUEST['role'];
    $gender = $_REQUEST['val-gender'];
    $dob = $_REQUEST['val-date'];
   
    $newGift = ParseObject::create("User");

    $newGift->set("name", $name);
    $newGift->set("last_name", $lname);
    $newGift->set("username", $uname);
    $newGift->set("password", $pass);
    $newGift->set("email", $email);
    $newGift->set("about", $about);
    $newGift->set("role", $role);
    $newGift->set("gender", $gender);
    $newGift->set("birthday", $dob);
  

// print_r($newGift);
try {
    $newGift->save(true);
      // $success='New object created with objectId: ' . $newGift->getObjectId();

     $row = array("message"=>"New object created with objectId","Authorization"=>$newGift->getObjectId());
                 echo json_encode($row);
} catch (ParseException $ex) {
    // echo 'Failed to create new object, with error message: ' . $ex->getMessage();

    $row = array("message"=>"Failed to create new object, with error message:","error"=>$ex->getMessage());
                 echo json_encode($row);
}

   
}else{

   echo "Issue";
}






?>