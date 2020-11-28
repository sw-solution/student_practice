<?php
/**
    This file represents the endpoint for employer logging in.
    It is based on the email and password passed into the form.
    If both credentials are correct, then the employer is successfully logged in
**/
require_once('new-connection.php');
$query = sprintf("SELECT * FROM companyRecruiter WHERE corporateEmail = '%s' and password = '%s'",
    mysqli_escape_string($connection, $_POST['email']),
    mysqli_escape_string($connection, $_POST['password'])
);
if ($result = mysqli_query($connection, $query)) {
    //No error
    $row = mysqli_fetch_assoc($result);
    var_dump($row);
    if(!is_null($row) && sizeof($row) > 0)
    {
        $_SESSION['state'] = array("employer_logged_in", $row);
        //Go to employer profile
        header("Location: /employer_home.php");
    }
    else {
        $_SESSION['state'] = array("login_failure", "Incorrect email/password combination");
        header("Location: /employer_login.php");
    }
}
else {
    $_SESSION['state'] = array("login_failure", "Incorrect email/password combination");
    header("Location: /employer_login.php");
}

 ?>