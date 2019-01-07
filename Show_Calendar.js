
let arrive_id = 0; //Equal to current month
let depart_id = 0;
let arrive = "a_";//corresponds to the arrive calendar or the depart calendar
let depart = "d_";


function arrive_fwrd() { //advances the month shown by 1
    document.getElementById(arrive+arrive_id).className = 'hide'; //hides the current month displayed
    arrive_id = arrive_id + 1; //adds 1 to the arrive id
    document.getElementById(arrive+arrive_id).className = "show"; //shows the next month
}

function arrive_back() { //retreats the month by 1
    document.getElementById(arrive+arrive_id).className = 'hide'; //hides the current month displayed
    arrive_id = arrive_id - 1; //removes 1 from id
    document.getElementById(arrive+arrive_id).className = "show"; //displays the previous month
}

function depart_fwrd() { //advances the month shown by 1
    document.getElementById(depart+depart_id).className = 'hide'; //hides the current month displayed
    depart_id = depart_id + 1; //adds 1 to the depart id
    document.getElementById(depart+depart_id).className = "show"; //shows the next month
}

function depart_back() { //retreats the month by 1
    document.getElementById(depart+depart_id).className = 'hide'; //hides the current month displayed
    depart_id = depart_id - 1; //removes 1 from id
    document.getElementById(depart+depart_id).className = "show"; //displays the previous month
}

