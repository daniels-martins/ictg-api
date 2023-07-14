<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo jsonResponseForGetRequest();
} else {
    //create dynamic variables
    foreach ($_POST as $key => $val) $$key = $val;

    // hash the password for security reasons
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 7]);
    normalOutput();
    $conn = connectToDB(); //create db connection
    $sql =
        "INSERT INTO users (email, password)
        VALUES('$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) // check if query was successful
    {
        echo "New record created successfully";
        loginUser($email, $password);
    } else
        echo "Error: " . $sql . "<br>" . $conn->error;

    $conn->close();   // close db connection
}
