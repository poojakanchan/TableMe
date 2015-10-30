<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>SK M0 (Group 11)</title>
    </head>
    <body>
        
        <div style="text-align:center">
        <h1>Please upload a photo!</h1>
        
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <p style="font-size:20px"> <strong>Choose a photo: </strong> </p>
            <input type="file" name="file" id="file" /><br/>
            <p style="font-size:20px"><strong><em>Description of the Image:</em></strong></p>
            <textarea name="description" id="description" rows="5" cols="50" placeholder="Please Describe" style="font-size:20px"></textarea><br/>
            <input type="submit" name="submit" value="Upload" /><br/>
        </form>
        </div>
    </body>
</html>