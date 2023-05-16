<?php

require '../vendor/autoload.php';
//include '../Configs.php';

use Parse\ParseException;
use Parse\ParseQuery;
use Parse\ParseUser;


//session_start();

//$currUser = ParseUser::getCurrentUser();
/*if ($currUser){

    // Store current user session token, to restore in case we create new user
    $_SESSION['token'] = $currUser -> getSessionToken();
} else {

    header("Refresh:0; url=../index.php");
}

*/?>

<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Live Streams</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Features</a></li>
                <li class="breadcrumb-item active">Live Streams</li>
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

                    $query = new ParseQuery("Streaming");
                    $streamCounter = $query->count(true);

                    echo ' <h2 class="card-title">'.$streamCounter.' Streams in total</h2> ';

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
                                    <th>Streamer</th>
                                    <th>Type</th>
                                    <th>Views</th>
                                    <th>Coins</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                try {

                                    $currUser = ParseUser::getCurrentUser();
                                    $cuObjectID = $currUser->getObjectId();

                                    $query = new ParseQuery("Streaming");
                                    $query->descending('createdAt');
                                    $query->includeKey("Author");
                                    $catArray = $query->find(false);

                                    foreach ($catArray as $iValue) {
                                        // Get Parse Object
                                        $cObj = $iValue;

                                        $objectId = $cObj->getObjectId();
                                        $date= $cObj->getCreatedAt();
                                        $created = date_format($date,"d/m/Y");

                                        $name = $cObj->get('Author')->get('name');

                                        $streamingType = $cObj->get('private');

                                        if ($streamingType == true){
                                            $type_stream = "Private";
                                        } else {
                                            $type_stream = "Public";
                                        }

                                        $streamViewers = $cObj->get('viewers_id');
                                        if($streamViewers != null){
                                            $views = count($streamViewers);
                                        } else {
                                            $views = "0";
                                        }

                                        $credits = $cObj->get('streaming_diamonds');

                                        $date1 = $cObj->getCreatedAt();

                                        if ($cObj->get("endedAt") != null){
                                            $date2 = $cObj->get("endedAt");
                                        } else {
                                            $date2 = $cObj->getUpdatedAt();
                                        }


                                        $difference = $date1->diff($date2);

                                        $duration = format_interval($difference);

                                        $status = $cObj->get('streaming');
                                        if ($status == true){
                                            $status_mine = "<span class=\"badge badge-red\">LIVE NOW</span>";
                                        } else{
                                            $status_mine = "<span class=\"badge badge-success\">FINISHED</span>";
                                        }

                                        echo '
		            	
		            	        <tr>
                                    <td>'.$objectId.'</td>
                                    <td>'.$created.'</td>
                                    <td>'.$name.'</td>
                                    <td><span>'.$type_stream.'</span></td>
                                    <td><span>'.$views.'</span></td>
                                    <td>'.$credits.'</td>
                                    <td>'.$duration.'</td>
                                    <td>'.$status_mine.'</td>
                                </tr>
                                
                                ';
                                    }
                                    // error in query
                                } catch (ParseException $e){ echo $e->getMessage(); }

                                function format_interval(DateInterval $interval) {
                                    $result = "";
                                    if ($interval->y) { $result .= $interval->format("%y years "); }
                                    if ($interval->m) { $result .= $interval->format("%m months "); }
                                    if ($interval->d) { $result .= $interval->format("%d days "); }
                                    if ($interval->h) { $result .= $interval->format("%h hours "); }
                                    if ($interval->i) { $result .= $interval->format("%i min "); }
                                    if ($interval->s) { $result .= $interval->format("%s sec "); }

                                    return $result;
                                }
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
