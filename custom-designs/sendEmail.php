<?php
if ($_POST){
    $myEmail = "tararowland77@gmail.com";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    mail($myEmail, $name, $message);
}
?>