<?php 
    /** Delete a job based on a specific job ID **/
	require_once("new-connection.php");
	$query = sprintf("DELETE FROM jobs WHERE id=%s", $_POST["delete_id"]);
	if(mysqli_query($connection, $query)){
        $_SESSION['jobState'] = array("deletion_success", "Successfully deleted job");
    }
    else{
        $_SESSION['jobState'] = array("deletion_failure", "There was an error. Please try again later");

    }
	header("Location: /employer_home.php");
?>