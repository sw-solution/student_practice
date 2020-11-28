<?php
    require_once("new-connection.php");
    $query = sprintf("INSERT INTO projects (studentId, title, description) VALUES (%s, '%s', '%s')", $_SESSION['state'][1]['id'], $_POST['projectTitle'], $_POST['projectDescription']);
    echo   $query;
    if(mysqli_query($connection, $query)){
        echo "Worked";
        $_SESSION['projectState'] = array("addition_success", "Successfully added project");
    }
    else{
        echo "Failed";
        $_SESSION['projectState'] = array("addition_failure", "There was an error. Please try again later");

    }
   header("Location: /student_home.php");
?>