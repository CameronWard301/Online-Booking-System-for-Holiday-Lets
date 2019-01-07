<?php
include ("config.php");
//phpinfo();
/**
 * Created by PhpStorm.
 * User: Cameron
 * Date: 18/08/2018
 * Time: 18:43
 */

$arrive_date_error = $depart_date_error = $booking_error = $num_adult_error = $num_child_error = $first_name_error = $last_name_error = $email_error = $phone_error = $message_error = $mail_send_error = "";
/*Creates the variables and error variables and sets them as an empty string*/

//Creates the variable names for the users inputs
$arrive_Date = $depart_Date= $arriveDate = $departDate =$first_name = $last_name = $email = $phone = $message = $success = "";
$num_Adults = $min_Adults;
$num_Children = $min_Children;

function test_input($data)
{ /*Cleans up the data for processing*/
    $data = trim($data); /*Removes whitespace from both sides of a string*/
    $data = stripslashes($data); /*Removes backward slashes from the data*/
    $data = str_replace('/', '', $data);  /*removes forward slashes*/
    $data = htmlspecialchars($data); /*Converts predefined characters into HTML entities Eg.
        &becomes &amp. This is to stop harmful injection attacks*/
    return $data; /*Returns the cleaned data*/
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { /*This will only execute if the request method is set to POST which
    it is once the submit button is pressed*/
    echo "server says hello";
    if (isset($_POST['booking_form'])) {
/////////////////////////////////////////////////////FIRST STEP/////////////////////////////////////////////////////////
        try {
            $now = new DateTime();
        } catch (Exception $e) {
        } //sets the current date and time to 0 to compare to the bookings stored in the database
        $now->setTime(00, 00, 00, 00);
        global $bookings;

        function booked_days($servername, $username, $password)
        { //function that creates array full of bookings
            $bookings = array(); //creates the array
            $current_date = date('Y-m-01 00:00:00');//gets the current date and sets it to the first of the month
            $connect = new mysqli($servername, $username, $password); //connects to the database and creates an object
            if ($connect->connect_error) { //checks the connection to the database:
                die("Connection failed: " . $connect->connect_error);
            }
            $sql = "SELECT arrivalDate, departDate FROM holidayletdatabase.bookings WHERE departDate > '$current_date' AND confirmed = 1";
            //SQL to select all the dates where the depart date is greater than the current date
            if ($result = $connect->query($sql)) {//If there is a result from the query:
                while ($obj = $result->fetch_object()) { //fetches a row from the database and turns it into an object
                    array_push($bookings, $obj); //pushes each object with its two attributes arrivalDate and departDate to the array
                }
                $result->close(); //closes the result
            }
            $connect->close(); //closes the connection
            return $bookings; //returns array
        }

        $bookings = booked_days($servername, $username, $password); //calls the bookings function to add to the bookings array


        function test_date($data)
        {
            $data = trim($data); /*Removes whitespace from both sides of a string*/
            $data = stripslashes($data); /*Removes backward slashes from the data*/
            $data = htmlspecialchars($data); /*Converts predefined characters into HTML entities Eg.
        &becomes &amp. This is to stop harmful injection attacks*/
            return $data; /*Returns the cleaned data*/
        }

        function isDate($string)
        {
            $matches = array();
            $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/'; //only allows numbers 0 to 9 and with the format DD/MM/YYYY
            if (!preg_match($pattern, $string, $matches)) return false;
            if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
            return true;
        }

        function max_date($date, $max_month)
        {
            $max_month = $max_month + 1; //sets the max month
            $Max_Date = date("Y-m-d"); ///creates new date object
            $Max_Date = strtotime(date("Y-m-d", strtotime($Max_Date)) . "+" . $max_month . "months"); //creates a date x months into the future
            $Max_Date = date("Y-m-d", $Max_Date); //converts it back into a date from a strotime() number
            try {
                $Max_Date = new DateTime($Max_Date);
            } catch (Exception $e) {
            } //creates new date object from that
            if ($date >= $Max_Date) { //if the date given is greater than the maximum date allowed:
                return true;
            } else {
                return false;
            }
        }

        if (empty($_POST["arriveDate"])) { //gets the arrive date from the form and checks that it is filled in
            $arrive_date_error = "Arrival date is required";
        } else {
            $arriveDate = test_date($_POST["arriveDate"]); //gets the arrive date from the form and removes malicious code
            $arrive_Date = $_POST["arriveDate"]; //saves the value the user enters if they have to change it
            if (!isDate($arriveDate)) { //if not in a valid format then:
                $arrive_date_error = "Please enter a date in the correct format DD/MM/YYYY";
            } else {
                list($d, $m, $y) = explode('/', $arriveDate); //split the date up and remove slashes
                $arriveDate = $y . "-" . $m . "-" . $d; //join date back together with the year at the start
                try {
                    $arriveDate = new DateTime($arriveDate);
                    $_SESSION['arriveDate'] = $arriveDate; //stores this in the session to be stored in database later
                } catch (Exception $e) {
                } //create date time object to compare with other dates
                if ($arriveDate < $now) { //if the arrival date is less than today:
                    $arrive_date_error = "Please don't select a date in the past";
                } else {
                    if ($arriveDate == $now) { //if the arrival date is equal to today:
                        $arrive_date_error = "Please don't select the current date";
                    } else {
                        if (max_date($arriveDate, $max_month)) { //if the date is too far into the future then;
                            $arrive_date_error = "Please don't book too far into the future";
                        } else {
                            $arrive_date_error = "";
                        }
                    }
                }
            }
        }

        if ($arrive_date_error !== "") {
            $depart_date_error = "Please select appropriate arrival date first";
            $depart_Date = $_POST["departDate"];
        } else {
            if (empty($_POST["departDate"])) { //gets the depart date from the form ad checks that is filled in
                $depart_date_error = "Depart date is required";
            } else {
                $departDate = test_date($_POST["departDate"]); //gets the depart date from the form and removes malicious code
                $depart_Date = $_POST["departDate"]; //saves the value the user enters if they have to change it later
                if (!isDate($departDate)) { //if it is not in a valid format then;
                    $depart_date_error = "Please enter a date in the correct format DD/MM/YYYY";
                } else {
                    list($d, $m, $y) = explode('/', $departDate); //splits the date up and removes slashes
                    $departDate = $y . "-" . $m . "-" . $d; //join date back together with the year at the start
                    try {
                        $departDate = new DateTime($departDate);
                        $_SESSION['departDate'] = $departDate; //saves this to the session to be used again later when storing in database
                    } catch (Exception $e) {
                    } //create a date time object from that date
                    if ($departDate < $now) { // if the depart date is less then the current date
                        $depart_date_error = "Please don't select a date in the past";
                    } else {
                        if ($departDate == $now) { //if the depart date is equal to today:
                            $depart_date_error = "Please don't select the current date";
                        }
                        if ($departDate == $arriveDate) {
                            $depart_date_error = "Please choose a depart date after the arrival date";
                        } else {
                            if (max_date($departDate, $max_month)) { //if the date is too far into the future then:
                                $depart_date_error = "Please don't book too far into the future";
                            } else {
                                $number_of_nights = $arriveDate->diff($departDate)->format("%a"); //finds the number of nights betweent the arrive date and the depart date
                                if ($number_of_nights > $max_night_stay) {
                                    $depart_date_error = "You can only stay for a maximum of " . $max_night_stay . " nights";
                                } else {
                                    if ($number_of_nights < $min_night_stay) {
                                        $depart_date_error = "You must stay for at least " . $min_night_stay . " nights";
                                    } else {
                                        $depart_date_error = "";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($_POST["num_Adults"] == "") {
            $num_adult_error = "Please don't leave this field blank";
        } else {
            $num_Adults = test_input($_POST["num_Adults"]);
            if ($num_Adults <= 0) {
                $num_adult_error = "Please select a number greater than 0";
            } else {
                if ($num_Adults < $min_Adults) {
                    $num_adult_error = "You must book a minimum of " . $min_Adults . " adults";
                } else {
                    if ($num_Adults > $max_Adults) {
                        $num_adult_error = "You can only book a maximum of " . $max_Adults . " adults";
                    } else {
                        $num_adult_error = "";
                    }
                }
            }
        }

        if ($_POST["num_Children"] == "") {
            $num_child_error = "Please don't leave this field blank";
        } else {
            $num_Children = test_input($_POST["num_Children"]);
            if ($num_Children < 0) {
                $num_child_error = "Please select a number 0 or greater";
            } else {
                if ($num_Children < $min_Children) {
                    $num_child_error = "You must book a minimum of " . $min_Children . " children";
                } else {
                    if ($num_Children > $max_Children) {
                        $num_child_error = "You can only book a maximum of " . $max_Children . " children";
                    } else {
                        $num_children_error = "";
                    }
                }
            }
        }


        function isBooked($bookings, $arriveDate, $departDate)
        {
            foreach ($bookings as $booking) { //for every item in the bookings array store it in a variable called $booking
                $arrival_Date = new DateTime($booking->arrivalDate); //turn the arrival date into a date format
                $depart_Date = new DateTime($booking->departDate); //turn the depart date into a date format
                $interval = DateInterval::createFromDateString("1 day"); //this will increment dates by 1 day
                $days = new DatePeriod($arriveDate, $interval, $departDate); //creates an object called days with all the days inbetween the arrive and depart date
                foreach ($days as $date) { //for every day between the two dates selected
                    if ($date >= $arrival_Date and $date <= $depart_Date) { //if the date is greater than or equal to the depart date and less than or equal to the arrival date of the bookings then;
                        return true;
                    }
                }
            }
            return false; //else return false
        }

        if ($arrive_date_error == "" and $depart_date_error == "") { //if there are no errors with the arrive or depart fields then:
            if (isBooked($bookings, $arriveDate, $departDate)) { //use function is booked and if it returns true:
                $booking_error = "Please don't select a booked date or span another booking"; //set appropriate error
            } else {
                $booking_error = "";
            }
        }

        function price($number_of_nights, $price_per_night, $price_per_adult, $price_per_child, $service_charge)
        {
            $price = ($number_of_nights * $price_per_night * $price_per_adult * $price_per_child) + $service_charge;
            $_SESSION['price'] = $price; //add the price to the session variable to be storred on the webpage
        }

        $_SESSION['arrive_Date'] = $arrive_Date; //sets the variables to session variables
        $_SESSION['depart_Date'] = $depart_Date;
        $_SESSION['num_Adults'] = $num_Adults;
        $_SESSION['num_Children'] = $num_Children;

        if ($arrive_date_error == "" and $depart_date_error == "" and $booking_error == "" and $num_adult_error == "" and $num_child_error == "") {
            //if there are no errors then:

            price($number_of_nights, $price_per_night, $price_per_adult, $price_per_child, $service_charge); //generate price
            header("Location: User_Details.php"); //redirect to User_Details.php
            exit();//exit php code
        }
        else{
            $_SESSION['price'] = 0; //rest price to 0 as there is an error
        }

    }

    //////////////////////////////////////////////////////LAST STEP/////////////////////////////////////////////////////

    else { //If User_details.php form is submitting then validate that page instead:

        $arriveDate = $_SESSION['arriveDate']; //get the variables from the last session:
        $departDate = $_SESSION['departDate'];
        $num_Adults = $_SESSION['num_Adults'];
        $num_Children = $_SESSION['num_Children'];
        $price = $_SESSION['price'];

        function SQLERROR($sql, $connect){
            echo "Error: " . $sql . "<br>" . $connect->error; //display error if unsuccessful
            $connect->close(); //close the connection
            unset($connect);
        }

        if (empty($_POST["first_name"])) { /*If the field is empty then:*/
            $first_name_error = "First name is required"; /*Set the error message and display it on the web-page*/
        } else {
            $first_name = test_input($_POST["first_name"]); /*Cleans the data using the function above ^^^*/
            if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) { /*If the data entered matches any of the characters
            that are not allowed then:*/
                $first_name_error = "Only letters and white space allowed";
            }
        }

        if (empty($_POST["last_name"])) {
            $last_name_error = "Last name is required";
        } else {
            $last_name = test_input($_POST["last_name"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
                $last_name_error = "Only letters and white space allowed";
            }
        }

        if (empty($_POST["email"])) {
            $email_error = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { /*If the email doesn't pass the email validation then:*/
                $email_error = "Invalid email format";
            }
        }

        if (empty($_POST["phone"])) {
            $phone_error = "Phone is required";
        } else {
            $phone = test_input($_POST["phone"]);
            if (!preg_match('/^\d{10,13}$/', str_replace('-', '', $phone))) { //if phone doesn't pass phone validation then:
                $phone_error = "Invalid phone number";

            }
        }

        if (empty($_POST["message"])) {
            $message = "";
        } else {
            $message = test_input($_POST["message"]);
            if (strlen($message) > $message_character_limit) { //if message is above character limit then:
                $message_error = "Please don't exceed the character limit of: " . $message_character_limit . " characters";
            }
        }

        //if there are no errors then:
        if ($first_name_error == '' and $last_name_error == '' and $email_error == '' and $phone_error == '' and $message_error == '') {
            //store in database:
            $connect = new mysqli($servername, $username, $password); //connects to the database and creates an object
            if ($connect->connect_error) { //checks the connection to the database:
                die("Connection failed: " . $connect->connect_error);
            }
            $aDateF = $arriveDate->format('Y-m-d H:i:s'); //converts the dateTime objects into strings to be used in the SQL statement
            $dDateF = $departDate->format('Y-m-d H:i:s');
            if ($instant_bookings == true){ //if user wants instant booking
                $confirmed = 1; //set confirmed to true
            }
            else{ //else set confirmed to false
                $confirmed = 0;
            }

            //INSERTS INTO the database the booking information
            $sql = "INSERT INTO holidayletdatabase.bookings(arrivalDate, departDate, numAdults, numChildren, price, confirmed) VALUES ('$aDateF', '$dDateF', $num_Adults, $num_Children, $price, $confirmed)";
            if ($connect->query($sql) === TRUE) { //if the Query is successful:
                $last_bookings_id = $connect->insert_id; //get the ID generated from the query

                //INSERTS INTO the database the users information with the booking number recieved from the last query
                $sql = "INSERT INTO holidayletdatabase.customer_info(bookingNumber, firstName, lastName, email, phone, message) VALUES ($last_bookings_id, '$first_name', '$last_name', '$email', '$phone', '$message')";
                if ($connect->query($sql) === TRUE){ //if the query is successful:
                    $last_customer_info_id = $connect->insert_id;  //get the ID generated from the last query

                    //Set the customerID to the ID generated from the last query ^^
                    $sql = "UPDATE holidayletdatabase.bookings SET customerID = $last_customer_info_id WHERE bookingNumber = $last_bookings_id";
                    if ($connect->query($sql) === TRUE){ //if query is sucess full then:



                        $message_body = ''; /*create a variable for the message*/
                        unset($_POST['submit']); /*Unset the global variable $_POST so the code will not run afterwards*/

                        //Create the message body with all the details to send to the owner and user
                        $message_body = $message_body."\nUser's Details:\n";
                        $message_body = $message_body."First Name: ".$first_name."\n";
                        $message_body = $message_body."Last Name: ".$last_name."\n";
                        $message_body = $message_body."Email: ".$email."\n";
                        $message_body = $message_body."Phone: ".$phone."\n";
                        $message_body = $message_body."Message: ".$message."\n";

                        $message_body = $message_body."\nBooking Details:\n";
                        $message_body = $message_body."Booking Number: ".$last_bookings_id."\n";
                        $message_body = $message_body."Customer ID: ".$last_customer_info_id."\n";
                        $message_body = $message_body."Arrive Date: ".$aDateF."\n";
                        $message_body = $message_body."Depart Date: ".$dDateF."\n";
                        $message_body = $message_body."Adults: ".$num_Adults."\n";
                        $message_body = $message_body."Children: ".$num_Children."\n";
                        $message_body = $message_body."Price: £".$price."\n";

                        ////////EMAIL TO OWNER////////
                        $to = $Owner_Email;
                        $headers = 'From: ' . $from . "\r\n" .
                            'Reply-To: ' . $reply_to . "\r\n" .
                            'Return-Path: ' . $return_path;
                        //sends the email with variables set up from previously in config.php
                        if (mail($to, $subject, $message_body, $headers, "-f ".$Owner_Email)) {/* Send the email using the email function if successful then:*/


                        }
                        else {
                            $mail_send_error = "Email Failure! Please contact the owner through the phone number provided: \n" . $Owner_Phone;
                        }



                        ///////EMAIL TO CLIENT////////
                        ///Modifies the message body to send to the client with message set up from earlier in config.php
                        $message_body_client = $message_body_client.$message_body;
                        if (mail($email, $subject, $message_body_client, $headers, "-f ".$Owner_Email)){ //if message send is successfull:
                            $first_name = $last_name = $email = $phone = $message = "";
                            /* Reset the values to clear the booking form*/
                            $connect->close(); //close connection
                            unset($connect);
                            header('Location: confirmed.php');
                        }
                        else{
                            $mail_send_error = "Email Failure! Please contact the owner through the phone number provided: \n" . $Owner_Phone;
                        }

                    }
                    else{
                        SQLERROR($sql, $connect); //show sql error
                    }
                }
                else{
                    SQLERROR($sql, $connect); //show sql error
                }
            }
            else {
                SQLERROR($sql, $connect); //show sql error

            }
            $connect->close(); //close connection to database
            unset($connect);




        }
    }
}
