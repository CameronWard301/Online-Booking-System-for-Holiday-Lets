<?php
/**
 * Created by PhpStorm.
 * User: Cameron
 * Date: 07/01/2019
 * Time: 10:57
 */
include ('config.php');

header("Content-type: text/css; charset: UTF-8");

?>

:root{

--background-color: <?= $background_color ?>;
--form-background: <?= $form_background ?>;
--days-background: <?= $days_background ?>;
--input-field-border: <?= $input_field_border ?>;

--price-text: <?= $price_text ?>;
--summary-text: <?= $summary_text ?>;
--month-header-text: <?= $month_header_text ?>;
--price-info-text: <?= $price_info_text ?>;
--text-color: <?= $text_color ?>;

--primary-color: <?= $primary_color ?>;
--primary-color-lighter: <?= $primary_color_lighter ?>;
--button-hover: <?= $button_hover ?>;
--button-text: <?= $button_text ?>;

--error-message: <?= $error_message ?>;
--required: <?= $required ?>;

--booked-day-background-color: <?= $booked_day_background_color ?>;
--booked-text: <?= $booked_text ?>;

--weekday-text: <?= $weekday_text ?>;
--days-text: <?= $days_text ?>;
--selected-day: <?= $selected_day ?>;

}

p{color: var(--text-color);}

html{
font-family: Archivo Narrow, "sans-serif";
background-color: var(--background-color);

}

html, body{
height: 100%;
margin: 0;
}

p{
text-align: center;
width: 100%;
margin: auto;
}


.wrapper{
width: 100%; /*Specifies the size of the page*/
height: 100%;
flex-direction: row; /*Specifies the direction items should flow*/

}

.UsersProperty {
flex-grow: 1; /*Specifies how much the item will grow */

}

.booking_form{
max-width: 400px;
margin: 0 auto;
}

.button-left{ /*creates it inline with the input field*/
float: left;
width: 20%;
height: 40px;
margin-top: 6px;
border-radius: 12px;
touch-action: manipulation;
}

.button-right{ /*creates it inline with the input field*/
float: right;
width: 20%;
height: 40px;
margin-top: 6px;
border-radius: 12px;
touch-action: manipulation;
}

.number_input{ /*This reduces the size of the input field and creates it inline with the buttons.*/
margin: 0;
float: left;
}

.prices{
width: 100%;
display: inline-block;
text-align: center;
}

.prices p{
color: var(--price-text);
}

.price_info{
padding-bottom: 10px;
}

#price_info p{
color: var(--price-info-text);
text-align: left;
}
.total_price{
font-size: 19px;
padding: 30px 10px 30px 10px;
float: right;
width: 40%;
height: auto;
background-color: var(--primary-color);
border-radius: 15px;
}

.price_per_night{
font-size: 19px;
padding: 30px 10px 30px 10px;
float: left;
width: 40%;
height: auto;
background-color: var(--primary-color);
border-radius: 15px;
}

.next_step{
text-align: center;
padding-top: 20px;
}
.next_step button{
font-size: 30px;
border-radius: 20px;
background-color: var(--primary-color);
touch-action: manipulation;
}
.prev_step button{
width: 100%;
border-radius: 10px;
}

#num_Adults, #num_Children{ /*creates a smaller input field in the centre of the page*/
width: 20%;
text-align: center;
position: relative;
left: 20%;
}


/******************************************AVAILABILITY CALENDER*******************************************************/


.AvailabilityCalender{
min-width: 283px;
border-radius: 5px;
background-color: var(--form-background);
padding: 20px;


}

.booked{
background-color: var(--booked-day-background-color);
color: var(--booked-text) !important;
cursor: default;

}
.available{
background-color: inherit;
cursor: pointer;
}

.show{
display: inherit;
}

.hide{
display: none;
}

ul{/* Removes the bullet points form the list*/
list-style-type: none;

}

.month_header{ /*This is the month header that shows the month and the year*/
width: 100%;
margin: 0;
float: left;
text-align: center;
background: var(--primary-color);
padding-top: 20px;
padding-bottom: 20px;
}

.month_header ul{
margin: 0;
padding: 0;
}

.month_header ul li{
color: var(--month-header-text);
font-size: 20px;
text-transform: uppercase;
letter-spacing: 3px;
}

.month_header .previous_month{
float: left;
padding-top: 10px;
padding-left: 10px;
text-decoration: none;
}

.month_header .next_month{
float: right;
padding-top: 10px;
padding-right: 10px;
}

.month_body{
width: 100%;
float: left;
}

.weekdays{
width: 100%;
margin: 0;
padding: 10px 0;
background-color: var(--primary-color-lighter);
}

.weekdays th{
display: inline-block;
width: 13.2%;
color: var(--weekday-text);
text-align: center;
}

.days{
width: 100%;
text-align: center;
padding: 10px 0;
background: var(--days-background);
margin: 0;
}

.days td{
display: inline-block;
width: 13.2%;
text-align: center;
margin-bottom: 5px;
margin-left: 1px;
margin-right: 1px;
padding: 0;
font-size: 12px;
color: var(--days-text);
}

.select{
outline: 1px solid var(--selected-day);
}


/************************************************USERS INFO************************************************************/

.summary h1{
font-size: 30px;
font-weight: 100;
}

.summary h2{
font-size: 20px;
font-weight: 100;
}

.summary h3{
font-size: 15px;
font-weight: 100;
}

.summary{
background-color: var(--primary-color);
border-radius: 10px;
padding: 5px;
color: var(--summary-text);
font-weight: normal;

}

/* Add a background color and some padding around the form */
.BookingFormUserInfo {
min-width: 283px;
max-width: 400px;
width: 50%;
margin: 0 auto;
border-radius: 5px;
background-color: var(--background-color);
padding: 20px;
}

#num_adult_error, #num_child_error{
display: inline-block;
padding-bottom: 0;
}

/* The error message box */
.ErrorMessage {
color: var(--error-message);
margin-bottom: 20px;
}


.required:after{
color: var(--required);
content: " *";
}

iframe{ /*Creates the iFrame with the right sizing for the screen*/
height: 500px;
width: 100%;
border: none;
overflow: hidden;
}


input[type=text], [type=number] { /*only styles the input this way of type is = text or number*/
width: 100%; /* Full width */
padding: 12px; /* Some padding */
border: 1px solid var(--input-field-border); /* Gray border */
border-radius: 4px; /* Rounded borders */
box-sizing: border-box; /* Make sure that padding and width stays in place */
margin-top: 6px; /* Add a top margin */
margin-bottom: 16px; /* Bottom margin */
}

button{
background-color: var(--primary-color);
color: var(--button-text);
padding: 12px 20px;
border: none;
border-radius: 4px;
cursor: pointer; /*Changes the cursor to a pointer when hovering over the button*/
margin-top: 6px; /* Add a top margin */
margin-bottom: 16px; /* Bottom margin */
-webkit-appearance: none; /*Prevents IOS from styling the button a different way*/
-moz-appearance: none; /*^^^*/
touch-action: manipulation;
}

button:hover{
background-color: var(--button-hover);
}

/* Style the input fields with a specific background colour */
input[type=submit]{
background-color: var(--primary-color);
color: var(--button-text);
padding: 12px 20px;
border: none;
border-radius: 4px;
cursor: pointer; /*Changes the cursor to a pointer when hovering over the button*/
margin-top: 6px; /* Add a top margin */
margin-bottom: 16px; /* Bottom margin */
-webkit-appearance: none; /*Prevents IOS from styling the button a different way*/
-moz-appearance: none; /*^^^*/

}

/* When moving the mouse over the submit button, add a darker blue color */
input[type=submit]:hover {
background-color: var(--button-hover);
}

label, input{ /*All labels and inputs will:*/
display: block; /*adds some spacing between elements*/
width: 100%; /* Full width */
padding-top: 12px;
padding-bottom: 2px;
}

textarea{
width: 100%;
height: 150px;
padding: 12px;
font-size: 14px;
border: 1px solid var(--input-field-border);
box-sizing: border-box;
border-radius: 4px;
resize: vertical;
font-family: Archivo Narrow, "sans-serif";

}


/*********************************************************************************/


@media (min-width:641px){ /*Tablets in portrait and landscape*/

.AvailabilityCalender{
max-width: 283px;
}

.booking_form{
min-width: 400px;
width: 50%;
}

}

/*********************************************************************************/

@media (min-width:1025px) { /* big landscape tablets, laptops, and desktops */


.wrapper{
display: flex; /*Displays the users web-page with the booking form to the right*/
/*overflow: hidden; !*Removes the scroll bar from the right hand side of the page*!*/
}

.AvailabilityCalender{
max-width: 283px; /*creates the right spacing*/
}

.booking_form{
min-width: 400px; /*creates the right spacing*/
width: 50%;
}

.UsersProperty{
flex-grow: 1; /*Specifies how much the item will grow */
}

iframe{
height: 100%;
}
}

@media screen and (-webkit-min-device-pixel-ratio:0) { /*Prevents IOS devices from zooming into the webpage unnecessarily*/
select,
textarea,
input {
font-size: 16px;
}
}