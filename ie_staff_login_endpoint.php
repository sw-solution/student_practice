<?php
/**
    This file represents the endpoint for IE staff logging in.
    It is based on the email and password passed into the form.
    If both credentials are correct, then the employer is successfully logged in
**/
require_once('new-connection.php');
$query = sprintf("SELECT * FROM ieStaff WHERE email = '%s' and password = '%s'",
    mysqli_escape_string($connection, $_POST['email']),
    mysqli_escape_string($connection, $_POST['password'])
);
if ($result = mysqli_query($connection, $query)) {
    //No error
    $row = mysqli_fetch_assoc($result);
    if(!is_null($row) && sizeof($row) > 0)
    {
        $_SESSION['state'] = array("ie_staff_logged_in", $row);
        //Go to student profile
        header("Location: /ie_staff_home.php");
    }
    else {
        $_SESSION['state'] = array("login_failure", "Incorrect email/password combination");
        header("Location: /ie_staff_login.php");
    }
}
else {
    $_SESSION['state'] = array("login_failure", "Incorrect email/password combination");
    header("Location: /ie_staff_login.php");
}

 ?>