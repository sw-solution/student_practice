<?php
require_once("new-connection.php");
    /** 
    @description: Gets the relevant stats for the JobFinder IE Staff page
        The stats are as follows:
            Most demanded skill -> The first stat is the most demanded skill based on what skills employers specify as required during the job creation process.

            Most applied to companies -> Specifies the most appleid to companies by students

            Companies with the most previous employees -> Shows which companies are specified as previous employers by the most students
            
    @params: N/A
    **/
	function getStats() {
		global $connection;

		//Most demanded skill
		$query = "SELECT skillName, count(skillName) as num FROM jobskills INNER JOIN skills ON skillId = skills.id GROUP BY skillName";
		if ($result = mysqli_query($connection, $query)) {
        	//No error
	        while($row = mysqli_fetch_assoc($result)) 
	        {
	            $highestSkills[] = $row;
	        }
	    }
		//Most applied to companies
	    $query = "SELECT count(company) as amount, company FROM jobApplications INNER JOIN jobs ON jobs.id = jobApplications.jobId INNER JOIN companyRecruiter ON companyRecruiter.id = jobs.companyRecruiterId GROUP BY company";
	    if ($result = mysqli_query($connection, $query)) {
        	//No error
	        while($row = mysqli_fetch_assoc($result)) 
	        {
	            $highestAppliedCompanies[] = $row;
	        }
	    }
		//Companies with the most previous employees
		$query = "SELECT count(companyName) as amount, companyName FROM workExperience GROUP BY companyName";
		if ($result = mysqli_query($connection, $query)) {
        	//No error
	        while($row = mysqli_fetch_assoc($result)) 
	        {
	            $highestPrevEmployers[] = $row;
	        }
	    }

	    return array("skills" => $highestSkills, "applied" => $highestAppliedCompanies, "previous" => $highestPrevEmployers);
	}
 ?>