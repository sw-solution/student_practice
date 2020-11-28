<?php
	require_once('new-connection.php');
	if (!is_numeric($_POST['minimum_gpa']) || (float)$_POST['minimum_gpa'] > 4.0 || (float)$_POST['minimum_gpa'] < 0.0 )
	{
		$_SESSION['error_status'] = array("job_creation", "GPA must be a number between 0.0 and 4.0");
	}

	$query = sprintf("INSERT INTO jobs (companyRecruiterId, title, description, requiredGpa, requiredYear, city, state) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')", $_SESSION['state'][1]['id'], $_POST['title'], $_POST['description'], $_POST['minimum_gpa'], $_POST['academic_class'], $_POST['city'], $_POST['state']);  
	if ($result = mysqli_query($connection, $query)) {
		//Insertion worked
		$query = "SELECT id FROM jobs ORDER BY ID DESC LIMIT 1";
		$result = mysqli_query($connection, $query);
		$row = mysqli_fetch_row($result);
		$jobId = $row[0];
		foreach ($_POST['skills'] as $skillName) {
			$query = sprintf("SELECT id FROM skills WHERE skillName='%s'", $skillName);
			if($result = mysqli_query($connection, $query)) {
				$row = mysqli_fetch_row($result);
				$skillId = $row[0];
				$query = sprintf("INSERT INTO jobSkills (skillId, jobId) VALUES (%s, %s)", $skillId, $jobId);
				mysqli_query($connection, $query);
			}
		}

                $_SESSION['jobState'] = array("addition_success", "Successfully added job");
            
            
	} else{
                $_SESSION['jobState'] = array("addition_failure", "There was an error. Please try again later");
            }
	//Insert all required skills
	header("Location: /employer_home.php");
?>