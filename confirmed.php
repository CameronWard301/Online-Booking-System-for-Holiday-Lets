<?php session_start(); //gets the session details
/**
 * Created by PhpStorm.
 * User: camer
 * Date: 06/01/2019
 * Time: 15:33
 */
session_destroy(); //removes all data from the session

?>
<!DOCTYPE html> <!--Specifies Dock type-->
<html lang="en"> <!--specifies language-->
<head>
    <meta charset="UTF-8"> <!--Specifies the character set-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> <!--This makes the web page responsive-->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Narrow:400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> <!--This loads the font for the website-->
    <link rel="stylesheet" type="text/css" href="styles.php"> <!--Links the style sheet to the html document-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="User_Details_jQuery.js"></script>
    <title>Confirmed</title> <!--Sets the page title which appears in browser tab-->
</head>
<body>

<div class="BookingFormUserInfo tab">

    <div>
        <div class="summary">
            <h1>All Done!</h1>
            <h2>Your booking has been received and a request has been sent to the owner</h2>
            <h3>You should receive an email shortly.</h3>
        </div>
        <div class="prev_step">
            <a href="index.php"><button type="button" id="prev_step">Home Page</button></a>
        </div>

</body>
</html>

