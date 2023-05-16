<?php

require '../vendor/autoload.php';
// include '../Configs.php';

use Parse\ParseFile;
use Parse\ParseObject;
use Parse\ParseUser;


//session_start();
$success="";
$currUser = ParseUser::getCurrentUser();
if ($currUser){
    // Store current user session token, to restore in case we create new user
    $_SESSION['token'] = $currUser -> getSessionToken();
// print_r($currUser);
} else {

    header("Refresh:0; url=../index.php");
}

// SIGN UP ------------------------------------------------
if(isset($_POST['add'])){
    $name = $_POST['val-name'];
    $lname = $_POST['val-lname'];
    $uname = $_POST['val-uname'];
    $pass = $_POST['val-pass'];
    $email = $_POST['val-email'];
    $about = $_POST['val-about'];
    $role = "Artist";
    $gender = $_POST['val-gender'];
    $dob = $_POST['val-date'];
   
//  //  $arr=['1','2','5','6'];
//     $
// $result = array_values(json_decode($arr, true));

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
   $newGift->set("authData",$result);
     
   
    



// print_r($newGift);
try {
    $newGift->save(true);
      $success='New object created with objectId: ' . $newGift->getObjectId();
} catch (ParseException $ex) {
    echo 'Failed to create new object, with error message: ' . $ex->getMessage();
}

   
}

?>

<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
           
            <h3 class="text-primary">Add User </h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Features</a></li>
                <li class="breadcrumb-item active">Add new User </li>
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
                    <div class="card-body">
                        <div class="needs-validation">
                        <form class="form-valide" enctype="multipart/form-data" action="" method="post" novalidate>
 <div class="alert alert-success" role="alert" style="color:black">
<?php  echo $success;
 ?>
</div>
 
                        <div class="form-group row">
                            <label for="val-name" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="val-name" name="val-name" placeholder="Name" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>


                         <div class="form-group row">
                            <label for="val-name" class="col-sm-2 col-form-label">lastname<span class="text-danger">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="val-lname" name="val-lname" placeholder="lastname" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>


                          <div class="form-group row">
                            <label for="val-name" class="col-sm-2 col-form-label">username<span class="text-danger">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="val-uname" name="val-uname" placeholder="Username" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>   

                         <div class="form-group row">
                            <label for="val-name" class="col-sm-2 col-form-label">Password<span class="text-danger">*</span> </label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control"  name="val-pass" placeholder="Password" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>

                        <div class="form-group row">
                           <label for="val-credits" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="val-credits" name="val-email" placeholder="Email" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>


                         <div class="form-group row">
                           <label for="val-credits" class="col-sm-2 col-form-label">About<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="val-about" placeholder="About" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="val-category">role <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="val-category" name="val-role">
                                        <option value="Artist">Artist</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Viewer">Viewer</option>
                                       

                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>


                             <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="val-category">Gender <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="val-category" name="val-gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                       

                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>


                               <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="val-category">Date of Birth <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="val-date"  required>

                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>   


                          <!--   <div class="form-group row">
                                <label for="val-file" class="col-sm-2 col-form-label">Lottie JSON file<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input id="val-file" name="val-file" type="file" accept="application/json" required />
                                    <div class="invalid-feedback">Please choose your Gift file, in JSON format</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>
 -->
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" name="add" class="btn btn-info"> Save</button>
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
</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('form-valide');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>


