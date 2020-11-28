<?php 
	require_once("new-connection.php");
	mysqli_begin_transaction();
	foreach ($_POST['companies'] as $company) {
		$query = sprintf("INSERT INTO studentInterests (companyName, studentId) VALUES ('%s', %s)", $company, $_SESSION['state'][1]['id']);
		if(mysqli_query($connection, $query)) 
		{
			$_SESSION['applicationState'] = array("interests_submitted", "Your company interests have been saved");
		} else {
			$_SESSION['applicationState'] = array("interests_failed", "There was an error saving your interests. Please try again later");
			mysqli_rollback();
			header("Location: /student_home.php");
			return;

		}
	}
	$query = sprintf("UPDATE students SET hasCompletedInterestSurvey = 1 WHERE id = %s", $_SESSION['state'][1]['id']);
	$_SESSION['state'][1]['hasCompletedInterestSurvey'] = 1;
	if(mysqli_query($connection, $query)) 
	{
		$_SESSION['applicationState'] = array("interests_submitted", "Your company interests have been saved");
		mysqli_commit();
	} else {
		$_SESSION['applicationState'] = array("interests_failed", "There was an error saving your interests. Please try again later");
		mysqli_rollback();

	}
	header("Location: /student_home.php");
	
?>