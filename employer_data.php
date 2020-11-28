<?php
require_once("new-connection.php");

/** 
    @description: Gets all the open jobs for a specific employer
    @params: N/A
 **/
function getJobsForEmployer()
{
    global $connection;
    $recruiterId = $_SESSION['state'][1]['id'];
    $query = sprintf("SELECT * FROM jobs WHERE companyRecruiterId ='%s'", mysqli_escape_string($connection, $recruiterId));
    $result = mysqli_query($connection, $query);
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
    else{
        echo "problem";
    }
}

/**
    @description: Gets all the available skills in the database
    @params: N/A     
**/
function getAllSkills() 
{
    global $connection;
    $studentId = $_SESSION['state'][1]['id'];
    $query = sprintf("SELECT * FROM skills");
    if ($result = mysqli_query($connection, $query)) {
        //No error
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

?>