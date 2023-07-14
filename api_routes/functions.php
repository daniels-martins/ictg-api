<?php
function jsonResponseForGetRequest()
{
    echo 'get request';
    return json_decode(
        'a get request was sent'
    );
}


function normalOutput()
{
    preFormat($_POST);
    echo '<br> we are in the dashboard<br>';
    var_dump($_POST['dashboard_route']);
    // sleep(10);
}

function redirectToDashboard($userEmail)
{
    header("Location: {$_POST['dashboard_route']}?$userEmail");
}

function connectToDB()
{
    $hostname = 'localhost';
    $db_user = 'root';
    $db_pwd = null;
    $db_name = 'ictg_api_db';

    $conn = new mysqli($hostname, $db_user, $db_pwd, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        return $conn;
    }
}

function loginUser($email, $password)
{
    // echo 'login user <br>';
    // echo empty(trim($email)), empty(trim($password));
    if (empty(trim($email)) or empty(trim($password)))
    die("Authentication failed: Invalid Credentials <a style='cursor:pointer' onclick='event.preventDefault();history.back()'>Go back</a>");

    else if ($foundUser = userExists($email, $password)) {
        authenticateUser($foundUser);
    }
}

function authenticateUser($foundUser)
{
    $userEmail = $foundUser['email'];
    //verify password gotten from the db
    return redirectToDashboard($userEmail);
}

// sql related functions

function userExists($email, $password)
{
    // echo "checking existence of ' $email and  $password . <br>";
    $conn = connectToDB();
    $sql = "SELECT email,password FROM users WHERE email = '$email' ";
    $resObj = $conn->query($sql);
    if ($resObj->num_rows > 0) {
        $user = $resObj->fetch_assoc();

        // confirm user email and password match
        if ($user = $resObj->fetch_assoc() and password_verify($password, $user['password']))  return $user;
        die("Authentication failed: Invalid Credentials <a href='' style='cursor:pointer' onclick='event.preventDefault();history.back()'>Go back</a>");
    } else {
        die("Authentication failed: Invalid Credentials <a href='' style='cursor:pointer' onclick='event.preventDefault();history.back()'>Go back</a>");
    }
    $conn->close();
}








// function getUser(){

// }

function preFormat($var, $vardump = null)
{
    echo '<pre>';
    $vardump ? var_dump($var) : print_r($var);
    echo '</pre>';
}
