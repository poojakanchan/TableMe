<html lang="en">
<head>
	<title>EZ Restaurant</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        
        <!-- Will merge into js file after all is done. -->
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
    
    <?php
        include ('header.php');
    ?>
    
    <div class="container-fluid">
        <div class="mainInfo col-md-12">
            <h1>Profile</h1>
            <div class="restaurantprofile col-md-12">
                <div class="restaurantpic col-md-3">
                    <img alt="Logo" src="http://goo.gl/vrq2Cw" class="img-rounded" height="200" width="200" />
                </div>
                <div class="restaurantname col-md-9">
                    <h1>Little Tokyo</h1>
                    <h2>Japanese food</h2>
                    <form class = "descriptionform" role = "form">
                        <div class = "form-group">
                            <label for = "name">Description:</label>
                            <textarea class = "form-control" rows = "3"></textarea>
                        </div>

                        <div class = "form-group">
                            <button type = "submit" class = "btn btn-default">Change</button>
                        </div>
                     </form>
                </div>
                
                <div class="restaurantmenuchange col-md-12">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="#change-photo" data-toggle="tab">Restaurant Photo</a></li>
                        <li role="presentation"><a href="#change-menu" data-toggle="tab">Menu</a></li>
                        <li role="presentation"><a href="#change-specialevent" data-toggle="tab">Special Events</a></li>
                        <li role="presentation"><a href="#change-hostaccount" data-toggle="tab">Host Accounts</a></li>
                    </ul>
                </div>
                
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="change-photo">
                        <div class = "row">
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
                    <div class="tab-pane fade" id="change-menu">
                        <br><br>
                        <p>Upload a new menu:</p>
                        <input type="file" name="file" id="file" /><br>
                        <button type = "submit" class = "btn btn-default">Upload</button>
                        <br><br>
                        <p>Current Menu:</p>
                        <img src = "https://goo.gl/a3MbBt" alt = "Restaurant photo" class="img-rounded" >
                    </div>
                    <div class="tab-pane fade" id="change-specialevent">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Event Name</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;"></th>
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
                                                    <!--<input type="text" name='desc0' placeholder='Event Description' class="form-control"/>-->
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
                                    <table class="table table-bordered table-hover table-sortable" id="tab_account">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Host Account</th>
                                                <th class="text-center">Password</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;"></th>
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