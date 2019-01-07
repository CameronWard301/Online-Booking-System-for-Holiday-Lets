<?php session_start(); //starts a session so that when the details appear on the next page they can be called and displayed
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 22/07/2018
 * Time: 11:10
 */
//phpinfo();
include ("config.php");
include('User_Validation_Booking.php');/* Loads the code from the external php doc*/
include ('Calendar.php');
global $year, $month, $grid;

if (!isset($_SESSION['arrive_Date']) || !isset($_SESSION['depart_Date']) || !isset($_SESSION['num_Adults']) || !isset($_SESSION['num_Children']) || !isset($_SESSION['price'])){
    $_SESSION['arrive_Date'] = ""; //sets the variables to session variables
    $_SESSION['depart_Date'] = "";
    $_SESSION['num_Adults'] = $min_Adults;
    $_SESSION['num_Children'] = $min_Children;
    $_SESSION['price'] = 0;
}




?>


<!DOCTYPE html> <!--Specifies Dock type-->
<html lang="en"> <!--specifies language-->
<head>
    <meta charset="UTF-8"> <!--Specifies the character set-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> <!--This makes the web page responsive-->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Narrow:400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> <!--This loads the font for the website-->
    <link rel="stylesheet" type="text/css" href="styles.php"> <!--Links the style sheet to the html document-->
    <script src="Show_Calendar.js"></script>
    <script src="moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="index_jQuery.js"></script>
    <title>Booking Form</title> <!--Sets the page title which appears in browser tab-->
</head>
<body>
<input type="hidden" id="config" value='<?=$configJSON?>'>
<input type="hidden" id="bookingsArray" value='<?=$bookingsArrayJSON?>'>

<div class="wrapper"> <!--This is used to space the web page out allowing the iframe to take up most of the space-->

    <div class="booking_form">
        <form action= "<?= $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off" name="booking_form">
            <!--When the submit button is pressed the server calls itself and the method used is POST-->

            <div class="AvailabilityCalender tab" id="step_1">



                <div>
                    <label style="padding-left: 1px;" for="arriveDate" class="required">Arrival</label>
                    <input readonly type="text" name="arriveDate" placeholder="Arrive" value = "<?= $_SESSION['arrive_Date']; ?>" id="arriveDate" data-date-format="yyyy-mm-dd" autocomplete="off" maxlength="10">
    <!--            This calls the calender functions to create the calenders available on the web page-->
                    <div class="ErrorMessage">
                        <span id="arrive_date_error"> <?= $arrive_date_error?> </span>
                    </div>
                    <div id="arriveCal" class="hide"><?php try {
                            month_info('a_');
                        } catch (Exception $e) {
                        } ?></div>
                </div>
                    <!--<a_ or d_ tells php which calendar is being processed (either arrival or departure calendar)-->
                <div>
                    <label style="padding-left: 1px;" for="departDate" class="required">Departure</label>
                    <input readonly type="text" name="departDate" placeholder="Depart" value = "<?= $_SESSION['depart_Date']; ?>" id="departDate" autocomplete="off" maxlength="10">
    <!--            This calls the calender functions to create the calenders available on the web page-->
                    <div class="ErrorMessage">
                        <span id="depart_date_error"> <?= $depart_date_error?> </span>
                    </div>
                    <div class="ErrorMessage">
                        <span id="booking_error"> <?= $booking_error?> </span>
                    </div>
                    <div id="departCal" class="hide"><?php try {
                            month_info('d_');
                        } catch (Exception $e) {
                        } ?></div>
                </div>


                <div style="padding-bottom: 20px; margin-bottom: 30px;">
                    <p class="num_people">
                        <label style="padding-left: 1px; text-align: left;" for="num_Adults" class="required" >Number Of Adults:</label>

                        <button type="button" id="down_Adults" class="button-left down">-</button>

                        <input readonly type="text" name="num_Adults" id="num_Adults" class="number_input" value="<?=$_SESSION['num_Adults']; ?>">

                        <button type="button" id="up_Adults" class="button-right up">+</button>
                    </p>
                    <div class="ErrorMessage">
                        <span id="num_adult_error"> <?= $num_adult_error?> </span>
                    </div>
                </div>

                <div style="padding-bottom: 20px; margin-bottom: 30px;">
                    <p class="num_people">
                        <label style="padding-left: 1px; text-align: left;" for="num_Children" class="required" >Number Of Children:</label>

                        <button type="button" id="down_children" class="button-left down">-</button>

                        <input readonly type="text" name="num_Children" id="num_Children" class="number_input" value="<?=$_SESSION['num_Children']; ?>">

                        <button type="button" id="up_Children" class="button-right up">+</button>
                    </p>
                    <div class="ErrorMessage">
                        <span id="num_child_error"> <?= $num_child_error?> </span>
                    </div>
                </div>

                <div class="prices">
                    <div id="price_info" class="price_info">
                        <p>Prices:</p>
                        <p style="font-size: 14px">Please note there is an additional service charge of £<?=$service_charge?></p>
                    </div>

                    <div class="price_per_night">
                        <p>Price Per Night:</p>
                        <p id="price_per_night">£</p>
                    </div>

                    <div class="total_price">
                        <p>Total Price:</p>
                        <p id="total_price">£<?=$_SESSION['price'];?></p>
                    </div>

                    <input type="hidden" name="total_price" id="total_price_field" value="<?=$_SESSION['price']; ?>">

                </div>
                <div class="next_step">
                    <button name="booking_form" type="submit" id="next_step" style="width: 100%">Next</button>
                </div>

            </div>
        </form>
    </div>

    <div class="UsersProperty">
        <iframe src="<?= $website ?>"></iframe> <!--Users web page for details of the
         property goes here-->
    </div>

</div>

</body>
</html>
