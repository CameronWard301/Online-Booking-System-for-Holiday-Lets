$(document).ready(function () {
    let $configElement = $("#config");
    let config = JSON.parse($configElement.val());
    /** @namespace config.maxMessage*/
    $("#prev_step").click(function () {
        window.location.replace("index.php");
    });
    $("#submit").click(function (event) {
        let firstName = $("#firstName").val();
        let lastName = $("#lastName").val();
        let email = $("#email").val();
        let phone = $("#phone").val();
        let message = $("#message").val();
        let messageLength = message.length;
        let firstNameError = $("#first_name_error");
        let lastNameError = $("#last_name_error");
        let emailError = $("#email_error");
        let phoneError = $("#phone_error");
        let messageError = $("#message_error");
        if (firstName === ""){
            firstNameError.html("Please don't leave this field blank");
        }
        else {
            firstNameError.html("");
        }
        if (lastName === ""){
            lastNameError.html("Please don't leave this field blank");
        }
        else {
            lastNameError.html("");
        }
        if (email === ""){
            emailError.html("Please don't leave this field blank");
        }
        else {
            emailError.html("");
        }
        if (phone === ""){
            phoneError.html("Please don't leave this field blank");
        }
        else if(isNaN(phone)){
            phoneError.html("Please enter only numbers")
        }
        else if (phone.length > 15){
            phoneError.html("Please enter a valid phone number")
        }
        else {
            phoneError.html("");
        }
        if (messageLength > config.maxMessage){
            messageError.html("Please don't exceed the character limit of: " + config.maxMessage + " characters")
        }
        else
            messageError.html("");
        //if there are any error then:
        if (firstNameError.html() !== "" || lastNameError.html() !== "" || emailError.html() !== "" || phoneError.html() !== "" || messageError.html() !==""){
            event.preventDefault(); //don't submit to server
            console.log("prevented")
        }
        else {
            //submit to server
            console.log("Sent")
        }

    });
});