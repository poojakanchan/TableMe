<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            <p>
                Search a restaurant by name or address: <input type="text" name="nameAdd" id="nameAdd" required/>
                <input type="submit" value="Search" name="submit"/>
            </p>
        </form>
        <?php
        include './DBFunctions.php';
//        $resArray = array('name'=>'Little Tokyo', 'owner_id'=>'1', 'phone_no'=>'6503231794',
//            'address'=>'131 W Market St, San Francisco, CA 91301', 'description'=>'fine sashimi',
//            'food_category_id'=>'1', 'flag_new'=>'1', 'capacity'=>'150');
        if($_POST) {
            $name = htmlspecialchars($_POST["nameAdd"]);
            $db = new DB();
            //$db->addARestaurant($resArray);
            $result = $db->findRestaurantsByNameAddress($name);
            if(!empty($result)) {
                echo "Found ".count($result)." restaurants:<br>";
                foreach($result as $restaurant) {                    
                    echo "Restaurant name: ".$restaurant['name']."<br>";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode($restaurant['thumbnail']).'"/><br>';
                    echo "Restaurant address: ".$restaurant['address']."<br>";
                    echo "Restaurant phone number: ".$restaurant['phone_no']."<br>";
                    echo "Restaurant food category: ".$restaurant['food_category_name']."<br>";
                    echo "Restaurant description: ".$restaurant['description']."<br><br>";
                }
            }
            else {
                echo "No restaurant found"."<br>";
            }
        }
        ?>
    </body>
</html>