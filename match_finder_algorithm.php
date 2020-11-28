<?php	
    require_once("student_data.php");
    require_once("job_data.php");

    /*
        Algorithm description:
        All job requirements will be compared against the students portfolio
        The requirements will form the base for the calculation
        Additional factors will be added in such as a students interest in working for a company
        Additional consideration will be made based on overlap between any project experience and job descriptions (after filtering pronouns, conjuctions, adjectives)
     */
    function comparator($a, $b) {
        if ($a['match'] == $b['match']) {
            return 0;
        }
        return ($a['match'] < $b['match']) ? 1 : -1;
    }

    function getStudentMatches($jobId) {
        $jobInfo = getJobInformation($jobId)[0];
        $jobReqSkills = getRequiredSkills($jobId);
        $jobReqSkills_compare = array();
        foreach ($jobReqSkills as $value) {
            array_push($jobReqSkills_compare, $value['skillId']);
        }
        $students = getAllStudents();
        
        if (sizeof($students) > 0)
        {
            //Use skills, gpa, academic year, projects and work experience
            foreach ($students as $key => $student) {
                
                $students[$key]["match"] = 0;

                //meeting the gpa requirement is 10%

                if ((float)$students[$key]['gpa'] >= (float)$jobInfo['requiredGpa'])
                {
                    $students[$key]["match"] += 10;
                }

                //meeting the year requirement is 10%
                if ($jobInfo['requiredYear'] == "Freshman") {
                    $students[$key]["match"] += 10;
                } else if ($students[$key]['year'] == "Junior" && ($jobInfo['requiredYear'] == "Freshman" || $jobInfo['requiredYear'] == "Sophomore" || $jobInfo['requiredYear'] == "Junior")) {
                    $students[$key]["match"] += 10;
                } else if ($students[$key]['year'] == "Sophomore" && ($jobInfo['requiredYear'] == "Freshman" || $jobInfo['requiredYear'] == "Sophomore")) {
                    $students[$key]["match"] += 10;
                }


                //Find all the skills for a particular student
                $studentSkills = getSkillsForAStudent($students[$key]["id"]);
                $studentSkills_compare = array();

                foreach ($studentSkills as $value) {
                    array_push($studentSkills_compare, $value['skillId']);
                }

                //The required skills for a job will account for an additional 40% 
                $skillMatches = array_intersect($jobReqSkills_compare, $studentSkills_compare);
                if (sizeof($jobReqSkills_compare) != 0)
                {
                    $students[$key]["match"] += sizeof($skillMatches) / sizeof($jobReqSkills_compare) * 40;
                }


                //If you have worked a similar role before, then that accounts for an extra percentage 50% based on role similarity score
                $studentsPreviousWorkExperience = getWorkForAStudent($students[$key]["id"]);
                foreach ($studentsPreviousWorkExperience as $prev_work) {
                    similar_text($prev_work['role'], $jobInfo["title"], $perc);
                    if ((float)$perc > 50)
                    {
                        $students[$key]["match"] += (float)$perc / 100 * 50;
                    }
                }

                $students[$key]["match"] = ($students[$key]["match"] > 100) ? 100 : round($students[$key]["match"], 2);
            }
            
            uasort($students, 'comparator');
            return $students;

        } else {
            return array();
        }
    }

    function getAllStudents() {
        global $connection;
        $query = "SELECT * FROM students";
        if ($result = mysqli_query($connection, $query))
        {
            //success in retrieval
            $data = array();
            while($row = mysqli_fetch_assoc($result)) 
            {
                $data[] = $row;
            } 
            return $data;
        }
    }

    function getSkillsForAStudent($id) {
        global $connection;
        $query = sprintf("SELECT skillId from studentSkills WHERE studentId = %s", mysqli_escape_string($connection, $id));
    
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

    function getWorkForAStudent($id) {
        global $connection;
        $query = sprintf("SELECT * FROM workExperience WHERE studentId='%s'", mysqli_escape_string($connection, $id));
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

    function getProjectsForAStudent($id) {
        global $connection;
        $query = sprintf("SELECT * FROM projects WHERE studentId='%s'", mysqli_escape_string($connection, $id));
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


?>