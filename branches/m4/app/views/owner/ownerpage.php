<html lang="en">
    <?php
    require_once 'header.php';
    require_once '../../models/Owner_model.php';
    require_once '../../models/Restaurant_model.php';
    require_once '../../models/OperationHours_model.php';
    require_once '../../models/Event_model.php';

    if (!isset($_SESSION['username'])) {
        header('location: ../home/login.php');
    }
    $username = $_SESSION['username'];
    $ownerDb = new Owner_model();
    $ownerInfo = $ownerDb->getOwnerInfo($username);
    $resId = intval($ownerInfo['restaurant_id']);
    $restaurantDb = new Restaurant_model();
    $restaurantInfo = $restaurantDb->findRestaurantById($resId);
    $restaurantImages = $restaurantDb->getRestaurantImages($resId);
    $imageCount = count($restaurantImages) >= 4 ? 4 : count($restaurantImages); //total number of images for the restaurant in multimedia table
    $foodCategory = $restaurantDb->getFoodCategories();
    
    $oprDb = new OperationHours_model();
    $oprHours = $oprDb->getOperatingHoursByRestaurantId($resId);
    
    $eventDb = new Event_model();
    $eventArray = $eventDb->getEventsByRestaurantId($resId);

    if (!empty($oprHours)) {
        $oprHours = $oprHours[0];
    }
    
    if ($_POST && isset($_POST['image_type'])) {
        switch($_POST['image_type']) {
            case 'profile':
                if (is_uploaded_file($_FILES['profile-image']['tmp_name'])) {
                    $thumbnail = file_get_contents($_FILES["profile-image"]["tmp_name"]);
                }
                if ($restaurantDb->updateRestaurantThumbnail($resId, $thumbnail)) {
                    $restaurantInfo = $restaurantDb->findRestaurantById($resId);
                }
                break;
            case 'multimedia':
                if (is_uploaded_file($_FILES['multimedia-image']['tmp_name'])) {
                    $img = file_get_contents($_FILES["multimedia-image"]["tmp_name"]);
                    if ($restaurantDb->updateMultimedia($_POST['multimedia-id'], $img, $resId)) {
                        $restaurantImages = $restaurantDb->getRestaurantImages($resId);
                        $imageCount = count($restaurantImages) >= 4 ? 4 : count($restaurantImages);
                    }
                }
                break;
            case 'menu':
                if (is_uploaded_file($_FILES['menu-image']['tmp_name'])) {
                    $menu = file_get_contents($_FILES["menu-image"]["tmp_name"]);
                }
                if ($restaurantDb->updateRestaurantMenu($resId, $menu)) {
                    $restaurantInfo = $restaurantDb->findRestaurantById($resId);
                }
                break;
        }
    }
 
    ?>  
    <head>
        <title>TableMe</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <!-- Will merge the style and script code into CSS and JS file after all is done. -->
        <style>
            .hovereffect {
                width: 100%;
                height: 200px;
                float: left;
                overflow: hidden;
                position: relative;
                text-align: center;
                cursor: default;
            }

            .hovereffect .overlay {
                width: 100%;
                height: 200px;
                position: absolute;
                overflow: hidden;
                top: 0;
                left: 0;
            }

            .hovereffect img {
                display: block;
                position: relative;
                -webkit-transition: all 0.4s ease-in;
                transition: all 0.4s ease-in;
            }

            .hovereffect:hover img {
                filter: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg"><filter id="filter"><feColorMatrix type="matrix" color-interpolation-filters="sRGB" values="0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0 0 0 1 0" /><feGaussianBlur stdDeviation="3" /></filter></svg>#filter');
                filter: grayscale(1) blur(3px);
                -webkit-filter: grayscale(1) blur(3px);
                -webkit-transform: scale(1.2);
                -ms-transform: scale(1.2);
                transform: scale(1.2);
            }

            .hovereffect h2 {
                text-transform: uppercase;
                text-align: center;
                position: relative;
                font-size: 17px;
                padding: 10px;
                background: rgba(0, 0, 0, 0.6);
            }

            .hovereffect a.info {
                display: inline-block;
                text-decoration: none;
                padding: 7px 14px;
                border: 1px solid #fff;
                margin: 50px 0 0 0;
                background-color: transparent;
            }

            .hovereffect a.info:hover {
                box-shadow: 0 0 5px #fff;
            }

            .hovereffect a.info, .hovereffect h2 {
                -webkit-transform: scale(0.7);
                -ms-transform: scale(0.7);
                transform: scale(0.7);
                -webkit-transition: all 0.4s ease-in;
                transition: all 0.4s ease-in;
                opacity: 0;
                filter: alpha(opacity=0);
                color: #fff;
                text-transform: uppercase;
            }

            .hovereffect:hover a.info, .hovereffect:hover h2 {
                opacity: 1;
                filter: alpha(opacity=100);
                -webkit-transform: scale(1);
                -ms-transform: scale(1);
                transform: scale(1);
            }

            .table-sortable tbody tr {
                cursor: move;
            }

        </style>
        
        <script>
            $(document).ready(function () {
                $("#add_row").on("click", function () {
                    // Dynamic Rows Code

                    // Get max row id and set new id
                    var newid = 0;
                    $.each($("#tab_logic tr"), function () {
                        if (parseInt($(this).data("id")) > newid) {
                            newid = parseInt($(this).data("id"));
                        }
                    });
                    newid++;

                    var tr = $("<tr></tr>", {
                        id: "addr" + newid,
                        "data-id": newid
                    });

                    // loop through each td and create new elements with name of newid
                    $.each($("#tab_logic tbody tr:nth(0) td"), function () {
                        var cur_td = $(this);

                        var children = cur_td.children();

                        // add new td and element if it has a nane
                        if ($(this).data("name") != undefined) {
                            var td = $("<td></td>", {
                                "data-name": $(cur_td).data("name")
                            });

                            var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                            c.attr("name", $(cur_td).data("name") + newid);
                            c.appendTo($(td));
                            td.appendTo($(tr));
                        } else {
                            var td = $("<td></td>", {
                                'text': $('#tab_logic tr').length
                            }).appendTo($(tr));
                        }
                    });

                    // add the new row
                    $(tr).appendTo($('#tab_logic'));

                    $(tr).find("td button.row-remove").on("click", function () {
                        $(this).closest("tr").remove();
                    });
                });

                // Sortable Code
                var fixHelperModified = function (e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();

                    $helper.children().each(function (index) {
                        $(this).width($originals.eq(index).width())
                    });

                    return $helper;
                };

                $(".table-sortable tbody").sortable({
                    helper: fixHelperModified
                }).disableSelection();

                $(".table-sortable thead").disableSelection();



                $("#add_row").trigger("click");
            });

            $(document).ready(function () {
                $("#add_row_account").on("click", function () {
                    // Dynamic Rows Code

                    // Get max row id and set new id
                    var newid = 0;
                    $.each($("#tab_account tr"), function () {
                        if (parseInt($(this).data("id")) > newid) {
                            newid = parseInt($(this).data("id"));
                        }
                    });
                    newid++;

                    var tr = $("<tr></tr>", {
                        id: "addr" + newid,
                        "data-id": newid
                    });

                    // loop through each td and create new elements with name of newid
                    $.each($("#tab_account tbody tr:nth(0) td"), function () {
                        var cur_td = $(this);

                        var children = cur_td.children();

                        // add new td and element if it has a nane
                        if ($(this).data("name") != undefined) {
                            var td = $("<td></td>", {
                                "data-name": $(cur_td).data("name")
                            });

                            var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                            c.attr("name", $(cur_td).data("name") + newid);
                            c.appendTo($(td));
                            td.appendTo($(tr));
                        } else {
                            var td = $("<td></td>", {
                                'text': $('#tab_account tr').length
                            }).appendTo($(tr));
                        }
                    });

                    // add the new row
                    $(tr).appendTo($('#tab_account'));

                    $(tr).find("td button.row-remove").on("click", function () {
                        $(this).closest("tr").remove();
                    });
                });

                // Sortable Code
                var fixHelperModified = function (e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();

                    $helper.children().each(function (index) {
                        $(this).width($originals.eq(index).width())
                    });

                    return $helper;
                };

                $(".table-sortable tbody").sortable({
                    helper: fixHelperModified
                }).disableSelection();

                $(".table-sortable thead").disableSelection();



                $("#add_row_account").trigger("click");
            });
        </script>
<script src="ownerPage.js"></script>
    </head>
    <body> 
        <div class="container-fluid">
            <div class="mainInfo col-md-12">
                <h1>Profile</h1>
                <div class="row">
                    <div class="restaurantpic col-md-4">
                        <a href="#" data-toggle="modal" data-target="#modal-logo">
                             <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($restaurantInfo['thumbnail']) ?>" class="img-rounded" height="300" width="300" />
                        </a>
                        <br><br>
                        
                        <?php
                        
                        for ($i=0; $i<$imageCount; $i++) {
                            echo '<a href="#" data-toggle="modal" data-target="#modal-thumbnail' . $i . '">';
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($restaurantImages[$i]['media']) . '" class="img-rounded" height="80" width="80"/>';
                            echo '</a>   ';
                        }
                        ?>
                        
                        <div class="modal fade" id="modal-logo" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Logo</h4>
                                    </div>
                                    <div class="modal-body">
                                        <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($restaurantInfo['thumbnail'])?>" class="img-rounded img-responsive"/>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php    
                        for ($i=0; $i<$imageCount; ++$i) {
                            echo '<div class="modal fade" id="modal-thumbnail' . $i . '" role="dialog">';
                            echo   '<div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>';
                                        echo    '<h4 class="modal-title">Thumbnail' . $i .'</h4>';
                                        echo '</div>
                                            <div class="modal-body">';
                                        echo '<img src="data:image/jpeg;base64,' . base64_encode($restaurantImages[$i]['media']) . '" class="img-rounded img-responsive"/>';
                                        echo '</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        } 
                        ?>
                       
                    </div>
                    <div class="restaurant-detail1 col-md-4">
                        <h1><?php echo $restaurantInfo['name'];?></h1>
                        <h3>Food type:</h3>
                        <p><?php echo $restaurantInfo['food_category_name'];?></p>
                        <h3>Description:</h3>
                        <p><?php echo $restaurantInfo['description'];?></p>
                        <h3>Address:</h3>
                        <p><?php echo $restaurantInfo['address'];?></p>
                        <h3>Phone:</h3>
                        <p><?php echo $restaurantInfo['phone_no'];?></p>
                    </div>
                    <div class="restaurant-detail2 col-md-4">
                        <h3>Operating Hours:</h3>
                        <ul class="list-group operating-hour-list">
                            <?php $show = !empty($oprHours); ?>
                            <li class="list-group-item"><b>Monday </b><?php echo $show ? $oprHours["monday_from"] . " - " . $oprHours["monday_to"] : ''; ?></li>
                            <li class="list-group-item"><b>Tuesday </b><?php echo $show ? $oprHours["tuesday_from"] . " - " . $oprHours["tuesday_to"] : ''; ?></li>
                            <li class="list-group-item"><b>Wednesday </b><?php echo $show ? $oprHours["wednesday_from"] . " - " . $oprHours["wednesday_to"] : ''; ?></li>
                            <li class="list-group-item"><b>Thursday </b><?php echo $show ? $oprHours["thursday_from"] . " - " . $oprHours["thursday_to"] : ''; ?></li>
                            <li class="list-group-item"><b>Friday </b><?php echo $show ? $oprHours["friday_from"] . " - " . $oprHours["friday_to"] : ''; ?></li>
                            <li class="list-group-item"><b>Saturday </b><?php echo $show ? $oprHours["saturday_from"] . " - " . $oprHours["saturday_to"] : ''; ?></li>
                            <li class="list-group-item"><b>Sunday </b><?php echo $show ? $oprHours["sunday_from"] . " - " . $oprHours["sunday_to"] : ''; ?></li>
                        </ul>
                    </div>
                </div>
                <br><br><br>
                <div class="row">
                    <div class="restaurantmenuchange col-md-12">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="#change-detail" data-toggle="tab">Restaurant Details</a></li>
                            <li role="presentation"><a href="#change-photo" data-toggle="tab">Gallery </a></li>
                            <li role="presentation"><a href="#change-hours" data-toggle="tab">Operating Hours</a></li>
                            <li role="presentation"><a href="#change-menu" data-toggle="tab">Menu</a></li>
                            <li role="presentation"><a href="#change-specialevent" data-toggle="tab">Special Events</a></li>
                            <li role="presentation"><a href="#change-hostaccount" data-toggle="tab">Host Accounts</a></li>
                            <li role="presentation"><a href="#reviews" data-toggle="tab">Review</a></li>
                            <li role="presentation"><a href="#change-profile" data-toggle="tab">Edit Profile</a></li>
                        </ul>
                    </div>

                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="change-detail">
                            <br><br>
                            <!--<form class = "descriptionform" role = "form">-->
                                <div class = "form-group">
                                    <br><br>
                                    <label for = "name">Description (150 characters max):</label>
                                    <textarea class="form-control" rows="3" placeholder="" id="restaurant-description"><?php echo $restaurantInfo['description']; ?></textarea>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Address (100 characters max):</label>
                                            <textarea class="form-control" rows="1" id="restaurant-address"><?php echo $restaurantInfo['address']; ?></textarea>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Phone (20 characters max):</label>
                                            <textarea class="form-control" rows="1" id="restaurant-phone"><?php echo $restaurantInfo['phone_no']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button id="restaurant-detail-submit" class="btn btn-default" data-restaurant-id="<?php echo $resId; ?>">Change Restaurant Information</button>
                            <!--</form>-->
                        </div>
                    
                        <div class="tab-pane fade" id="change-photo">
                            <div class="restaurantmenuchange col-md-12">
                                <div class="row">
                                    <h3>Profile Photo:</h3>
                                    <div class = "col-sm-6 col-md-3">
                                        <div class = "thumbnail">
                                            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($restaurantInfo['thumbnail']).'" class="img-rounded"/>'; ?>
                                        </div>
                                        <p>Upload a new photo:</p>
                                        <form id="profile-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
                                        <input type="file" name="profile-image" id="profile-image" /><br>
                                        <input type="text" name="image_type" value="profile" hidden="true"/>
                                        <button type = "button" class = "btn btn-default" onClick="submitImage('profile-image', 'profile-form')">Upload</button>
                                        </form>
                                    </div>
                                </div>
                                <div class = "row">
                                    <br>
                                    <h3>Thumbnail Photo:</h3>
                                    <div class = "col-sm-6 col-md-3">
                                        <div class = "thumbnail">
                                            <?php $i=0; 
                                            if ($i<$imageCount) {
                                                echo '<img src="data:image/jpeg;base64,'.base64_encode($restaurantImages[$i]['media']).'" class="img-rounded"/>';
                                            }
                                            else {
                                                echo '<img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Aiga_restaurant_knife-fork_crossed.png" class="img-rounded">';
                                            }
                                            ?>
                                        </div>
                                        <p>Upload a new photo:</p>
                                        <form id="multimedia-form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
                                        <input type="file" name="multimedia-image" id="multimedia-image1" /><br>
                                        <input type="text" name="image_type" value="multimedia" hidden="true" />
                                        <input type="text" name="multimedia-id" value="<?php echo $i<$imageCount ? $restaurantImages[$i]['multimedia_id'] : -1; $i++; ?>" hidden="true" /> 
                                        <button type = "button" class = "btn btn-default" onClick="submitImage('multimedia-image1', 'multimedia-form1')">Upload</button>
                                        </form>
                                    </div>
                                    <div class = "col-sm-6 col-md-3">
                                        <div class = "thumbnail">
                                            <?php
                                            if ($i<$imageCount) {
                                                echo '<img src="data:image/jpeg;base64,'.base64_encode($restaurantImages[$i]['media']).'" class="img-rounded"/>';
                                            }
                                            else {
                                                echo '<img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Aiga_restaurant_knife-fork_crossed.png" class="img-rounded">';
                                            }
                                            ?>
                                        </div>
                                        <p>Upload a new photo:</p>
                                        <form id="multimedia-form2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
                                        <input type="file" name="multimedia-image" id="multimedia-image2" /><br>
                                        <input type="text" name="image_type" value="multimedia" hidden="true" />
                                        <input type="text" name="multimedia-id" value="<?php echo $i<$imageCount ? $restaurantImages[$i]['multimedia_id'] : -1; $i++; ?>" hidden="true" /> 
                                        <button type = "button" class = "btn btn-default" onClick="submitImage('multimedia-image2', 'multimedia-form2')">Upload</button>
                                        </form>
                                    </div>
                                    <div class = "col-sm-6 col-md-3">
                                        <div class = "thumbnail">
                                            <?php
                                            if ($i<$imageCount) {
                                                echo '<img src="data:image/jpeg;base64,'.base64_encode($restaurantImages[$i]['media']).'" class="img-rounded"/>';
                                            }
                                            else {
                                                echo '<img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Aiga_restaurant_knife-fork_crossed.png" class="img-rounded">';
                                            }
                                            ?>
                                        </div>
                                        <p>Upload a new photo:</p>
                                        <form id="multimedia-form3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
                                        <input type="file" name="multimedia-image" id="multimedia-image3" /><br>
                                        <input type="text" name="image_type" value="multimedia" hidden="true" />
                                        <input type="text" name="multimedia-id" value="<?php echo $i<$imageCount ? $restaurantImages[$i]['multimedia_id'] : -1; $i++; ?>" hidden="true" /> 
                                        <button type = "button" class = "btn btn-default" onClick="submitImage('multimedia-image3', 'multimedia-form3')">Upload</button>
                                        </form>
                                    </div>
                                    <div class = "col-sm-6 col-md-3">
                                        <div class = "thumbnail">
                                            <?php
                                            if ($i<$imageCount) {
                                                echo '<img src="data:image/jpeg;base64,'.base64_encode($restaurantImages[$i]['media']).'" class="img-rounded"/>';
                                            }
                                            else {
                                                echo '<img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Aiga_restaurant_knife-fork_crossed.png" class="img-rounded">';
                                            }
                                            ?>
                                        </div>
                                        <p>Upload a new photo:</p>
                                        <form id="multimedia-form4" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
                                        <input type="file" name="multimedia-image" id="multimedia-image4" /><br>
                                        <input type="text" name="image_type" value="multimedia" hidden="true" />
                                        <input type="text" name="multimedia-id" value="<?php echo $i<$imageCount ? $restaurantImages[$i]['multimedia_id'] : -1; $i++; ?>" hidden="true" /> 
                                        <button type = "button" class = "btn btn-default" onClick="submitImage('multimedia-image4', 'multimedia-form4')">Upload</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="change-hours">
                            <div class="form-group">
                                <br><br>
                                <h3>Hours of Operation:</h3>
                                <br>
                                <label>Monday</label>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>From</label>
                                        <input type="time" id="monday-from" class="form-control" value="<?php echo $oprHours["monday_from"]; ?>">
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>To</label>
                                        <input type="time" id="monday-to" class="form-control" value="<?php echo $oprHours["monday_to"]; ?>">
                                    </div>
                                </div>
                                <label>Tuesday</label>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>From</label>
                                        <input type="time" id="tuesday-from" class="form-control" value="<?php echo $oprHours["tuesday_from"]; ?>"> 
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>To</label>
                                        <input type="time" id="tuesday-to" class="form-control" value="<?php echo $oprHours["tuesday_to"]; ?>">
                                    </div>
                                </div>  
                                <label>Wednesday</label>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>From</label>
                                        <input type="time" id="wednesday-from" class="form-control" value="<?php echo $oprHours["wednesday_from"]; ?>"> 
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>To</label>
                                        <input type="time" id="wednesday-to" class="form-control" value="<?php echo $oprHours["wednesday_to"]; ?>">
                                    </div>
                                </div> 
                                <label>Thursday</label>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>From</label>
                                        <input type="time" id="thursday-from" class="form-control" value="<?php echo $oprHours["thursday_from"]; ?>"> 
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>To</label>
                                        <input type="time" id="thursday-to" class="form-control" value="<?php echo $oprHours["thursday_to"]; ?>">
                                    </div>
                                </div> 
                                <label>Friday</label>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>From</label>
                                        <input type="time" id="friday-from" class="form-control" value="<?php echo $oprHours["friday_from"]; ?>"> 
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>To</label>
                                        <input type="time" id="friday-to" class="form-control" value="<?php echo $oprHours["friday_to"]; ?>">
                                    </div>
                                </div>
                                <label>Saturday</label>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>From</label>
                                        <input type="time" id="saturday-from" class="form-control" value="<?php echo $oprHours["saturday_from"]; ?>"> 
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>To</label>
                                        <input type="time" id="saturday-to" class="form-control" value="<?php echo $oprHours["saturday_to"]; ?>">
                                    </div>
                                </div> 
                                <label>Sunday</label>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label>From</label>
                                        <input type="time" id="sunday-from" class="form-control" value="<?php echo $oprHours["sunday_from"]; ?>"> 
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label>To</label>
                                        <input type="time" id="sunday-to" class="form-control" value="<?php echo $oprHours["sunday_to"]; ?>">
                                    </div>
                                </div>
                            </div>
                            <button id="operating-hours-submit" type = "submit" class = "btn btn-default" data-restaurant-id="<?php echo $resId; ?>">Change Operating Hours</button>
                        </div>
                        <div class="tab-pane fade" id="change-menu">
                            <div class="col-md-12">
                                <h3>Upload a new menu:</h3>
                                    <form id="menu-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
                                        <input type="file" name="menu-image" id="menu-image" /><br>
                                        <input type="text" name="image_type" value="menu" hidden="true"/>
                                        <button type = "button" class = "btn btn-default" onClick="submitImage('menu-image', 'menu-form')">Upload Menu</button>
                                    </form>
                                <br><br>
                                <h3>Current Menu:</h3>
                                <img src="<?php echo empty($restaurantInfo['menu']) ? 'https://goo.gl/a3MbBt' : 'data:image/jpeg;base64,'.base64_encode($restaurantInfo['menu']); ?>" class="img-rounded" >
                            </div>
                        </div>
                        <div class="tab-pane fade" id="change-specialevent">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <br><br>
                                        <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Event Name</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Description</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--<tr id='addr0' data-id="0" class="hidden">-->
                                                    <?php
                                                    foreach($eventArray as $event) {
                                                        echo '<tr id="add" data-id="0">';
                                                        echo '<td data-name="name">';
                                                        echo '<input type="text" name="event-name" class="form-control" value="'. $event['title'] . '" /></td>';
                                                        echo '<td data-name="Date">';
                                                        echo '<input type="text" name="event-date" placeholder="Event Date" class="form-control" value="'. $event['date'] . '" /></td>';
                                                        echo '<td data-name="desc">';
                                                        echo '<input type="text" name="event-description" placeholder="Event Description" class="form-control" value="'. $event['description'] . '" /></td>';
                                                        echo '<td data-name="del">
                                                                <button name="del" class="btn btn-danger glyphicon glyphicon-remove row-remove"></button>
                                                              </td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
<!--                                                    <td data-name="name">
                                                        <input type="text" name='name0'  placeholder='Event Name' class="form-control"/>
                                                    </td>
                                                    <td data-name="Date">
                                                        <input type="text" name='date0' placeholder='Event date' class="form-control"/>
                                                    </td>
                                                    <td data-name="desc">
                                                        <textarea class = "form-control" name='desc0' placeholder='Event Description' rows = "3"></textarea>
                                                    </td>
                                                    <td data-name="del">
                                                        <button name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                                    </td>
                                                </tr>-->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <a id="add_row" class="btn btn-default pull-right">Add Row</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="change-hostaccount">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <br><br>
                                        <table class="table table-bordered table-hover table-sortable" id="tab_account">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Host Account</th>
                                                    <th class="text-center">Password</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id='addr0' data-id="0" class="hidden">
                                                    <td data-name="account">
                                                        <input type="text" name='account0'  placeholder='Account Name' class="form-control"/>
                                                    </td>
                                                    <td data-name="password">
                                                        <input type="text" name='pass0' placeholder='Password' class="form-control"/>
                                                    </td>
                                                    <td data-name="del">
                                                        <button name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <a id="add_row_account" class="btn btn-default pull-right">Add Account</a>
                            </div>
                        </div>
                        <div id="reviews" class="tab-pane fade">
                            <h4> Reviews from Users </h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody id="item">
                                        <tr>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- Report review End -->
                        <div id="change-profile" class="tab-pane fade">
                            <form class="form" action="##" method="post" id="editregistrationform">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="phone_number"><h4>Phone Number</h4></label>
                                        <input type="tel" class="form-control" name="phone_number" id="phone_number" value=" "  placeholder="(xxx) xxx-xxxx" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="email"><h4>Email</h4></label>
                                        <input type="email" class="form-control" name="email" id="email" value=" " placeholder="you@email.com" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="password"><h4>Password</h4></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="enter new password" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="password2"><h4>Reenter password</h4></label>
                                        <input type="password" class="form-control" name="password2" id="password2" placeholder="re-enter new password" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <br>
                                        <button class="btn btn-default" type="submit" id="submit_button"><i class="glyphicon glyphicon-ok-sign"></i>Submit</button>
                                        <button class="btn btn-default" type="reset"><i class="glyphicon glyphicon-repeat"></i>Reset</button>
                                    </div>
                                </div>
                            </form> <!-- End of the edit the profile form -->
                        </div><!-- End of the Setting -->
                    </div>

                </div>
            </div>
        </div>


        <div class = "navbar navbar-default navbar-bottom">
            <div class = "container">
                <p class="navbar-text navbar-left">This website belongs to SFSU Course CSC648/CSC848 Fall 15 Group 11</p>
            </div>
        </div>  
    </body>
</html>