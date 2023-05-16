<?php

require '../vendor/autoload.php';
//include '../Configs.php';

use Parse\ParseException;
use Parse\ParseQuery;
use Parse\ParseUser;


//session_start();

$currUser = ParseUser::getCurrentUser();
if ($currUser){

    // Store current user session token, to restore in case we create new user
    $_SESSION['token'] = $currUser -> getSessionToken();
} else {

    header("Refresh:0; url=../index.php");
}

?>

<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Pending Payouts</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Accounting</a></li>
                <li class="breadcrumb-item active">Payouts -> Pending</li>
            </ol>
        </div>
    </div>

    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row bg-white m-l-0 m-r-0 box-shadow ">

        </div>
        <div class="row">
            <div class="col-lg">

                <div class="card">

                    <?php

                    $query = new ParseQuery("Withdrawn");
                    $query->equalTo("status", "pending");
                    $messagesCounter = $query->count(true);

                    echo ' <h2 class="card-title">'.$messagesCounter.' Payouts in total</h2> ';

                    ?>

                    <h5 class="card-subtitle">Copy or Export CSV, Excel, PDF and Print data</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!--<table class="table">-->
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ObjectId</th>
                                    <th>Date</th>
                                    <th>Author/Account</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Destination</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                try {

                                    $query = new ParseQuery("Withdrawn");
                                    $query->ascending('createdAt');
                                    $query->equalTo("status", "pending");
                                    $query->includeKey("author");
                                    $catArray = $query->find(false);

                                    foreach ($catArray as $iValue) {
                                        // Get Parse Object
                                        $cObj = $iValue;

                                        $objectId = $cObj->getObjectId();
                                        $date= $cObj->getCreatedAt();
                                        $created = date_format($date,"d/m/Y");

                                        $amount = $cObj->get('amount');
                                        $currency = $cObj->get('currency');

                                        $iban = $cObj->get('IBAN');
                                        $bank_name = $cObj->get('bank_name');
                                        $bank_name_final ="<span class=\"badge badge-warning\">$bank_name</span>";
                                        $account_name = $cObj->get('account_name');

                                        $amount_current = sprintf("%d %s ", $amount, $currency);

                                        $method = $cObj->get('method');

                                        if ($method === "payoneer"){
                                            $destination = $cObj->get('email');
                                            $fromName = $cObj->get('author')->get('name');

                                        } else if ($method === "IBAN"){
                                            $destination = sprintf("%s \n %s ", $bank_name_final, $iban);
                                            $fromName = $account_name;

                                        } else {
                                            $destination = $cObj->get('email');
                                            $fromName = $cObj->get('author')->get('name');
                                        }

                                        $status = "<span/><a target='_blank' href=\"../dashboard/edit_payout.php?objectId=$objectId\" class=\"badge badge-info\">Process now</a></span>";

                                        echo '
		            	
		            	        <tr>
                                    <td>'.$objectId.'</td>
                                    <td>'.$created.'</td>
                                    <td>'.$fromName.'</td>
                                    <td>'.$amount_current.'</td>
                                    <td>'.$method.'</td>
                                    <td>'.$destination.'</td>
                                    <td>'.$status.'</td>
         
                                </tr>
                                
                                ';
                                    }
                                    // error in query
                                } catch (ParseException $e){ echo $e->getMessage(); }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>
        </div>

        <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->
    <!-- footer -->

    <!-- End footer -->
</div>
