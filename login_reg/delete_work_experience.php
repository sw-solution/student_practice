<?php 
    /** Delete work experience based on a specific work experience ID **/
	require_once("new-connection.php");
	$query = sprintf("DELETE FROM workExperience WHERE id = %s", $_POST['delete_id']);
	if(mysqli_query($connection, $query)){
        $_SESSION['workExperienceState'] = array("deletion_success", "Successfully deleted work experience");
    }
    else{
        $_SESSION['workExperienceState'] = array("deletion_failure", "There was an error. Please try again later");

    }
   header("Location: /student_home.php");
?>