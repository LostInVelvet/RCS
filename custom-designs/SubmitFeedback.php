<?php
    $name = document.getElementById("adviceName").value;
    $email = document.getElementById("adviceEmail").value;
    $bugs = document.getElementById("adviceBugs").value;
    $add = document.getElementById("adviceAdd").value;
    $myEmail = "tararowland77";
    $myEmail += "@";
    $myEmail += "gmail.com";

    if(!$name){
        $name = "No Name";
    }
    if(!$email){
        $email = "No Email";
    }
    if(!$bugs){
        $bugs = "No Bugs";
    }
    if(!$add){
        $add = "No Feedback";
    }

    $msg = "From: " + $name + "\n" +
    "Email: " + $email + "\n\n" +
    "Bugs: \n" +
    $bugs + "\n\n" +
    "Feedback: \n" +
    $add;
    
    
    mail('tararowland77@gmail.com', "DesignsByRCS Feedback", $msg);
?>