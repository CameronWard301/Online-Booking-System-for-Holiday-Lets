$(document).ready(function () { //when the document has loaded:

    let $configElement = $("#config"); //gets the hidden input field
    let $bookingArrayElement = $("#bookingsArray");
    let $available = $(".available");
    let $departDate = $("#departDate");
    let $arriveDate = $("#arriveDate");
    let config = JSON.parse($configElement.val()); //parses the value in the config element
    let $bookings = JSON.parse($bookingArrayElement.val());
    console.log($bookings);
    let arriveBooked = false;
    let departBooked = false;
    config.max_month = config.max_month + 1; //maximum number of months the user can book in the future
    $("#price_per_night").html("£"+config.price_per_night);


    /** @namespace config.price_per_night*/
    /** @namespace config.price_per_adult */
    /** @namespace config.price_per_child */
    /** @namespace config.service_charge*/
    /** @namespace config.max_night_stay*/
    /** @namespace config.min_night_stay*/
    /** @namespace config.max_month*/
    /** @namespace config.max_Adults*/
    /** @namespace config.min_Adults*/
    /** @namespace config.max_Children*/
    /** @namespace config.min_Children*/


        console.log(config.min_night_stay);
    $($arriveDate).click(function () { //If the arriveDate text box is clicked then:
        $("#departCal").slideUp ("slow"); //Hide departure calendar (if not already hidden)
        $("#arriveCal").slideToggle("slow"); //Show arrival calendar
    });

    $($departDate).click(function () { //if the departDate text box is clicked then:
        $("#arriveCal").slideUp("slow"); //Hide arrival calendar (if not already hidden)
        $("#departCal").slideToggle ("slow"); //Show departure calendar
    });

    $available.hover(
        function () {
        $(this).css("background-color", "#d2cfcf", "border", "solid")
        },
        function () {
        $(this).css("background-color", "#eee", "border", "none")
        }
    );

    $available.click(function(){
        $(".available.select").removeClass("select");
        $(this).addClass("select");
    });


    /*$("#arriveCal .days .available").click(function () { //if an available date is clicked in the arrive calendar:
        arriveBooked = false;
        console.log(arriveBooked);
    });

    $("#arriveCal .days .booked").click(function () { //if an unavailable date is clicked in the arrival calendar:
        arriveBooked = true;
        console.log(arriveBooked);
    });

    $("#departCal .days .available").click(function (){ //if an available date is clicked in the depart calendar:
        departBooked = false;
    });

    $("#departCal .days .booked").click(function (){ //if an unavailable date is clicked in the depart calendar:
        departBooked = true;
    });*/


    function pad(n) {// Pads 0s to single digit numbers
        return (n < 10) ? ("0" + n) : n;
    }

    $(".days .available").on("click", function (){ //when an available day is clicked:
        let year = $(this).data("year"); //assign year to the data-value labeled year etc.....
        let month = $(this).data("month_num");
        let day = $(this).data("day");
        let cal = $(this).data("calendar_name");
        if (day === ''){

        }
        else {
            let Id = "";
            year = year.toString();
            month = month.toString();
            day = pad(day).toString();
            let text = day + '/' + month + '/' + year;
            if (cal === "a_"){
                Id = "arriveDate";
            }
            else {
                Id = "departDate";

            }
            document.getElementById(Id).value = text;
            generatePrice()
        }


    });

    /*$($arriveDate).on('input', function (){
        generatePrice();
        alert("input changed")
    });

    $($departDate).on('input', function (){
        generatePrice();
    });*/




    //Pricing//
    function generatePrice() {
        //nights gets the number of nights between the dates
        let nights = moment(new Date(moment($("#departDate").val(), 'DD/MM/YYYY').format('YYYY/MM/DD'))).diff(moment(new Date(moment($("#arriveDate").val(), 'DD/MM/YYYY').format('YYYY/MM/DD'))), 'days');
        if (nights > 0 ){ //if nights is greater than 0 and a reasonable number then add the price to the page:
            let price = (nights*config.price_per_night*config.price_per_adult*config.price_per_child) + config.service_charge;
            $("#total_price").html("£" + price); //config.price_per_night is the price set in the config document
            $("#total_price_field").html(nights*config.price_per_night);
        }

    }

///////////////////////////////////////CLIENT SIDE VALIDATION//////////////////////////////////////////////////////////
    $("#next_step").click (function(event) { //when the next button is clicked:

        let arriveDateElement = $("#arriveDate").val(); //gets the value from the arriveDate input field
        let departDateElement = $("#departDate").val(); //gets the value from the departDate input field
        let numAdults = parseInt($("#num_Adults").val()); //gets the value from the num_adults field
        let numChild = parseInt($("#num_Children").val()); //gets the value from the num_children field
        let arrive_date = moment(arriveDateElement, 'DD/MM/YYYY').format('YYYY/MM/DD'); //converts the users, input into YYYY/MM/DD from DD/MM/YYYY
        let depart_date = moment(departDateElement, 'DD/MM/YYYY').format('YYYY/MM/DD'); //converts the users, input into YYYY/MM/DD from DD/MM/YYYY
        let a_date = moment(new Date(arrive_date)); //creates the date object
        let d_date = moment(new Date(depart_date)); //creates the date object
        let nights = d_date.diff(a_date, 'days');
        let max_month_date = moment().add(config.max_month, 'M').startOf('month'); //sets the maximum month x months into the future and sets the date to be the first of the month
        let $arriveDateError = $("#arrive_date_error");
        let $departDateError = $("#depart_date_error");
        /*let $bookingError = $("#booking_error");*/
        let $numAdultError = $("#num_adult_error");
        let $numChildError = $("#num_child_error");


        if (arriveDateElement === ""){ //if field empty
            $arriveDateError.html("Please don't leave this field blank");
        }
        else if (moment(a_date).isValid() === false){
            $arriveDateError.html("Please enter a valid date in the format DD/MM/YYYY");
        }
        else if (moment().isAfter(a_date, 'day')){ //if the date selected is less than the current date:
            $arriveDateError.html("Please don't select a date in the past")
        }
        else if (moment().isSame(a_date, 'day')){
            $arriveDateError.html("You can't select the current date")
        }
        else if (a_date >= max_month_date){ //if the arrive date is greater than the maximum month
            $arriveDateError.html("Please don't select a date too far in the future")
        }
        else if (arriveBooked){
            $arriveDateError.html("Please don't select a booked date")
        }
        else { //else leave the error message blank
            $arriveDateError.html("");
        }

        if ($arriveDateError.html() !== ""){
            $departDateError.html("Please select appropriate arrival date first");
        }
        else if (departDateElement === ""){ //if field is empty
            $departDateError.html("Please don't leave this field blank");
        }
        else if (moment(d_date).isValid() === false){
            $departDateError.html("Please enter a valid date in the format DD/MM/YYYY");
        }
        else if (d_date <= a_date){ //if depart date is equal to or less than the arrival date
            $departDateError.html("Please select a departure date that is after the arrival date")
        }
        else if (d_date > max_month_date){ //if depart date is greater than the maximum month
            $departDateError.html("Please don't select a date too far in the future")
        }
        else if (nights > config.max_night_stay){
            $departDateError.html("You can only stay for a maximum of " + config.max_night_stay + " nights")
        }
        else if (nights < config.min_night_stay){
            $departDateError.html("You must stay for at least " + config.min_night_stay + " nights")
        }
        else if (departBooked){
            $departDateError.html("Please don't pick a booked date")
        }
        else {//else leave the error message blank
            $departDateError.html("");
        }


        if (numAdults === 0 || isNaN(numAdults) === true){ //if left blank:
            $numAdultError.html("Please don't leave this field blank");
        }
        else if (numAdults <= 0){ //if the number of adults selected is less than 0
            $numAdultError.html("Please don't select a number less than 0");
        }
        else if (numAdults < config.min_Adults){
            $numAdultError.html("You must book a minimum of " + config.min_Adults + " adults")
        }
        else if (numAdults > config.max_Adults){
            $numAdultError.html("You can only book a maximum of " + config.max_Adults + " adults")
        }
        else { //else leave this field blank
            $numAdultError.html("");
            generatePrice();
        }


        if (isNaN(numChild) === true ){ //if number of children is left blank or is = 0
            $numChildError.html("Please don't leave this field blank");
        }
        else if (numChild < 0){
            $numChildError.html("Please don't select a number less than 0");
        }
        else if (numChild < config.min_Children){
            $numChildError.html("You must book a minimum of " + config.min_Children + " children")
        }
        else if (numChild > config.max_Children){
            $numChildError.html("You can only book a maximum of " + config.max_Children + " children")
        }
        else {
            $numChildError.html("");
        }

        if ($numChildError.html() === ""){
            generatePrice();
            /*$("#total_price").html("£"+nights*config.price_per_night);
            $("#total_price_field").html(nights*config.price_per_night);*/
        }

        /*function isBooked($bookings, $arriveDate, $departDate) {
            $bookings.forEach(function ($booking) { //for every item in the bookings array store it in a variable called $booking
                console.log($booking);
                /!*let $arrival_Date = moment($booking=>arrivalDate); //turn the arrival date into a date format
                let $depart_Date = new DateTime($booking=>departDate); //turn the depart date into a date format
                let $interval = DateInterval::createFromDateString("1 day"); //this will increment dates by 1 day
                let $days = new DatePeriod($arriveDate, $interval, $departDate); //creates an object called days with all the days inbetween the arrive and depart date
                $days.forEach(function ($date) { //for every day between the two dates selected
                    if ($date >= $arrival_Date && $date <= $depart_Date){ //if the date is greater than or equal to the depart date and less than or equal to the arrival date of the bookings then;
                        return true;
                    }
                });*!/
            });
            return false; //else return false
        }

        if (isBooked($bookings, $arriveDate, $departDate)){
            $bookingError.html("Please don't select a booked date");
        }

        if ($arriveDateError.html() === "" && $departDateError.html() === ""){
            if (isBooked($bookings, $arriveDate, $departDate)){
                $bookingError.html("Please don't select a booked date");
            }
            else{
                $bookingError.html("");
            }
        }*/

        //if there are no errors in any of the error fields then:
        if ($arriveDateError.html() !== "" || $departDateError.html() !== "" || $numAdultError.html() !== "" || $numChildError.html() !== ""){
            event.preventDefault(); //stops the form from submitting to the server.
        }
        else { //else submit to server

        }

    });

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    $('.prev_step').click(function() { //When the back button is clicked:
        $('.BookingFormUserInfo').slideUp("slow"); //hide the user info section
        $('.AvailabilityCalender').slideDown('slow'); //show the calendar
    });



    $(".num_people .up").click(function(){ //when an "up" class that is a child of a "num_people" class then:
        let $max = ""; //creates a local variable to store the maximum value.
        let $input_element = $("input", $(this).parent()); //Gets the element information of an input tag within the button's parent tag.
        let $currant_value = $input_element.val(); //Gets the current value of the input field.
        let $id = $input_element.attr('id'); //Gets the ID of the input field

        if ($id === "num_Adults"){ //if the id == num_Adults then
            $max = config.max_Adults //the maximum value is equal to the global variable max_adults
        }
        else { //or
            $max = config.max_Children // the maximum value is equal to the global variable max_children
        }

        if ($currant_value < $max){ //If the current value is less than the maximum then:
            $input_element.val(parseInt($currant_value) + 1); //convert the current value to an integer then add 1
        }
    });



    $(".num_people .down").click(function() {
        let $min = ""; //local variable to store the maximum value
        let $input_element = $("input", $(this).parent()); //Gets the element information of an input tag within the button's parent tag.
        let $currant_value = $input_element.val(); //Gets the current value of the input field.
        let $id = $input_element.attr('id'); //Gets the ID of the input field
        if ($id === "num_Adults"){ //if the id == num_Adults then
            $min = config.min_Adults; //the minimum value is equal to the global variable max_adults
        }
        else {
            $min = config.min_Children; // the maximum value is equal to the global variable max_children
        }
        if ($currant_value > $min) { //If the current value is less than the maximum then:
            $input_element.val(parseInt($currant_value) - 1); //convert the current value to an integer then add 1
        }
    });

});

