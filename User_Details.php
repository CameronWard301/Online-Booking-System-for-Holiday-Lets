<?php session_start();

include ("config.php");
include('User_Validation_Booking.php');/* Loads the code from the external php doc*/
/**
 * Created by PhpStorm.
 * User: camer
 * Date: 30/12/2018
 * Time: 20:03
 */
if (!isset($_SESSION['arrive_Date'])){
    $_SESSION['arrive_Date'] = ""; //sets the variables to session variables
    $_SESSION['depart_Date'] = "";
    $_SESSION['num_Adults'] = $min_Adults;
    $_SESSION['num_Children'] = $min_Children;
    $_SESSION['price'] = "";
}

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
    <title>Users Details</title> <!--Sets the page title which appears in browser tab-->
</head>
<body>

<input type="hidden" id="config" value='<?=$configJSON?>'>

<div class="BookingFormUserInfo tab">

    <div>
        <div class="prev_step">
            <button type="button" id="prev_step">Back</button>
        </div>


        <div class="summary">
            <h1>Your Summary:</h1>
            <h2>Arrive: <?php echo $_SESSION['arrive_Date']?></h2>
            <h2>Depart: <?php echo $_SESSION['depart_Date']?></h2>
            <h2>Adults: <?php echo $_SESSION['num_Adults']?></h2>
            <h2>Children: <?php echo $_SESSION['num_Children']?></h2>
            <h2>Total Price: £<?php echo $_SESSION['price']?></h2>
            <h3>You're almost there! Fill in the details below to complete your booking:</h3>
        </div>

        <form action= "<?= $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off" id="booking_form">
            <div>
                <label for="fname" class="required">First Name</label> <!--Creates the label "First Name"-->
                <input type="text" name="first_name" placeholder="Your name:" id="firstName" value="<?= $first_name ?>" >
                <div class="ErrorMessage">
                    <span id="first_name_error"> <?= $first_name_error?> </span> <!--The error message box that will appear
                                                                     if the user enters incorrect information-->
                </div>
            </div>

            <div>
                <label for="lname" class="required">Last Name</label> <!--For= is used to give the label an id-->
                <input type="text" name="last_name" placeholder="Your last name:" id="lastName" value="<?= $last_name ?>" >
                <div class="ErrorMessage">
                    <span id="last_name_error"> <?= $last_name_error?> </span>
                </div>
            </div>

            <div>
                <label for ="email" class="required">Email</label>
                <input type="text" name="email" placeholder="Your email:" id="email" value="<?= $email ?>" ><!--type is used
                                                                                                to specify the input type-->
                <div class="ErrorMessage">
                    <span id="email_error"> <?= $email_error ?> </span>
                </div>
            </div>

            <div>
                <label for="phone" class="required">Phone</label>
                <input type="text" name="phone" placeholder="Phone number:" id="phone" value="<?= $phone ?>" >
                <!--Value is used to save the users information to save them having to enter it all over again if they get
                some information wrong-->
                <div class="ErrorMessage">
                    <span id="phone_error"> <?= $phone_error ?> </span> <!--Id is used to give the input an id-->
                </div>
            </div>

            <div>
                <label for="message">Message</label>
                <textarea type="text" name="message" id="message" placeholder="Send a message to the property owner (Optional):"><?= $message ?></textarea>
                <div class="ErrorMessage">
                    <span id="message_error"> <?= $message_error ?> </span>
                </div>
            </div>

            <div>
                <label>Confirm</label>
                <input name="users_details" id="submit" type="submit" value="Submit"> <!--submit button processes the request-->
                <span class="ErrorMessage" id="mailSendError"><?= $mail_send_error ?></span>
            </div>

            <div>
                <?= $success; ?>
            </div>
        </form>
    </div>
</div>
</body>
</html>