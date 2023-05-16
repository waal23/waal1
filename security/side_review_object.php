<?php

require '../vendor/autoload.php';
//include '../Configs.php';

use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;

// Update data ------------------------------------------------

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['approveAction'])){

    $adObjID = $_GET['objectId'];

    $query = new ParseQuery("Report");
    try {
        $report = $query->get($adObjID, true);

        $report->set("state", "resolved");
        $report->save(true);
        // The object was retrieved successfully.

        showSweetAlert("Success!", "Problem resolved", "success", "../dashboard/report.php");
    } catch (ParseException $ex) {
        // The object was not retrieved successfully.
        // error is a ParseException with an error code and message.
        showSweetAlert("Error!", $ex->getMessage(), "error", "#");
    } catch (Exception $e) {
        showSweetAlert("Error!", $e->getMessage(), "error", "#");
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deleteAction'])){

    $adObjID = $_GET['objectId'];
    $object = $_POST['object'];
    $objectType = $_POST['type'];

    $query = new ParseQuery("Report");
    try {
        $report = $query->get($adObjID, true);

        $report->set("state", "resolved");
        $report->save(true);
        // The object was retrieved successfully.

        showSweetAlert("Success!", "Problem resolved.", "success", "../dashboard/report.php");

    } catch (ParseException $ex) {
        // The object was not retrieved successfully.
        // error is a ParseException with an error code and message.

       showSweetAlert("Error!", $ex->getMessage(), "error", "#");
    } catch (Exception $e) {

       showSweetAlert("Error!", $e->getMessage(), "error", "#");
    }


    $queryObject = new ParseQuery($objectType === "LIVE" ? "Streaming" : "Posts");
    try {
        $objectResult = $queryObject->get($object, true);

        if ($objectType === "LIVE"){
            $objectResult->set("endByAdmin", true);
            $objectResult->save(true);
        } else {
            $objectResult->destroy(true);
        }

        // The object was retrieved successfully.
    } catch (ParseException $ex) {
        // The object was not retrieved successfully.
        // error is a ParseException with an error code and message.
    } catch (Exception $e) {

    }

}

?>

<?php
// Get current Payout
$adObjID = $_GET['objectId'];

$queryReport = new ParseQuery("Report");
$queryReport->includeKey("accuser");
$queryReport->includeKey("accused");
$queryReport->includeKey("live");
$queryReport->includeKey("post");
try {
    $currReport = $queryReport->get($adObjID, true);
    // The object was retrieved successfully.

} catch (ParseException $ex) {
    // The object was not retrieved successfully.
    // error is a ParseException with an error code and message.
}

$objectId = $currReport->getObjectId();
$date= $currReport->getCreatedAt();
$created = date_format($date,"d/m/Y");

$fromName = $currReport->get('accuser')->get('name');
$toName = $currReport->get('accused')->get('name');
$type = $currReport->get('reportType');
$reason = $currReport->get('message');
$state = $currReport->get('state');

if ($state == "resolved"){
    $reportState = "Resolved";
} else {
    $reportState = "Pending";
}

if ($type === "LIVE"){
    $object = $currReport->get("live")->getObjectId();
    $profilePhotoUrl = $currReport->get("live")->get("image")->getURL();

} else if ($type === "POST"){

    $post = $currReport->get("post");

    if ($post !== null){
        $object = $currReport->getObjectId();
    } else {
        $object = "deleted";
    }


    $photos = $post->get('image');
    $profilePhotoUrl = $photos->getURL();


} else {
    $object = $currReport->get("accused")->getObjectId();
    $profilePhotoUrl = $currReport->get("accused")->get("avatar")->getURL();
}


$typeObject = sprintf("%s: %s ", $type, $object);

?>

<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Reviews </h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Report</a></li>
                <li class="breadcrumb-item active">Edit Report</li>
            </ol>
        </div>
    </div>

    <?php

    echo '
    
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row bg-white m-l-0 m-r-0 box-shadow ">

        </div>
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                        <form class="form-valide" action="" method="post">
                        <div class="form-group row">
                            <label for="objectId" class="col-sm-2 col-form-label">ObjectId <span class="text-danger"></span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="objectId" name="objectId" value="'.$objectId.'" disabled="true">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="reporter" class="col-sm-2 col-form-label">Reporter <span class="text-danger"></span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="reporter" name="reporter" value="'.$fromName.'" disabled="true">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="reported" class="col-sm-2 col-form-label">Reported <span class="text-danger"></span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="reported" name="reported" value="'.$toName.'" disabled="true">
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="type">Type <span class="text-danger"></span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="type" value="'.$typeObject.'" name="method" disabled="true">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="reason">reason <span class="text-danger"></span></label>
                               
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="reason" value="'.$reason.'" name="destination" disabled="true">
                                </div>
                            </div>
                            
                            <div class="input-group mb-3" >
                            <label class="col-lg-2 col-form-label" for="file">File <span class="text-danger"></span></label>
                                <input type="text" class="form-control" id="file" value="'.$profilePhotoUrl.'" name="file" readonly="true">
                                <div class="input-group-append">
                                <a class="btn btn-danger" href='.$profilePhotoUrl.'> View Image </a>
                                    
                                </div>
                            </div>
                            
                            
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="State">State <span class="text-danger"></span></label>
                               
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="State" value="'.$reportState.'" name="destination" disabled="true">
                                </div>
                            </div>
                
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" name="approveAction" class="btn btn-info"> Mark resolved </button>
                                <button type="submit" name="deleteAction" class="btn btn-danger"> Delete </button>
                                <a class="btn btn-inverse" href="../dashboard/report.php"> Back </a>
                                <input type="hidden" name="object" value="'.$object.'"/>
                                <input type="hidden" name="type" value="'.$type.'"/>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
                </div>
        </div>
        </div>
        <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->
    
    ';
    ?>


</div>

<?php

function showSweetAlert($title, $explain, $type, $redirectUrl)
{
    echo '<script type="text/javascript">
    setTimeout(function () 
        { 
            swal("'.$title.'","'.$explain.'","'.$type.'").then(value => window.location = "'.$redirectUrl.'");
        }, 
        1000);
        </script>';

    /*echo '<script type="text/javascript">
    setTimeout(function() {
        swal({
            title: "'.$title.'",
            text: "'.$explain.'",
            type: "'.$type.'",
        }, function() {
            window.location = "../dashboard/report.php";
        });
    }, 1000);
    </script>';*/
}
?>