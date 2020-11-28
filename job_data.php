<?php 

require_once("new-connection.php");
/** 
    @description: Used to get all the information for a specific job based on its ID
    @params:
        $id -> Job id 
**/
function getJobInformation($id)
{
    global $connection;
    $query = sprintf("SELECT * FROM jobs WHERE id='%s'", mysqli_escape_string($connection, $id));
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

/** 
    @description: Used to get the required skills for a specific job 
    @params:
        $id -> Job id 
**/
function getRequiredSkills($id) 
{
    global $connection;
    $query = sprintf("SELECT skillId, skillName FROM jobSkills INNER JOIN skills ON skills.id = jobSkills.skillId WHERE jobSkills.jobId='%s'", mysqli_escape_string($connection, $id));
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