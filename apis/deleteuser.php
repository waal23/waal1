<?php
require '../vendor/autoload.php';
include '../Configs.php';
use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseException;


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Access-Control-Allow-Method,Authorization, X-Requested-With');
$data = json_decode(file_get_contents("php://input"),true);

if(isset($_REQUEST['objectId'])){

$id=$_REQUEST['objectId'];


 try {
    $object = ParseObject::create('User');
    $object->set('objectId', $id);
    $object->delete($object->getobjectId());
    //echo 'Record removed successfully!';
      $row = array("Message"=>"Record removed successfully","Removed objectId:".$id);
            echo json_encode($row);  
} catch (ParseException $ex) {
    echo 'Error: ' . $ex->getMessage();
}
}
?>
