<!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EZ Restaurant</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>  
</head>

<body>

    <script type="text/javascript">
        $(document).ready(function(){
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('#myTab a[href="' + activeTab + '"]').tab('show');
	}
        $('.first-p').hide();
        $("button").click(function(){
            $(this).next().slideToggle(1000);
        });
        
    });

    </script> 

    <!-- Navigation Bar -->
    <?php
    require_once 'header.php';
    require_once __DIR__ . '/../../models/Restaurant_model.php';
    require_once __DIR__ . '/../../models/User_model.php';
    require_once __DIR__ . '/../../models/Admin_model.php';
    require_once __DIR__ . '/../../controllers/Admin_controller.php';
    $userArray; $restaurantNewArray; $restaurantArray; $reviewArray; $restaurant; $user; $admin;
    if (!isset($_SESSION['username'])) {
        header('location: ../home/login.php');
    }
    if(!isset($restaurant))
    {
        $restaurant = new Restaurant_model();
    }
    if(!isset($user))
    {
        $user = new User_model();
    }
    if(!isset($admin))
    {
        $admin = new Admin_model();
    }
    if(!isset($adminController))
    {
        $adminController = new Admin_controller();
    }
    $restaurantNewArray = $admin->getNewRestaurants();
    $restaurantArray = $admin->getAllRestaurants();
    $userArray = $admin->getAllUsers();
    $reviewArray = $admin->getFlaggedReviews();
    $profile = $admin->getAdminProfile($_SESSION['username']);
    if($_POST)
    {
        $adminController->submit();
    }
    ?>
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <li class="list-group-item text-muted"> Admin Profile </li>
                <li class="list-group-item text-right"> <span class="pull-left"><strong>Name</strong></span><?php echo $profile['name'] ?></li>
                <li class="list-group-item text-right"> <span class="pull-left"><strong>E-mail</strong></span><?php echo $profile['email'] ?></li>
                <li class="list-group-item text-right"> <span class="pull-left"><strong>Username</strong></span><?php echo $profile['username'] ?></li>
                <li class="list-group-item text-right"> <span class="pull-left"><strong>Phone Number</strong></span><?php echo $profile['contact_num'] ?></li>
            </div> <!-- End of col-md-9 -->
            <div class="col-md-3">
                <?php echo '<img width="200" height="230" style="float:left;" src="data:image/jpeg;base64,' . base64_encode($profile['profile_pic']) . '">'; ?>
                <!-- <img src="#" width="200" height="230" style="float:left;"> -->
            </div>
        </div> <!-- End of Row -->
        <ul class="nav nav-tabs" id="myTab" > <!-- Tab for the UserSection -->
            <li class="active"><a data-toggle="tab" href="#restaurants">Newly Registered Restaurants</a></li>
            <li> <a data-toggle="tab" href="#rest_list">Restaurant List</a></li>
            <li> <a data-toggle="tab" href="#reviews">Reviews</a></li> 
            <li> <a data-toggle="tab" href="#users">User List</a></li> 
        </ul> <!-- Done with the tab --> 
        <div class="tab-content">
            <div id="restaurants" class="tab-pane fade in active">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date Registered</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            <?php
                                    foreach($restaurantNewArray as $res) {
                            ?>
                            
                            <tr>
                                <td><?php echo date('m-d-Y',strtotime($res['registration_date'])) ?></td>
                                <td><?php echo $res['name'] ?></td>
                                <td>
                                    <a href="<?php echo '../home/restaurant.php?resid='.$res['restaurant_id'] ?>" class="btn btn-info" role="button" target="_blank"> Details </a>
                                </td>
                                <td>
                                    <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <input name="resId" id="resId" value="<?php echo $res['restaurant_id'] ?>" type="hidden" />
                                        <button type="submit" class="btn btn-info" id="FormSubmit" value="submit-approve" name="submit-approve"> Approve </button>
                                        &nbsp;
                                        <button type="submit" class="btn btn-info" id="FormSubmit" value="submit-disapprove" name="submit-disapprove"> Disapprove </button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- End of Restaurant Tab -->
            <div id="rest_list" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Restaurant Name</th>
                                <th>Owner Name</th>
                                <th>Type of Food</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            <?php
                            
                                    foreach($restaurantArray as $res) {
                                        $owner = $admin->getOwnerByResId($res['restaurant_id']);
                            ?>
                            <tr>
                                <td><?php echo $res['name'] ?></td>
                                <td><?php echo $owner['name'] ?></td>
                                <td><?php echo $res['food_category_name'] ?></td>
                                <td><?php echo $res['phone_no'] ?></td>
                                <td>
                                    <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <input name="resId" id="resId" value="<?php echo $res['restaurant_id'] ?>" type="hidden" />
                                        <button type="submit" class="btn btn-info" role="button" value="submit-delete" name="submit-delete"> DELETE </button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- End of Reports Tab -->
            <div id="reviews" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>RestaurantName</th>
                               <!-- <th>Title</th> -->
                                <th>Review</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            <?php
                            
                                    foreach($reviewArray as $review) {
                                        $name = $admin->getRestaurantNameFromId($review['restaurant_id']);
                            ?>
                            <tr>
                                <td><?php echo date('m-d-Y',strtotime($review['date_posted'])) ?></td>
                                <td><?php echo $name['name'] ?></td>
                                <!-- <td>ReportTitle</td> -->
                                <td>
                                    <div class="first" id="hidden" >
                                    <button class="btn btn-info" role="button"> Details </button>
                                    
                                        <p class="first-p"><?php echo $review['review_description'] ?></p>
                                    </div>
                                </td>
                                <td>
                                    <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <input name="resId" id="resId" value="<?php echo $review['restaurant_id'] ?>" type="hidden" />
                                        <input name="userId" id="userId" value="<?php echo $review['user_id'] ?>" type ="hidden" />
                                        <button type="submit" class="btn btn-info" role="button" value="submit-review" name="submit-review"> Approve </button>
                                        &nbsp;
                                        <button type="submit" class="btn btn-info" role="button" value="submit-review-delete" name="submit-review-delete"> Disapprove </button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- End of Review Tab -->
            <div id="users" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Registered Date</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>E-mail</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            <?php
                            
                                    foreach($userArray as $usr) {
                                        $userinfo = $admin->getUserByRoleAndName($usr['username'], $usr['role']);
                            ?>
                            <tr>
                                <td><?php echo date('m-d-Y',strtotime($userinfo['registration_date'])) ?></td>
                                <td><?php echo $usr['username'] ?></td>
                                <td><?php echo $usr['role'] ?></td>
                                <td><?php echo $userinfo['email'] ?></td>
                                <td>
                                    <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <input name="userName" id="userName" value="<?php echo $usr['username'] ?>" type="hidden" />
                                        <input name="role" id="role" value="<?php echo $usr['role'] ?>" type="hidden" />
                                        <button type="submit" class="btn btn-info" role="button" value="submit-user-delete" name="submit-user-delete"> Delete </button>
                                    </form>
                                </td>  
                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>                    
            </div> <!-- End of Owners Table -->
        </div> <!-- End of Tab Contents -->    

    </div> <!-- End of Container -->

</body>