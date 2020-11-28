<?php 
/**
	This file is responsible for setting up the ML model for interest classification.
	It fetches all the jobs in the database, the corresponding skill requirements for each job, and the company the job was created by, and then trains the ML model with the company name as the data and the skill as the label
**/
require_once("new-connection.php");
require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Classification\NaiveBayes;
	function mlDataLoader(){
		global $connection;
		$GLOBALS['classifier'] = new NaiveBayes();
		$query = "SELECT skillId, companyRecruiter.id as company FROM jobSkills INNER JOIN jobs ON jobs.id = jobSkills.jobId INNER JOIN companyRecruiter ON jobs.companyRecruiterId = companyRecruiter.id";
		if ($result = mysqli_query($connection, $query))
		{
			while($row = mysqli_fetch_assoc($result)) 
	        {
	            ($GLOBALS['classifier'])->train([[$row['company']]], [$row['skillId']]);
	        }
		}
	}
?>