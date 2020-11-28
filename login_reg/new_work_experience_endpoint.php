<?php
    require_once("new-connection.php");
    $query = sprintf("INSERT INTO workExperience (companyName,role, roleDescription, city, state, start, end, studentId) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', %s)", $_POST['companyName'], $_POST['jobRole'], $_POST['roleDescription'], $_POST['jobCity'], $_POST['jobState'],  $_POST['jobStartDate'], $_POST['jobEndDate'], $_SESSION['state'][1]['id']);
echo  $query;
    if(mysqli_query($connection, $query)){
        echo "Worked";
        $_SESSION['workExperienceState'] = array("addition_success", "Successfully added work experience");
    }
    else{
        echo "Failed";
        $_SESSION['workExperienceState'] = array("addition_failure", "There was an error. Please try again later");

    }
   header("Location: /student_home.php");
?>