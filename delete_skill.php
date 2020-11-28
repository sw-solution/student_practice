<?php 
    /** Delete a skill based on a specific skill ID **/
	require_once("new-connection.php");
	$query = sprintf("DELETE FROM studentSkills WHERE id = %s", $_POST['delete_id']);
	if(mysqli_query($connection, $query)){
        $_SESSION['skillState'] = array("deletion_success", "Successfully deleted project");
    }
    else{
        $_SESSION['skillState'] = array("deletion_failure", "There was an error. Please try again later");
    }
   header("Location: /student_home.php");
?>