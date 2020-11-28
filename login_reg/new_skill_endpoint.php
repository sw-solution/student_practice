<?php
    require_once("new-connection.php");
    $query = sprintf("SELECT id FROM skills WHERE skillName='%s'", $_POST['skillName']);
    if ($result = mysqli_query($connection, $query)) {
        //No error
        $row = mysqli_fetch_row($result);
        if(!is_null($row) && sizeof($row) > 0)
        {
            $skillId = $row[0];
            //Check for existence already
            $query = sprintf("SELECT id FROM studentSkills WHERE skillId='%s' AND studentId=%s", $skillId, $_SESSION['state'][1]['id']);
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_row($result);
            if (!is_null($row) && sizeof($row) >= 0)
            {
                $_SESSION['skillState'] = array("addition_failure", "You already have this skill");
                header("Location: /student_home.php");
                return;
            }

            $query = sprintf("INSERT INTO studentSkills (studentId, skillId) VALUES ('%s', '%s')", $_SESSION['state'][1]['id'], $skillId);
            if(mysqli_query($connection, $query)){
                $_SESSION['skillState'] = array("addition_success", "Successfully added skill");
            }
            else{
                $_SESSION['skillState'] = array("addition_failure", "There was an error. Please try again later");
            }
        }
        else {
            $query = sprintf("INSERT INTO skills (skillName) VALUES ('%s')", $_POST['skillName']);
            //run query 
            mysqli_query($connection, $query);
            $query = sprintf("SELECT id FROM skills ORDER BY id DESC LIMIT 1");
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_row($result);
            //var_dump($row);
            $skillId = $row[0];
            $query = sprintf("INSERT INTO studentSkills (studentId, skillId) VALUES ('%s', '%s')", $_SESSION['state'][1]['id'], $skillId);
            if(mysqli_query($connection, $query)){
                $_SESSION['skillState'] = array("addition_success", "Successfully added project");
            }
            else{
                $_SESSION['skillState'] = array("addition_failure", "There was an error. Please try again later");
            }
        }
    } 
    header("Location: /student_home.php");
?>