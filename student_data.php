<?php 
require_once("new-connection.php");

/**
    @description: Gets work experience for students along with the employer ID (used for ratings)
    @params: 
        $studentId -> used to identify which student to get the work experience data for
**/
function getStudentAltWorkExperiences($studentId)
{
    global $connection;
    $query = sprintf("SELECT workExperience.id as id, companyName, role, roleDescription, city, state, start, end, studentId, companyRecruiter.id as eId FROM workExperience INNER JOIN companyRecruiter ON companyRecruiter.company = workExperience.companyName WHERE studentId='%s'", mysqli_escape_string($connection, $studentId));
    if ($result = mysqli_query($connection, $query)) {
        //No error
            $data = array();

        while($row = mysqli_fetch_assoc($result)) 
        {
            $data[] = $row;
        }
        if(!is_null($data) && sizeof($data) > 0)
        {
            return $data;
        }
        else {
            return array();
        }
    }
}

/**
    @description: Gets work experience for students (used for diplaying students work experience on the student_home page)
    @params: 
        $studentId -> used to identify which student to get the work experience data for
**/
function getStudentWorkExperiences($studentId)
{
    global $connection;
    $query = sprintf("SELECT workExperience.id as id, companyName, role, roleDescription, city, state, start, end, studentId FROM workExperience WHERE studentId='%s'", mysqli_escape_string($connection, $studentId));
        if ($result = mysqli_query($connection, $query)) {
        //No error
            $data = array();

        while($row = mysqli_fetch_assoc($result)) 
        {
            $data[] = $row;
        }
        if(!is_null($data) && sizeof($data) > 0)
        {
            return $data;
        }
        else {
            return array();
        }
    }
}


/**
    @description: Gets projects for students (used for diplaying students projects on the student_home page)
    @params: 
        $studentId -> used to identify which student to get the project data for
**/
function getStudentProjects($studentId)
{
    global $connection;
    $query = sprintf("SELECT * FROM projects WHERE studentId='%s'", mysqli_escape_string($connection, $studentId));
    if ($result = mysqli_query($connection, $query)) {
        //No error
        $data = array();
        while($row = mysqli_fetch_assoc($result)) 
        {
            $data[] = $row;
        }
        if(!is_null($data) && sizeof($data) > 0)
        {
            return $data;
        }
        else {
            return array();
        }
    }
}

/**
    @description: Gets skills for students (used for diplaying students skills on the student_home page)
    @params: 
        $studentId -> used to identify which student to get the skill data for
**/
function getStudentSkills($studentId) 
{
    global $connection;
    $query = sprintf("SELECT studentSkills.id as ssid, skills.skillName FROM studentSkills LEFT JOIN skills on studentSkills.skillId = skills.id WHERE studentId='%s'", mysqli_escape_string($connection, $studentId));
    if ($result = mysqli_query($connection, $query)) {
        //No error
        $data = array();
        while($row = mysqli_fetch_assoc($result)) 
        {
            $data[] = $row;
        }
        if(!is_null($data) && sizeof($data) > 0)
        {
            return $data;
        }
        else {
            return array();
        }
    }
}

/**
    @description: Gets the company interest of a student if they exist (used to get the skill recommendation for a student based on the companu ID)
    @params: 
        $studentId -> used to identify which student to get the interest data for
**/
function getStudentInterests($studentId) 
{
    global $connection;
    $query = sprintf("SELECT companyName, companyRecruiter.id as employerId  FROM studentInterests INNER JOIN companyRecruiter ON companyRecruiter.company = companyName WHERE studentId='%s'", mysqli_escape_string($connection, $studentId));
    if ($result = mysqli_query($connection, $query)) {
        //No error
        $data = array();
        while($row = mysqli_fetch_assoc($result)) 
        {
            $data[] = $row;
        }
        if(!is_null($data) && sizeof($data) > 0)
        {
            return $data;
        }
        else {
            return array();
        }
    }
}

/**
    @description: Gets general information for a student
    @params: 
        $studentId -> used to identify which student to get the information for
**/

function getSpecificStudentInfo($studentId) 
{
    global $connection;
    $query = sprintf("SELECT * FROM students WHERE id='%s'", mysqli_escape_string($connection, $studentId));
    if ($result = mysqli_query($connection, $query)) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
}

/**
    @description: Gets all the available skills in the database
    @params: N/A     
**/
function getAllSkills() 
{
    global $connection;
    $query = sprintf("SELECT * FROM skills");
    if ($result = mysqli_query($connection, $query)) {
        //No error
            $data = array();

        while($row = mysqli_fetch_assoc($result)) 
        {
            $data[] = $row;
        }
        if(!is_null($data) && sizeof($data) > 0)
        {
            return $data;
        }
        else {
            return array();
        }
    }
}

/**
    @description: Gets all the available companies in the database
    @params: N/A     
**/
function getAllCompanies() {
    global $connection;
    $query = "SELECT company FROM companyRecruiter GROUP BY company";
    if ($result = mysqli_query($connection, $query)) {
        //No error
        $data = array();

        while($row = mysqli_fetch_assoc($result)) 
        {
            $data[] = $row;
        }
        if(!is_null($data) && sizeof($data) > 0)
        {
            return $data;
        }
        else {
            return array();
        }
    }
}

/**
    @description: Gets the companies which are missing ratings for a particular student
    @params: 
        $studentId -> used to identify which student to get the information for    
**/
function missingRatings($studentId) {
    global $connection;
    $query = sprintf("SELECT companyId FROM companyRatings WHERE studentId = %s", mysqli_escape_string($connection, $studentId));
    if ($result = mysqli_query($connection, $query)) {
        //No error
        $idList = array();
        while($row = mysqli_fetch_assoc($result)) 
        {
            array_push($idList, $row['companyId']);
        }
        
        $missingRatingsList = array();
        $currWorkExperience = getStudentAltWorkExperiences($studentId);
        foreach ($currWorkExperience as $exp) {
            if (!in_array($exp['eId'], $idList))
            {
                array_push($missingRatingsList, $exp);
            }
        }
        return $missingRatingsList;
        
    }

}

?>