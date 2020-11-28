<?php 
    /** Delete a project based on a specific project ID **/
	require_once("new-connection.php");
	$query = sprintf("DELETE FROM projects WHERE id = %s", $_POST['delete_id']);
	if(mysqli_query($connection, $query)){
        $_SESSION['projectState'] = array("deletion_success", "Successfully deleted project");
    }
    else{
        $_SESSION['projectState'] = array("deletion_failure", "There was an error. Please try again later");

    }
   header("Location: /student_home.php");
?>