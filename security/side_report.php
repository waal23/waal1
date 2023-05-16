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
            <h3 class="text-primary">Reports</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Security</a></li>
                <li class="breadcrumb-item active">Reports</li>
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

                    $query = new ParseQuery('Report');
                    $matchCounter = $query->count(true);

                    echo ' <h2 class="card-title">'.$matchCounter.' Reports in total</h2> ';

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
                                    <th>Reporter</th>
                                    <th>Reported</th>
                                    <th>Type</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Object</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                try {

                                    $currUser = ParseUser::getCurrentUser();
                                    $cuObjectID = $currUser->getObjectId();

                                    $query = new ParseQuery("Report");
                                    $query->descending('createdAt');
                                    $query->includeKey("accuser");
                                    $query->includeKey("accused");
                                    $query->includeKey("live");
                                    $query->includeKey("post");
                                    $catArray = $query->find(true);

                                    foreach ($catArray as $iValue) {
                                        // Get Parse Object
                                        $cObj = $iValue;

                                        $objectId = $cObj->getObjectId();
                                        $date= $cObj->getCreatedAt();
                                        $created = date_format($date,"d/m/Y");

                                        $fromName = $cObj->get('accuser')->get('name');
                                        $toName = $cObj->get('accused')->get('name');
                                        $type = $cObj->get('reportType');

                                        if ($type === "LIVE"){
                                            $objectIdStream = $cObj->get('live')->getObjectId();
                                            $object = "<span/><a target='_blank' href=\"../dashboard/edit_report_object.php?objectId=$objectId\" class=\"badge badge-info\">Review</a></span>";

                                        } else  if ($type === "POST"){

                                            if ($cObj->get('post') != null){
                                                $objectIdStream = $cObj->get('post')->getObjectId();
                                                $object = "<span/><a target='_blank' href=\"../dashboard/edit_report_object.php?objectId=$objectId\" class=\"badge badge-info\">Review</a></span>";

                                            } else {
                                                $object = "<span class=\"badge badge-red\">Deleted</span>";
                                            }

                                        } else {
                                            $objectIdStream = $cObj->get('accused')->getObjectId();
                                            $object = "<span/><a target='_blank' href=\"../dashboard/edit_user.php?objectId=$objectIdStream\" class=\"badge badge-info\">Review</a></span>";
                                        }

                                        $reason = $cObj->get('message');
                                        $state = $cObj->get('state');


                                        if ($state == "resolved"){
                                            $state = "<span class=\"badge badge-success\">Resolved</span>";

                                        } else  if ($type === "POST"){
                                             if ($cObj->get('post') != null){
                                                 $state = "<span class=\"badge badge-danger\">Pending</span>";
                                             } else {
                                                 $state = "<span class=\"badge badge-success\">Resolved</span>";
                                             }
                                        } else {
                                            $state = "<span class=\"badge badge-danger\">Pending</span>";
                                        }

                                        echo '
		            	
		            	        <tr>
                                    <td>'.$objectId.'</td>
                                    <td>'.$created.'</td>
                                    <td>'.$fromName.'</td>
                                    <td>'.$toName.'</td>
                                    <td>'.$type.'</td>
                                    <td>'.$reason.'</td>
                                    <td>'.$state.'</td>
                                    <td>'.$object.'</td>
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
