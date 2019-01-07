<?php
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 24/08/2018
 * Time: 17:44
 */

include ("config.php");
$bookings = bookings($servername, $username, $password); //calls the bookings function to add to the bookings array
$bookingsArray = new stdClass();
$bookingsArray->array = $bookings;
$bookingsArrayJSON = json_encode($bookingsArray);


function bookings($servername, $username, $password){
    $bookings = array(); //creates the array
    $current_date = strtotime(date('Y-m-01 00:00:00'));
    $connect = new mysqli($servername, $username, $password); //connects to the database and creates an object
    if ($connect->connect_error) { //checks the connection to the database:
        die("Connection failed: " . $connect->connect_error);
    }
    $sql = "SELECT arrivalDate, departDate FROM holidayletdatabase.bookings WHERE departDate > '$current_date' AND confirmed = 1"; //SQL to select all the dates where the depart date is greater than the current date
    if ($result = $connect->query($sql)) {//If there is a result from the query:
        while ($obj = $result->fetch_object()) { //fetches a row from the database and turns it into an object
            array_push($bookings, $obj); //pushes each object with its two attributes arrivalDate and departDate to the array
        }
        $result->close(); //closes the result
    }
    mysqli_error($connect);
    $connect->close(); //closes the connection
    return $bookings; //returns array
}

/**
 * @param $calendar_type
 * @throws Exception
 */

function month_info($calendar_type){ /*Sets up the current month to be processed and sent to HTML webpage*/
    global $month, $year, $grid, $availability, $onclick; /*creates the global variables*/
    if ($calendar_type == "a_"){
        $calendar_type = "arrive_";
        $calendar_name = "a_";

    }
    else {
        $calendar_type = "depart_";
        $calendar_name = "d_";
}
    $max_month = $GLOBALS['max_month']; /*Gets the global variable from the config file and uses it locally.*/
    for ($future_month = 0; $future_month < $max_month + 1; $future_month++){ /*keep iterating until future month is equal to max month*/
        $month = $year = $starting_weekday = $total_days_in_month = ''; /*Creates the variables*/
        $month = date('F', strtotime('+'.$future_month.' months', strtotime(date("Y-m-01"))));
        $month_num = date('m', strtotime('+'.$future_month.' months', strtotime(date("Y-m-01"))));
        /*Gets the month name that the program is currently looking at determined by how many months in advance the program is looking at*/

        $year = date('o', strtotime('+'.$future_month.' months', strtotime(date("Y-m-01"))));
        /*Gets the year that the program is currently looking at determined by how many months in advance the program is looking at*/

        $total_days_in_month = date('t', strtotime('+'.$future_month.' months', strtotime(date('Y-m-01'))));
        /*Gets the total days in the month that the program is looking at */

        $calendar_id = $calendar_name.$future_month;

        $grid = array( /*Generates the Calendar array called grid where the dates of the month are stored:*/

            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","","")
        );

        $availability = array(

            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","","")
        );

        $onclick = array(

            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","",""),
            array("","","","","","","")
        );


        $dt = new DateTime('first day of +'.$future_month.' months');
        $starting_weekday = $dt->format('N');
        /*This gets the first weekday of the month, the first of Jan might be a tuesday so it would output 2 for tuesday*/


        $col = $starting_weekday -1 ; /*This sets the starting point for the days to be entered on e.g. Jan could
        start on a tuesday so it would want to be placed in the second column of the calendar*/

        Generate_Calendar($total_days_in_month, $col, $year, $month_num, $calendar_name);
        /*This function adds the correct days to the correct position in the grid*/

        echo display_html_calendar($month, $month_num, $year, $grid, $availability, $onclick, $future_month, $max_month, $calendar_type, $calendar_id);
        /*This function turns the grid into HTML and sends it to the users web page*/
    }


}

function Generate_Calendar($total_days_in_month, $col, $year, $month_num, $calendar_name){ /*adds days to the correct position in calendar*/
    $count = 1; /*The first day of the month is a 1*/
    global $grid, $availability, $onclick; /*Creates the global variable so that the index page can display the given dates*/
    for ($row = 0; $row < 7; $row++) { /*Start ont the first row*/
        for (; $col < 7; $col++) { /*Starting position is the first day of the month (col)*/
            $grid[$row][$col] = $count; /*Sets the position in the array to the date of the month e.g. 7th of Jan*/
            $availability[$row][$col] = get_availability($year, $month_num, $count); //adds "available" or "booked" to the array
            if ($availability[$row][$col] == "available"){
                $onclick[$row][$col] = "data-year=".$year." data-month_num=".$month_num." data-day=".$grid[$row][$col]." data-calendar_name=".'"'.$calendar_name.'"';
            }
            if ($count == $total_days_in_month) { /*If the days added == to the number of days in the month*/
                return; /*Stop adding days to the calendar */
            }
            $count = $count + 1; /*Else increment the count / day number by 1*/

        }
        $col = 0;/* Once the second for loop has finished reset the col counter back to 0 to start
        in the first position of the new row*/
    }
}


function get_availability($year, $month_num, $count){ //Determines if the date it is looking at is booked or not
    global $bookings;
    $current_date = $year.'-'.$month_num.'-'.$count.' 00:00:00'; //creates the current date as a string
    $calendar_date = strtotime($current_date); //turns the string into a date
    foreach ($bookings as $booking){ //for every item in the bookings array store it in a variable called $booking
        $arrivalDate = strtotime($booking->arrivalDate); //turn the arrival date into a date format
        $departDate = strtotime($booking->departDate); //turn the depart date into a date format
        if ($calendar_date >= $arrivalDate and $calendar_date <= $departDate){
            //if the calendar date is greater or equal to the arrival date and is less than or equal to the depart date then:
            return "booked";
        }
    }
    return "available";

}

function display_html_calendar($month, $month_num, $year, $grid, $availability, $onclick, $future_month, $max_month, $calendar_type, $calendar_id) { /*Sends the grid in HTML to the main page to be displayed*/
    if ($future_month == 0){ /*If the month shown is the first month:*/
        $current_calendar = 'show'; /*Change the class to show*/
        $back_calendar = ''; /*Remove the onclick attribute to stop the user going back in months*/
        $back_button = 'color: #666666; cursor: default;'; /*Greys out the arrow and changes the cursor to default*/
        $fwrd_button = 'cursor: pointer;'; /*Changes the cursor to pointer when hovered over the forward arrow*/
        $fwrd_calendar = $calendar_type.'fwrd()'; /*Change the onclick function to fwrd to allow the user to look at future months*/
    }
    else{
        $current_calendar = 'hide'; /*Hide the other calendars*/
        $back_calendar = $calendar_type.'back()'; /*Change the back arrow to have a onclick back function to allow the user to skip back months*/
        $back_button = 'cursor: pointer;'; /*Changes the cursor to pointer when hovered over the backward arrow*/
        $fwrd_calendar = $calendar_type.'fwrd()'; /*Change the forward arrow to have a onclick back function to allow the user to skip back months*/
        $fwrd_button = 'cursor: pointer;';/*Changes the cursor to pointer when hovered over the forward arrow*/
    }

    if ($future_month == $max_month){ /*If the last calendar is displayed:*/
        $fwrd_calendar = '';  /*Remove the onclick feature to look at future months*/
        $fwrd_button = 'color: #666666; cursor: default;'; /*Grey out the forward button and change the cursor back to default.*/
    }

return <<<HTML
        <html lang="en-GB">
        <div class="{$current_calendar}" id='{$calendar_id}' data-value='{$future_month}' >
        <!--Current_calendar is either show or hide, future_month the number of the month in the future relative to current month -->         
                <div class='month_header'>
                    <ul>
                    <!--Back/forward button is where the color and cursor style is applied
                    back/forward_calendar is where the onclick function is placed if ok to do so.-->
                        <li class='previous_month' style='{$back_button}' onclick='{$back_calendar}'>&#10094;</li>
                        <li class='next_month' style= '{$fwrd_button}' onclick='{$fwrd_calendar}'>&#10095;</li>
                        <li id="{$month_num}">{$month}<br><span id="{$year}" class='year'>{$year}</span>
                        <!--year and month is the current year and month that the program is looking at.-->
                        </li>
                    </ul>
                </div>
                <div class="month_body">

                            
                       <table class="weekdays">
                            <tr>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                                <th>Sun</th>
                            </tr>
                            
                           
                    </table>    
            
            
                        <table class="days"> <!--Below is the grid array for the days in the month to go-->
                                   
                        
                            <tr>
                                <td class="{$availability[0][0]}" {$onclick[0][0]}>{$grid[0][0]}</td> <!--//The onclick function will-->
                                <td class="{$availability[0][1]}" {$onclick[0][1]}>{$grid[0][1]}</td> <!--//be used to ask the JS to input-->
                                <td class="{$availability[0][2]}" {$onclick[0][2]}>{$grid[0][2]}</td> <!--//this into the form field above it-->
                                <td class="{$availability[0][3]}" {$onclick[0][3]}>{$grid[0][3]}</td>
                                <td class="{$availability[0][4]}" {$onclick[0][4]}>{$grid[0][4]}</td>
                                <td class="{$availability[0][5]}" {$onclick[0][5]}>{$grid[0][5]}</td>
                                <td class="{$availability[0][6]}" {$onclick[0][6]}>{$grid[0][6]}</td>
                            </tr>
           
                            <tr>
                                <td class="{$availability[1][0]}" {$onclick[1][0]}>{$grid[1][0]}</td>
                                <td class="{$availability[1][1]}" {$onclick[1][1]}>{$grid[1][1]}</td>
                                <td class="{$availability[1][2]}" {$onclick[1][2]}>{$grid[1][2]}</td>
                                <td class="{$availability[1][3]}" {$onclick[1][3]}>{$grid[1][3]}</td>
                                <td class="{$availability[1][4]}" {$onclick[1][4]}>{$grid[1][4]}</td>
                                <td class="{$availability[1][5]}" {$onclick[1][5]}>{$grid[1][5]}</td>
                                <td class="{$availability[1][6]}" {$onclick[1][6]}>{$grid[1][6]}</td>
                            </tr>
                
                            <tr>
                                <td class="{$availability[2][0]}" {$onclick[2][0]}>{$grid[2][0]}</td>
                                <td class="{$availability[2][1]}" {$onclick[2][1]}>{$grid[2][1]}</td>
                                <td class="{$availability[2][2]}" {$onclick[2][2]}>{$grid[2][2]}</td>
                                <td class="{$availability[2][3]}" {$onclick[2][3]}>{$grid[2][3]}</td>
                                <td class="{$availability[2][4]}" {$onclick[2][4]}>{$grid[2][4]}</td>
                                <td class="{$availability[2][5]}" {$onclick[2][5]}>{$grid[2][5]}</td>
                                <td class="{$availability[2][6]}" {$onclick[2][6]}>{$grid[2][6]}</td>
                            </tr>
                
                            <tr>
                                <td class="{$availability[3][0]}" {$onclick[3][0]}>{$grid[3][0]}</td>
                                <td class="{$availability[3][1]}" {$onclick[3][1]}>{$grid[3][1]}</td>
                                <td class="{$availability[3][2]}" {$onclick[3][2]}>{$grid[3][2]}</td>
                                <td class="{$availability[3][3]}" {$onclick[3][3]}>{$grid[3][3]}</td>
                                <td class="{$availability[3][4]}" {$onclick[3][4]}>{$grid[3][4]}</td>
                                <td class="{$availability[3][5]}" {$onclick[3][5]}>{$grid[3][5]}</td>
                                <td class="{$availability[3][6]}" {$onclick[3][6]}>{$grid[3][6]}</td>
                            </tr>
                
                            <tr>                
                                <td class="{$availability[4][0]}" {$onclick[4][0]}>{$grid[4][0]}</td>
                                <td class="{$availability[4][1]}" {$onclick[4][1]}>{$grid[4][1]}</td>
                                <td class="{$availability[4][2]}" {$onclick[4][2]}>{$grid[4][2]}</td>
                                <td class="{$availability[4][3]}" {$onclick[4][3]}>{$grid[4][3]}</td>
                                <td class="{$availability[4][4]}" {$onclick[4][4]}>{$grid[4][4]}</td>
                                <td class="{$availability[4][5]}" {$onclick[4][5]}>{$grid[4][5]}</td>
                                <td class="{$availability[4][6]}" {$onclick[4][6]}>{$grid[4][6]}</td>
                            </tr>    
                                
                            <tr> 
                                <td class="{$availability[5][0]}" {$onclick[5][0]}>{$grid[5][0]}</td>
                                <td class="{$availability[5][1]}" {$onclick[5][1]}>{$grid[5][1]}</td>
                                <td class="{$availability[5][2]}" {$onclick[5][2]}>{$grid[5][2]}</td>
                                <td class="{$availability[5][3]}" {$onclick[5][3]}>{$grid[5][3]}</td>
                                <td class="{$availability[5][4]}" {$onclick[5][4]}>{$grid[5][4]}</td>
                                <td class="{$availability[5][5]}" {$onclick[5][5]}>{$grid[5][5]}</td>
                                <td class="{$availability[5][6]}" {$onclick[5][6]}>{$grid[5][6]}</td>
                            </tr>
                        </table>
                        
                       </div>
                   
                    </div>
                
            </html>
HTML;
}





/*
d - The day of the month (from 01 to 31)
D - A textual representation of a day (three letters)
j - The day of the month without leading zeros (1 to 31)
l (lowercase 'L') - A full textual representation of a day
N - The ISO-8601 numeric representation of a day (1 for Monday, 7 for Sunday)
    S - The English ordinal suffix for the day of the month (2 characters st, nd, rd or th. Works well with j)
w - A numeric representation of the day (0 for Sunday, 6 for Saturday)
    z - The day of the year (from 0 through 365)
W - The ISO-8601 week number of year (weeks starting on Monday)
F - A full textual representation of a month (January through December)
m - A numeric representation of a month (from 01 to 12)
M - A short textual representation of a month (three letters)
n - A numeric representation of a month, without leading zeros (1 to 12)
t - The number of days in the given month
L - Whether it's a leap year (1 if it is a leap year, 0 otherwise)
o - The ISO-8601 year number
Y - A four digit representation of a year
y - A two digit representation of a year
a - Lowercase am or pm
A - Uppercase AM or PM
B - Swatch Internet time (000 to 999)
g - 12-hour format of an hour (1 to 12)
G - 24-hour format of an hour (0 to 23)
h - 12-hour format of an hour (01 to 12)
H - 24-hour format of an hour (00 to 23)
i - Minutes with leading zeros (00 to 59)
s - Seconds, with leading zeros (00 to 59)
u - Microseconds (added in PHP 5.2.2)
e - The timezone identifier (Examples: UTC, GMT, Atlantic/Azores)
I (capital i) - Whether the date is in daylights savings time (1 if Daylight Savings Time, 0 otherwise)
O - Difference to Greenwich time (GMT) in hours (Example: +0100)
P - Difference to Greenwich time (GMT) in hours:minutes (added in PHP 5.1.3)
T - Timezone abbreviations (Examples: EST, MDT)
Z - Timezone offset in seconds. The offset for timezones west of UTC is negative (-43200 to 50400)
c - The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)
r - The RFC 2822 formatted date (e.g. Fri, 12 Apr 2013 12:01:05 +0200)
U - The seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
*/


