<?php	
    require_once("student_data.php");

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

    function getJobMatches() {
        $jobs = getAllJobs();
        //$rquired_
        $skills = getStudentSkills($_SESSION['state'][1]['id']);
        $work = getStudentWorkExperiences($_SESSION['state'][1]['id']);
        $skillsList = array();
        foreach ($skills as $skill) {
            $skillsList[] = $skill["skillName"];
        }
        if (sizeof($jobs) > 0)
        {
            //First, make matching algorithm separate for different classes
            if ($_SESSION['state'][1]['year'] == "Freshman") 
            {
                //Use skills, gpa, academic year, projects
                //meeting the gpa requirement is 20%
                foreach ($jobs as $key => $job) {
                    $jobs[$key]["match"] = 0;
                    $requiredSkills = explode(",",$jobs[$key]['skills']);
                    if ((float)$_SESSION['state'][1]['gpa'] >= (float)$job['requiredGpa'])
                    {
                        $jobs[$key]["match"] += 20;
                    }
                    //meeting the year requirement is 20%
                    if ($job['requiredYear'] == "Freshman")
                    {
                        $jobs[$key]["match"] += 20;
                    }
                    $skillMatches = array_intersect($requiredSkills, $skillsList);
                    if (sizeof($skillMatches) != 0)
                    {
                        $jobs[$key]["match"] += sizeof($skillMatches) / sizeof($requiredSkills) * 60;
                    }
                    $jobs[$key]["match"] = ($jobs[$key]["match"] > 100) ? 100 : round($jobs[$key]["match"], 2);
                }
            }
            else {
                //Use skills, gpa, academic year, projects and work experience
                foreach ($jobs as $key => $job) {
                    
                    $jobs[$key]["match"] = 0;
                    $requiredSkills = explode(",",$jobs[$key]['skills']);

                    //meeting the gpa requirement is 10%

                    if ((float)$_SESSION['state'][1]['gpa'] >= (float)$job['requiredGpa'])
                    {
                        $jobs[$key]["match"] += 10;
                    }

                    //meeting the year requirement is 10%
                    if ($_SESSION['state'][1]['year'] == "Senior") {
                        $jobs[$key]["match"] += 10;
                    } else if ($_SESSION['state'][1]['year'] == "Junior" && ($job['requiredYear'] == "Freshman" || $job['requiredYear'] == "Sophomore" || $job['requiredYear'] == "Junior")) {
                        $jobs[$key]["match"] += 10;
                    } else if ($_SESSION['state'][1]['year'] == "Sophomore" && ($job['requiredYear'] == "Freshman" || $job['requiredYear'] == "Sophomore")) {
                        $jobs[$key]["match"] += 10;
                    }
                    //The required skills for a job will account for an additional 40% 
                    $skillMatches = array_intersect($requiredSkills, $skillsList);
                    if (sizeof($skillMatches) != 0)
                    {
                        $jobs[$key]["match"] += sizeof($skillMatches) / sizeof($requiredSkills) * 40;
                    }

                    //If you have worked a similar role before, then that accounts for an extra percentage 50% based on role similarity score
                    foreach ($work as $prev_work) {
                        similar_text($prev_work['role'], $jobs[$key]["title"],$perc);
                        if ((float)$perc > 50)
                        {
                            $jobs[$key]["match"] += (float)$perc / 100 * 50;
                        }
                    }

                    $jobs[$key]["match"] = ($jobs[$key]["match"] > 100) ? 100 : round($jobs[$key]["match"], 2);
                }
            }
            uasort($jobs, 'comparator');
            return $jobs;

        } else {
            return array();
        }
    }

    function getAllJobs() {
        global $connection;
        $query = "SELECT jobs.id as id, title, requiredYear, requiredGpa, city, state, company, GROUP_CONCAT(skillName) as skills FROM jobs INNER JOIN jobSkills ON jobSkills.jobId = jobs.id INNER JOIN skills ON jobSkills.skillId = skills.id INNER JOIN companyRecruiter ON companyRecruiter.id = companyRecruiterId GROUP BY title,description,requiredYear,requiredGpa,city,state, company, jobs.id";
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


?>