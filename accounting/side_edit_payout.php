<?php

require '../vendor/autoload.php';
//include '../Configs.php';

use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;

// Update data ------------------------------------------------
if(isset($_POST['status'])){
    $status = $_POST['status'];

    $adObjID = $_GET['objectId'];

    $query = new ParseQuery("Withdrawn");
    try {
        $payout = $query->get($adObjID, true);
        // The object was retrieved successfully.
    } catch (ParseException $ex) {
        // The object was not retrieved successfully.
        // error is a ParseException with an error code and message.
    }

    try {
        $payout->set("status", $status);
        if ($status === "completed"){
            $payout->set("completed", true);

        } else {
            $payout->set("completed", false);
        }


    } catch (Exception $e) {
    }


    $payout->save(true);

}

?>

<?php
// Get current Payout
$adObjID = $_GET['objectId'];

$queryPayout = new ParseQuery("Withdrawn");
$queryPayout->includeKey("author");
try {
    $currPayout = $queryPayout->get($adObjID, true);
    // The object was retrieved successfully.

} catch (ParseException $ex) {
    // The object was not retrieved successfully.
    // error is a ParseException with an error code and message.
}

//Get Amount
$amount = $currPayout->get('amount');
$currency = $currPayout->get('currency');
$amount_current = sprintf("%d %s ", $amount, $currency);

// Get Name or Account name
$iban = $currPayout->get('IBAN');
$bank_name = $currPayout->get('bank_name');
$account_name = $currPayout->get('account_name');

// Get Method
$method = $currPayout->get('method');

if ($method === "payoneer"){
    $destination = $currPayout->get('email');
    $fromName = $currPayout->get('author')->get('name');

} else if ($method === "IBAN"){
    $destination = sprintf("%s: %s ", $bank_name, $iban);
    $fromName = $account_name;

} else {
    $destination = $currPayout->get('email');
    $fromName = $currPayout->get('author')->get('name');
}

$status = $currPayout->get('status');
if ($status === "pending"){
    $status1 = "Pending";
    $status2 = "Processing";
    $status3 = "Completed";

    $statusValue1 = "pending";
    $statusValue2 = "processing";
    $statusValue3 = "completed";


} else if ($status === "processing"){
    $status1 = "Processing";
    $status2 = "Completed";
    $status3 = "Pending";

    $statusValue1 = "processing";
    $statusValue2 = "completed";
    $statusValue3 = "pending";

} else {
    $status1 = "Completed";
    $status2 = "Processing";
    $status3 = "Pending";

    $statusValue1 = "completed";
    $statusValue2 = "processing";
    $statusValue3 = "pending";

}

$_SESSION['status']   = $status;

?>

<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Payouts </h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Payouts</a></li>
                <li class="breadcrumb-item active">Edit Payout</li>
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
                            <label for="fullname" class="col-sm-2 col-form-label">Author/Account <span class="text-danger"></span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fullname" name="fullname" value="'.$fromName.'" disabled="true">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Amount <span class="text-danger"></span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="amount" name="amount" value="'.$amount_current.'" disabled="true">
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="method">Method <span class="text-danger"></span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="method" value="'.$method.'" name="method" disabled="true">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="birthday">Destination <span class="text-danger"></span></label>
                               
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="destination" value="'.$destination.'" name="destination" disabled="true">
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="status">Payout Status <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="status" name="status" data-value="'.$status.'">
                                        <option value="'.$statusValue1.'">'.$status1.'</option>
                                        <option value="'.$statusValue2.'">'.$status2.'</option>
                                        <option value="'.$statusValue3.'">'.$status3.'</option>
                                    </select>
                                </div>
                            </div>
                                          
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-info"> Save </button>
                                <a class="btn btn-inverse" href="../dashboard/payouts.php"> Back </a>

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