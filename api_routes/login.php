<?php

require 'functions.php';

// echo 'login script <br>';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo jsonResponseForGetRequest();
} else {
    //create dynamic variables
    foreach ($_POST as $key => $val) $$key = $val;

    // normalOutput();
    $conn = connectToDB(); //create db connection

    loginUser($email, $password);

    $conn->close();   // close db connection
}
