<?php 
require './vendor/autoload.php';
require_once("student_data.php");
use VFou\Search\Engine;
use VFou\Search\Tokenizers\AlphaNumericTokenizer;
use VFou\Search\Tokenizers\DateFormatTokenizer;
use VFou\Search\Tokenizers\DateSplitTokenizer;
use VFou\Search\Tokenizers\LowerCaseTokenizer;
use VFou\Search\Tokenizers\RemoveAccentsTokenizer;
use VFou\Search\Tokenizers\singleQuoteTokenizer;
use VFou\Search\Tokenizers\TrimPunctuationTokenizer;
use VFou\Search\Tokenizers\WhiteSpaceTokenizer;
$jobConfig = [
    "config" => [
        "var_dir" => $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."var",
        "index_dir" => DIRECTORY_SEPARATOR."engine".DIRECTORY_SEPARATOR."index",
        "documents_dir" => DIRECTORY_SEPARATOR."engine".DIRECTORY_SEPARATOR."documents",
        "cache_dir" => DIRECTORY_SEPARATOR."engine".DIRECTORY_SEPARATOR."cache",
        "fuzzy_cost" => 1,
        "connex" => [
            'threshold' => 0.9,
            'min' => 3,
            'max' => 10,
            'limitToken' => 20,
            'limitDocs' => 10
        ],
        "serializableObjects" => [
            DateTime::class => function($datetime) { /** @var DateTime $datetime */ return $datetime->getTimestamp(); }
        ]
    ],
    "schemas" => [
        "job" => [
            "title" => [
                "_type" => "string",
                "_indexed" => true,
                "_boost" => 10
            ],
            "requiredYear" => [
                "_type" => "text",
                "_indexed" => true,
                "_boost" => 0.5
            ],
            "requiredGpa" => [
                "_type" => "text",
                "_indexed" => true,
                "_boost" => 2
            ],
            "city" => [
                "_type" => "text",
                "_indexed" => true,
                "_filterable" => true,
                "_boost" => 6
            ],
            "state" => [
                "_type" => "text",
                "_indexed" => true,
                "_filterable" => true,
                "_boost" => 6
            ],
            "company" => [
                "_type" => "text",
                "_indexed" => true,
                "_filterable" => true,
                "_boost" => 6
            ],
            "skills" => [
                "_type" => "text",
                "_indexed" => true,
                "_filterable" => true,
                "_boost" => 6
            ]
        ]
    ],
    "types" => [
        "datetime" => [
            DateFormatTokenizer::class,
            DateSplitTokenizer::class
        ],
        "_default" => [
            LowerCaseTokenizer::class,
            WhiteSpaceTokenizer::class,
            TrimPunctuationTokenizer::class
        ]
    ]
];
function getResults($searchQuery) {
    global $jobConfig;
    $engine = new Engine($jobConfig);

    $engine->updateMultiple(getAllJobs());
    $response = $engine->search($searchQuery);
     $skills = getStudentSkills($_SESSION['state'][1]['id']);
        $work = getStudentWorkExperiences($_SESSION['state'][1]['id']);
        $skillsList = array();
        foreach ($skills as $skill) {
            $skillsList[] = $skill["skillName"];
        }
        if (sizeof($response['documents']) > 0)
        {
            //First, make matching algorithm separate for different classes
            if ($_SESSION['state'][1]['year'] == "Freshman") 
            {
                //Use skills, gpa, academic year, projects
                //meeting the gpa requirement is 20%
                foreach ($response['documents'] as $key => $job) {
                    $response['documents'][$key]["match"] = 0;
                    $requiredSkills = explode(",",$response['documents'][$key]['skills']);
                    if ((float)$_SESSION['state'][1]['gpa'] >= (float)$job['requiredGpa'])
                    {
                        $response['documents'][$key]["match"] += 20;
                    }
                    //meeting the year requirement is 20%
                    if ($job['requiredYear'] == "Freshman")
                    {
                        $response['documents'][$key]["match"] += 20;
                    }
                    $skillMatches = array_intersect($requiredSkills, $skillsList);
                    if (sizeof($skillMatches) != 0)
                    {
                        $response['documents'][$key]["match"] += sizeof($skillMatches) / sizeof($requiredSkills) * 60;
                    }
                    $response['documents'][$key]["match"] = ($response['documents'][$key]["match"] > 100) ? 100 : round($response['documents'][$key]["match"], 2);
                }
            }
            else {
                //Use skills, gpa, academic year, projects and work experience
                foreach ($response['documents'] as $key => $job) {
                    
                    $response['documents'][$key]["match"] = 0;
                    $requiredSkills = explode(",",$response['documents'][$key]['skills']);

                    //meeting the gpa requirement is 10%

                    if ((float)$_SESSION['state'][1]['gpa'] >= (float)$job['requiredGpa'])
                    {
                        $response['documents'][$key]["match"] += 10;
                    }

                    //meeting the year requirement is 10%
                    if ($_SESSION['state'][1]['year'] == "Senior") {
                        $response['documents'][$key]["match"] += 10;
                    } else if ($_SESSION['state'][1]['year'] == "Junior" && ($job['requiredYear'] == "Freshman" || $job['requiredYear'] == "Sophomore" || $job['requiredYear'] == "Junior")) {
                        $response['documents'][$key]["match"] += 10;
                    } else if ($_SESSION['state'][1]['year'] == "Sophomore" && ($job['requiredYear'] == "Freshman" || $job['requiredYear'] == "Sophomore")) {
                        $response['documents'][$key]["match"] += 10;
                    }
                    //The required skills for a job will account for an additional 40% 
                    $skillMatches = array_intersect($requiredSkills, $skillsList);
                    if (sizeof($skillMatches) != 0)
                    {
                        $response['documents'][$key]["match"] += sizeof($skillMatches) / sizeof($requiredSkills) * 40;
                    }

                    //If you have worked a similar role before, then that accounts for an extra percentage 50% based on role similarity score
                    foreach ($work as $prev_work) {
                        similar_text($prev_work['role'], $response['documents'][$key]["title"],$perc);
                        if ((float)$perc > 50)
                        {
                            $response['documents'][$key]["match"] += (float)$perc / 100 * 50;
                        }
                    }

                    $response['documents'][$key]["match"] = ($response['documents'][$key]["match"] > 100) ? 100 : round($response['documents'][$key]["match"], 2);
                }
            }
        }
    return $response;
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
            $row['type'] = "job";
            $data[] = $row;
        } 
        return $data;
    }
}
?>