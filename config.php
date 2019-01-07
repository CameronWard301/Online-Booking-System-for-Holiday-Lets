<?php
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 03/12/2018
 * Time: 18:53
 */


$website = 'https://www.tredingtonmill.co.uk/pool-view.aspx'; //Enter the URL of the website you would like to appear next to the booking form

$price_per_night = 30; //enter whole numbers for the price per night
$price_per_adult = 1;  //leave at 1 if you don't want to charge per person
$price_per_child = 1;
$service_charge = 50; //enter service charge number as a whole number, leave 0 if you don't want to add a service charge
$max_night_stay = 6; //enter a whole number for the minimum and maximum night stay
$min_night_stay = 2;
$max_month = 12; // enter a whole number for the maximum amount of months that you would like the user to be able to book
$max_Adults = 10; //enter the maximum number of adults that you would like to stay
$min_Adults = 1; //enter the minimum number of adults you would like to stay
$max_Children = 5; //enter the maximum number of children that you would like to stay
$min_Children = 0; //enter the minimum number of children you would like to stay
$message_character_limit = 1000; //set the maximum number of characters to be allowed in the message field PLEASE READ NOTE BELOW
//****the database is only set to 1000 so if you change this here make sure to also change it in the database*****///

$Owner_Phone = '01234 567890'; //Enter your phone number here so customers can contact you
$Owner_Email = 'owner@gmail.com'; //Enter the email you would like booking requests to go to
$subject = 'NAME GOES HERE Booking Confirmation'; //Enter a subject name for the client to see on their email
$message_body_client = "We have received your request and will be in touch soon to confirm your stay. Here are your details: \n"; //Enter the message to be sent to the customer //Their details will be added later e.g. when they arrive and depart etc
$from = 'webmaster@example.com'; //Enter the email address of the web server that will send the email
$reply_to = 'webmaster@example.com'; //Enter the email address of the web server that will send the email
$return_path = 'webmaster@example.com'; //Enter the email address of the web server that will send the email

$servername = "localhost"; //Enter server name of database
$username = "Cameron"; //Enter user name of database
$password = "&yjv1G8wjiz^"; //Enter password of database
$instant_bookings = true; //set to 'false' if you wouldn't like instant bookings

///ENTER CSS COLOURS BELOW TO CHANGE THE COLORS OF THE FORM AND TEXT TO SUIT YOUR WEBSITE DISPLAYED NEXT TO THE FORM
/////////////////////////////////////////////////CSS COLOURS///////////////////////////////////////////////////////////

$background_color = '#f2f2f2'; //background color of webpage
$form_background = '#f2f2f2'; //background color of form
$days_background = '#eee'; //background color of days
$input_field_border = '#ccc'; //input field border color

$price_text = 'white'; //text color of price
$summary_text = 'white'; //text colour of summary text
$month_header_text = 'white'; //header text color
$price_info_text = 'black'; //price information text (where the not about the service charge is)
$text_color = '#000000'; //text color

$primary_color = '#1d86c8'; //Primary color (default is blue)
$primary_color_lighter = '#8fcaef'; //Lighter shade of the primary colour
$button_hover = '#00A8D9'; //Lighter shade of primary colour for button hover
$button_text = 'white'; //button text colour

$error_message = '#f44336'; //error message color
$required = '#f44336'; //required star color

$booked_day_background_color = '#d6485b'; //booked background color
$booked_text = '#eeeeee'; //booked text color

$weekday_text = '#666'; //weekday text color
$days_text = '#777'; //days text color
$selected_day = '#5d5a5a'; //selected day border color


////////////////////////////////////NO NEED TO CHANGE ANYTHING ELSE BELOW HERE/////////////////////////////////////////

$config = new StdClass(); //creates an object that stores the variables below as attributes:
$config->website = $website;
$config->price_per_night = $price_per_night;
$config->price_per_adult = $price_per_adult;
$config->price_per_child = $price_per_child;
$config->service_charge = $service_charge;
$config->max_night_stay = $max_night_stay;
$config->min_night_stay = $min_night_stay;
$config->max_month = $max_month;
$config->max_Adults = $max_Adults;
$config->min_Adults = $min_Adults;
$config->max_Children = $max_Children;
$config->min_Children = $min_Children;
$config->Owner_Phone = $Owner_Phone;
$config->Owner_Email = $Owner_Email;
$config->maxMessage = $message_character_limit;



$configJSON = json_encode($config);
$GLOBALS['max_month'] = $config->max_month;
