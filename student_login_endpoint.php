<?php
require_once('new-connection.php');

$query = sprintf("SELECT * FROM students WHERE studentEmail = '%s' and password = '%s'",
    mysqli_escape_string($connection, $_POST['email']),
    mysqli_escape_string($connection, $_POST['password'])
);
if ($result = mysqli_query($connection, $query)) {
    //No error
    $row = mysqli_fetch_assoc($result);
    if(!is_null($row) && sizeof($row) > 0)
    {
        $_SESSION['state'] = array("student_logged_in", $row);
        //Go to student profile
        header("Location: student_home.php");
    }
    else {
        $_SESSION['state'] = array("login_failure", "Incorrect email/password combination");
        header("Location: /");
    }
}
else {
    $_SESSION['state'] = array("login_failure", "Incorrect email/password combination");
    header("Location: /");
}

 ?>