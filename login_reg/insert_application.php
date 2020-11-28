<?php
	/** 
		This file is responsible for inserting a students application into the database based on the students ID and the job ID.
	**/
	require_once("new-connection.php");
	global $connection;
	if (!isset($_GET['jobId']) || !(isset($_SESSION['state'])))
	{
		header("Location: /");
	}
	$studentId = $_SESSION['state'][1]['id'];
	$jobId = $_GET['jobId'];
	$query = "SELECT id FROM jobApplications WHERE studentId = {$studentId} AND jobId = {$jobId}";
	$row = mysqli_fetch_assoc(mysqli_query($connection, $query));
	if (is_null($row) || sizeof($row) == 0)
	{
		$query = "INSERT INTO jobApplications (studentId, jobId) VALUES ({$studentId}, {$jobId})";
		if(mysqli_query($connection, $query)){
	        $_SESSION['applicationState'] = array("addition_success", "Successfully applied");
	    }
	    else{
	        $_SESSION['applicationState'] = array("addition_failure", "There was an error. Please try again later");
	    }
	} else {
		$_SESSION['applicationState'] = array("addition_failure", "You have previously applied to this job");
	}
   header("Location: student_home.php");
?>