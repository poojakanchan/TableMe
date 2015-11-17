<html lang="en">
<?php

require_once 'header.php';
if(!isset($_SESSION['username'])) {
    header('location: ../home/login.php');
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
            $(document).ready(function() {
            $("#add_row").on("click", function() {
                // Dynamic Rows Code

                // Get max row id and set new id
                var newid = 0;
                $.each($("#tab_logic tr"), function() {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;

                var tr = $("<tr></tr>", {
                    id: "addr"+newid,
                    "data-id": newid
                });

                // loop through each td and create new elements with name of newid
                $.each($("#tab_logic tbody tr:nth(0) td"), function() {
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

                $(tr).find("td button.row-remove").on("click", function() {
                     $(this).closest("tr").remove();
                });
        });

            // Sortable Code
            var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();

                $helper.children().each(function(index) {
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
        
        $(document).ready(function() {
            $("#add_row_account").on("click", function() {
                // Dynamic Rows Code

                // Get max row id and set new id
                var newid = 0;
                $.each($("#tab_account tr"), function() {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;

                var tr = $("<tr></tr>", {
                    id: "addr"+newid,
                    "data-id": newid
                });

                // loop through each td and create new elements with name of newid
                $.each($("#tab_account tbody tr:nth(0) td"), function() {
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

                $(tr).find("td button.row-remove").on("click", function() {
                     $(this).closest("tr").remove();
                });
        });

            // Sortable Code
            var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();

                $helper.children().each(function(index) {
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
        
</head>
<body>
    
    <div class="container-fluid">
        <div class="mainInfo col-md-12">
            <h1>Profile</h1>
            <div class="row">
                <div class="restaurantpic col-md-4">
                    <a href="#" data-toggle="modal" data-target="#modal-logo">
                        <img alt="Logo" src="http://goo.gl/vrq2Cw" class="img-rounded" height="300" width="300"/>
                    </a>
                    <br><br><br><br>
                    <a href="#" data-toggle="modal" data-target="#modal-thumbnail1">
                        <img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="100" width="100"/>
                    </a>
                    <a href="#" data-toggle="modal" data-target="#modal-thumbnail2">
                        <img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="100" width="100"/>
                    </a>
                    <a href="#" data-toggle="modal" data-target="#modal-thumbnail3">
                        <img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="100" width="100"/>
                    </a>
                    <a href="#" data-toggle="modal" data-target="#modal-thumbnail4">
                        <img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="100" width="100"/>
                    </a>
                    <div class="modal fade" id="modal-logo" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Logo</h4>
                                </div>
                                <div class="modal-body">
                                    <img src="http://goo.gl/vrq2Cw" class="img-responsive">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-thumbnail1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Thumbnail1</h4>
                                </div>
                                <div class="modal-body">
                                    <img src="https://goo.gl/GOzAhf" class="img-responsive">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-thumbnail2" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Thumbnail2</h4>
                                </div>
                                <div class="modal-body">
                                    <img src="https://goo.gl/GOzAhf" class="img-responsive">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-thumbnail3" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Thumbnail3</h4>
                                </div>
                                <div class="modal-body">
                                    <img src="https://goo.gl/GOzAhf" class="img-responsive">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-thumbnail4" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Thumbnail4</h4>
                                </div>
                                <div class="modal-body">
                                    <img src="https://goo.gl/GOzAhf" class="img-responsive">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="restaurant-detail1 col-md-4">
                    <h1>Little Tokyo</h1>
                    <h3>Food type:</h3>
                    <p>The restaurant Food type from db should be here!</p>
                    <h3>Description:</h3>
                    <p>The restaurant description from db should be here!</p>
                    <h3>Address:</h3>
                    <p>The restaurant address from db should be here!</p>
                    <h3>Phone:</h3>
                    <p>The restaurant phone number from db should be here!</p>
                </div>
                <div class="restaurant-detail2 col-md-4">
                    <h3>Operating Hours:</h3>
                    <ul class="list-group operating-hour-list">
                        <li class="list-group-item">Monday</li>
                        <li class="list-group-item">Tuesday</li>
                        <li class="list-group-item">Wednesday</li>
                        <li class="list-group-item">Thursday</li>
                        <li class="list-group-item">Friday</li>
                        <li class="list-group-item">Saturday</li>
                        <li class="list-group-item">Sunday</li>
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
                        <li role="presentation"><a href="#change-profile" data-toggle="tab">Edit Profile</a></li>
                    </ul>
                </div>
                
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="change-detail">
                        <br><br>
                        <form class = "descriptionform" role = "form">
                            <div class = "form-group">
                                <br><br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Type of Food:</label>
                                        <select class="selectpicker" name="food_category" required data-width="auto">
                                            <option value="" disabled selected>Food type</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <label for = "name">Description:</label>
                                <textarea class = "form-control" rows = "3"></textarea>
                                <br><br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Address:</label>
                                        <input type="text" name="restaurantStreet" placeholder="Please enter the restaurant's address..." class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>City:</label>
                                        <input type="text" name="restaurantCity" placeholder="Enter City Here..." class="form-control">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>State:</label>
                                        <input type="text" name="restaurantState" placeholder="Enter State Here..." class="form-control">
                                    </div>	
                                    <div class="col-sm-4">
                                        <label>Zip:</label>
                                        <input type="number" name="restaurantZip" placeholder="Enter Zip Code Here..." class="form-control">
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Phone:</label>
                                        <input type="text" name="restaurantPhone" placeholder="Please enter the restaurant's phone..." class="form-control">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button type = "submit" class = "btn btn-default">Change</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="change-photo">
                        <div class="restaurantmenuchange col-md-12">
                            <div class="row">
                                <h3>Profile Photo:</h3>
                                <div class = "col-sm-6 col-md-3">
                                    <div class = "thumbnail">
                                        <img src = "http://goo.gl/vrq2Cw" alt = "Restaurant photo" class="img-rounded" >
                                    </div>
                                    <p>Upload a new photo:</p>
                                    <input type="file" name="file" id="file" /><br>
                                    <button type = "submit" class = "btn btn-default">Upload</button>
                                </div>
                            </div>
                            <div class = "row">
                                <br>
                                <h3>Gallery:</h3>
                                <div class = "col-sm-6 col-md-3">
                                    <div class = "thumbnail">
                                        <img src = "https://goo.gl/GOzAhf" alt = "Restaurant photo" class="img-rounded" >
                                    </div>
                                    <p>Upload a new photo:</p>
                                    <input type="file" name="file" id="file" /><br>
                                    <button type = "submit" class = "btn btn-default">Upload</button>
                                </div>
                                <div class = "col-sm-6 col-md-3">
                                    <div class = "thumbnail">
                                        <img src = "https://goo.gl/GOzAhf" alt = "Restaurant photo" class="img-rounded" >
                                    </div>
                                    <p>Upload a new photo:</p>
                                    <input type="file" name="file" id="file" /><br>
                                    <button type = "submit" class = "btn btn-default">Upload</button>
                                </div>
                                <div class = "col-sm-6 col-md-3">
                                    <div class = "thumbnail">
                                        <img src = "https://goo.gl/GOzAhf" alt = "Restaurant photo" class="img-rounded" >
                                    </div>
                                    <p>Upload a new photo:</p>
                                    <input type="file" name="file" id="file" /><br>
                                    <button type = "submit" class = "btn btn-default">Upload</button>
                                </div>
                                <div class = "col-sm-6 col-md-3">
                                    <div class = "thumbnail">
                                        <img src = "https://goo.gl/GOzAhf" alt = "Restaurant photo" class="img-rounded" >
                                    </div>
                                    <p>Upload a new photo:</p>
                                    <input type="file" name="file" id="file" /><br>
                                    <button type = "submit" class = "btn btn-default">Upload</button>
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
                                    <input type="time" name="mondayFrom" class="form-control" >
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>To</label>
                                    <input type="time" name="mondayTo" class="form-control" >
                                </div>
                            </div>
                            <label>Tuesday</label>
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>From</label>
                                    <input type="time" name="tuesdayFrom" class="form-control" > 
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>To</label>
                                    <input type="time" name="tuesdayTo" class="form-control" >
                                </div>
                            </div>  
                            <label>Wednesday</label>
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>From</label>
                                    <input type="time" name="wednesdayFrom" class="form-control" > 
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>To</label>
                                    <input type="time" name="wednesdayTo" class="form-control" >
                                </div>
                            </div> 
                            <label>Thursday</label>
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>From</label>
                                    <input type="time" name="thursdayFrom" class="form-control" > 
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>To</label>
                                    <input type="time" name="thursdayTo" class="form-control" >
                                </div>
                            </div> 
                            <label>Friday</label>
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>From</label>
                                    <input type="time" name="fridayFrom" class="form-control" > 
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>To</label>
                                    <input type="time" name="fridayTo" class="form-control" >
                                </div>
                            </div>
                            <label>Saturday</label>
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>From</label>
                                    <input type="time" name="saturdayFrom" class="form-control" > 
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>To</label>
                                    <input type="time" name="saturdayTo" class="form-control" >
                                </div>
                            </div> 
                            <label>Sunday</label>
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>From</label>
                                    <input type="time" name="sundayFrom" class="form-control" > 
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>To</label>
                                    <input type="time" name="sundayTo" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <button type = "submit" class = "btn btn-default">Change</button>
                    </div>
                    <div class="tab-pane fade" id="change-menu">
                        <div class="col-md-12">
                            <h3>Upload a new menu:</h3>
                            <input type="file" name="file" id="file" /><br>
                            <button type = "submit" class = "btn btn-default">Upload</button>
                            <br><br>
                            <h3>Current Menu:</h3>
                            <img src = "https://goo.gl/a3MbBt" alt = "Restaurant photo" class="img-rounded" >
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
                                            <tr id='addr0' data-id="0" class="hidden">
                                                <td data-name="name">
                                                    <input type="text" name='name0'  placeholder='Event Name' class="form-control"/>
                                                </td>
                                                <td data-name="Date">
                                                    <input type="text" name='date0' placeholder='Event date' class="form-control"/>
                                                </td>
                                                <td data-name="desc">
                                                    <textarea class = "form-control" name='desc0' placeholder='Event Description' rows = "3"></textarea>
                                                </td>
                                                <td data-name="del">
                                                    <button nam"del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                                </td>
                                            </tr>
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
                                                <th class="text-center">Host Name</th>
                                                <th class="text-center">Email Address</th>
                                                <th class="text-center">Host Account</th>
                                                <th class="text-center">Password</th>
                                                <th class="text-center">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id='addr0' data-id="0" class="hidden">
                                                <td data-name="hostName">
                                                    <input type="text" name='hostName'  placeholder='Host Name' class="form-control"/>
                                                </td>
                                                 <td data-name="hostAccount">
                                                    <input type="text" name='hostAccount'  placeholder='User Name' class="form-control"/>
                                                </td>
                                                 <td data-name="hostEmail">
                                                    <input type="text" name='hostEmail'  placeholder='Email' class="form-control"/>
                                                </td>
                                                
                                                <td data-name="password">
                                                    <input type="text" name='password' placeholder='Password' class="form-control"/>
                                                </td>
                                                <td data-name="del">
                                                    <button nam"del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a id="add_row_account" class="btn btn-default pull-right">Add Account</a>
                        </div>
                    </div>
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
                                    <button class="btn btn-default" type="submit" id="submit_button"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                    <button class="btn btn-default" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
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