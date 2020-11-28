<?php 
	require_once("new-connection.php");
	foreach ($_POST["companyName"] as $key => $value) {
		$query = sprintf("INSERT INTO companyRatings (studentId, companyId, score, feedback) VALUES (%s, (SELECT id FROM companyRecruiter WHERE company = '%s'), %s, '%s')", $_SESSION['state'][1]['id'], $_POST["companyName"][$key], (int)$_POST["rating"][$key], $_POST["feedback"][$key]);
		if ($result = mysqli_query($connection, $query)) {
			$_SESSION['ratingState'] = array("addition_success", "Successfully submitted ratings");
		} else {
			$_SESSION['ratingState'] = array("addition_failure", "There was an error. Please try again later");
		}
	}

	header("Location: /student_home.php");
?>