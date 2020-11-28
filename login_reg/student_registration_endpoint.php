<?php
require_once('new-connection.php');

$query = sprintf("SELECT id FROM students WHERE studentEmail = '%s'", $_POST['email']);
if($result = mysqli_query($connection, $query)){
    $row = mysqli_fetch_row($result);
    if (!is_null($row) && sizeof($row) >= 0)
    {
        $_SESSION['state'] = array("register_failure", "This email is already registered. Please login");
    } else {
        $query = sprintf("INSERT INTO students (firstName, lastName, studentEmail, bio, year, gpa, password, hasCompletedInterestSurvey) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', false)",
        mysqli_escape_string($connection, $_POST['first_name']),
        mysqli_escape_string($connection, $_POST['last_name']),
        mysqli_escape_string($connection, $_POST['email']),
        mysqli_escape_string($connection, $_POST['bio']),
        mysqli_escape_string($connection, $_POST['academic_year']),
        mysqli_escape_string($connection, $_POST['gpa']),
        mysqli_escape_string($connection, $_POST['password'])
        );
        if(mysqli_query($connection, $query)){
             //Redirect to login
            $_SESSION['state'] = array("register_success", "Successfully registered. Proceed to login");
        }
        else{
            //Report error to user
            $_SESSION['state'] = array("register_failure", "There was an error. Please try again later");
        }
    }
}
header("Location: /");
 ?>