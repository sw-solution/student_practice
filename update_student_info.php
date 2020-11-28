<?php
	require_once("new-connection.php");

	//Validate gpa
	if (!is_numeric($_POST['gpa']) || (float)$_POST['gpa'] < 1.0 || (float)$_POST['gpa'] > 4.0)
	{
		$_SESSION['updateInfoState'] = array("update_failure", "GPA must be a number beteween 1.0 and 4.0");
	   header("Location: /student_home.php");
	   return;
	}

	$query = sprintf("UPDATE students SET firstName='%s', lastName='%s', studentEmail='%s', year='%s', gpa='%s' WHERE id=%s", $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['academic_class'], $_POST['gpa'], $_SESSION['state'][1]['id']);
	if(mysqli_query($connection, $query)){
        $_SESSION['updateInfoState'] = array("update_success", "Successfully updated your info");
        $query = sprintf("SELECT * FROM students WHERE studentEmail = '%s' and password = '%s'",
		    mysqli_escape_string($connection, $_SESSION['state'][1]['studentEmail']),
		    mysqli_escape_string($connection, $_SESSION['state'][1]['password'])
		);
		echo $query;
		if ($result = mysqli_query($connection, $query)) {
		    //No error
		    $row = mysqli_fetch_assoc($result);
		    var_dump($row);
		    if(!is_null($row) && sizeof($row) > 0)
		    {
		        $_SESSION['state'] = array("student_logged_in", $row);
		        //Go to student profile
		        header("Location: student_home.php");
		        return;
		    }
		    else {
		        $_SESSION['state'] = array("login_failure", "Incorrect email/password combination");
		        header("Location: /");
		        return;
		    }
		}
    }
    else{
        $_SESSION['updateInfoState'] = array("update_failure", "There was an error. Please try again later");
    }
   header("Location: /student_home.php");
?>