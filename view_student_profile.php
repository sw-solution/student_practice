<?php
require_once("student_data.php");
if(!isset($_GET['id']))
{
	header("Location: /");
}	
$workExperience = getStudentWorkExperiences($_GET['id']);
$projects = getStudentProjects($_GET['id']);
$allSkills = getAllSkills();
$studentInfo = getSpecificStudentInfo($_GET['id']);
$studentSkills = getStudentSkills($_GET['id']);
?>
<html>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">
	<title>Student Profile</title>
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="static/css/fontawesome-stars.css">
	<style type="text/css">
		html {
			scroll-behavior: smooth;
		}

		body {
			background: #584359;
			background: -webkit-linear-gradient(top left, #584359, #716EB2);
			background: -moz-linear-gradient(top left, #584359, #716EB2);
			background: linear-gradient(to bottom right, #584359, #716EB2);
			font-family: 'Josefin Sans', sans-serif;
			padding-bottom: 100px;
		}

		#main_info {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		.pure-form .pure-input-1-2 {
		    width: 100%;
		}

		.login {
			display: none;
		}

		h1 {
			text-align: center;
			color: #fff;
		}

		.sign_in, .register_here {
			color: #0078e7;
			cursor: pointer;
		}

		p, h2 {
			text-align: center;
			color: #fff;
		}

		.pure-g [class*=pure-u] {
			font-family: 'Josefin Sans', sans-serif;
		}

		.heading {
			font-size: 60px;
			text-align: center;
		}

		.sub {
			font-size: 40px;
			text-align: center;
			color: white;
		}

		.pure-menu-item {
			height: auto;
		}

		.pure-menu-link {
			color: white;
		}

		.pure-menu-active>.pure-menu-link, .pure-menu-link:focus, .pure-menu-link:hover {
			background-color: #41384e !important;
		}

		label {
			padding-bottom: 2px;
			padding-top: 5px;
			color: white;
		}

		#work_experience > .pure-g > .pure-u-1-1 {
			border-radius: 5px;
		}

		.workExperienceHeader, .prevProjectsHeader, .currentSkillsHeader, .currentRatingsHeader {
			color: #67ded9;
		}

		.pastExperience, .prevProjects, .currentSkills {
			background-color: #7f70af;
			margin-bottom: 10px;
		}

		.pastExperienceDelete {
			background-color: rebeccapurple;
    		color: white;
    		border: none;
			width: 40%;
			padding-top:5px;
			padding-bottom: 5px;
		}

		.updateStudentInfo {
			background-color: rebeccapurple;
    		color: white;
    		border: none;
			width: 14%;
			padding-top:15px;
			padding-bottom: 15px;
			margin-top: 20px;
		}

		.addWorkExperience, .updateRatings {
		    width: 40%;
		    padding-top: 5px;
		    padding-bottom: 5px;
		    color: white;
		    border: none;
		    background-color: #60a8d4;
		    margin-right: 40px;
		}

		.submitCompanyInterests {
			width: 20%;
		    padding-top: 15px;
		    padding-bottom: 15px;
		    color: white;
		    border: none;
		    background-color: #60a8d4;
		    margin-right: 40px;
		    margin-top: 20px;
		}

		.currentRatings {
			width: 40%;
		    padding-top: 5px;
		    padding-bottom: 5px;
		    color: white;
		    border: none;
		    margin-right: 40px;
		}

		.pastExperienceHolder {
			max-height: 515px;
			overflow-y: scroll;
			width: 82%;
		}

		.prevProjectsHolder, .currentSkillsHolder {
			max-height: 220px;
			overflow-y: scroll;
			width: 82%;
		}

		.currentRatingsHolder {
			max-height: 220px;
			overflow-y: scroll;
		}

		.sectionSpace {
			margin-bottom: 100px;
		}

		.interestLabel {
			font-size: 30px;
			display: block;
			margin-right: 40px;
		}

		.companyList {
			max-height: 260px;
			overflow-y: scroll;
		}

		.failure_message {
			color: #ce5d5d;
		}

		.success_message {
			color: #51d049;
		}
		
	</style>
</head>
<body>
	<div style="position: fixed;">
		<div style="position: absolute; width: 12vw; top: 200; z-index: 5; background-color: #5d90af; padding-top: 20px; padding-bottom: 20px;">
			<div>
				<p id="main" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Main</p>
				<p id="workExperience" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Work Experience</p>
				<p id="projects" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Projects</p>
				<p id="skills" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Skills</p>
			</div>
		</div>
	</div>
	<nav>
		<div class="pure-menu pure-menu-horizontal">
		    <a href="/" class="pure-menu-heading pure-menu-link">Job Finder</a>
		    <ul class="pure-menu-list">
		        <li class="pure-menu-item">
		            <a href="/job_finder_tool.php" class="pure-menu-link">Find a Job</a>
		        </li>
		        <li class="pure-menu-item">
		            <a href="/employer_login.php" class="pure-menu-link">Employers</a>
		        </li>
		        <li class="pure-menu-item">
		            <a href="/ie_staff_login.php" class="pure-menu-link">IE Staff</a>
		        </li>
		         
		    </ul>
		    <ul style="float:right" class="pure-menu-list">
		    	<li  class="pure-menu-item">
		            <a href="/student_home.php" class="pure-menu-link">Your Profile</a>
		        </li>
		        <li  class="pure-menu-item">
		            <a href="/logout.php" class="pure-menu-link">Sign Out</a>
		        </li>
		    </ul>
		    </ul>
		</div>
	</nav>

	<div class="sectionSpace" id="main_info">
		<div>
			
		</div>
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading"><?php echo $studentInfo['firstName']; ?> <span style="color: #60a8d4"><?php echo $studentInfo['lastName']; ?></span></h1><br>
		    	<h3 class="sub"><?php echo $studentInfo['studentEmail']; ?></h3><br>
		    	<h3 class="sub"><?php echo $studentInfo['year']; ?></h3><br>
		    	<h3 class="sub"><?php echo $studentInfo['gpa']; ?></h3><br>
		    </div>
		</div>
	</div>

	<div class="sectionSpace" id="work_experience">
		<div class="pure-g">

			<div class="pure-u-1-1">
		    	<h1 class="heading">Work Experience</h1><br>
			</div>
			<div class="pure-u-1-6">
		    	
		    </div>
		    <div class="pure-u-5-6">
				<div class="pastExperienceHolder">
					<?php
					if (sizeof($workExperience) == 0)
					{
						echo "<div class='pure-u-1-1'><p>No Work Experience Available</p></div>";
					}
					foreach ($workExperience as $job) {
						echo '<div class="pastExperience">
						<div class="pure-g">
				    		<div class="pure-u-1-2">
				    			<h2>
				    				'.$job["companyName"].'
				    			</h2>
				    			<p>
				    				'.$job["role"].'
				    			</p>
				    			<p>
				    				'.$job["city"].", ".$job["state"].'
				    			</p>
				   			</div>
				   			<div class="pure-u-1-2">
				    			<p>
				    				Start Date: '.$job["start"].'
				    			</p>
				    			<p>
				    				End Date: '.$job["end"].'
				    			</p>
				    			<p>
					    			
				    			</p>
				   			</div>
				   		</div>
			    	</div>';

					}
					 ?>
			    </div>
		    </div>
		</div>
	</div>

	<div class="sectionSpace" id="projects_">
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Projects</h1><br>
			</div>
			<div class="pure-u-1-6">
		    	
		    </div>
		    <div class="pure-u-5-6">
				<div class="prevProjectsHolder">
					<?php
					if (sizeof($projects) == 0)
					{
						echo "<div class='pure-u-1-1'><p>No Projects Available</p></div>";
					}
					foreach ($projects as $project) {
						echo '<div class="prevProjects">
							<div class="pure-g">
					    		<div class="pure-u-1-2">
					    			<h2>
					    				'.$project["title"].'
					    			</h2>
					   			</div>
					   			<div class="pure-u-1-2">
					    			<p>
					    				'.$project["description"].'
					    			</p>
					   			</div>
					   		</div>
				    	</div>';
				    }
					 ?>
			    </div>
		    </div>
		</div>
	</div>

	<div class="sectionSpace" id="skills_">
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Skills</h1><br>
			</div>
			<div class="pure-u-1-6">
		    	
		    </div>
		    <div class="pure-u-5-6">
				<div class="currentSkillsHolder">
					<?php
					if (sizeof($studentSkills) == 0)
					{
						echo "<div class='pure-u-1-1'><p>No Skills Available</p></div>";
					}
						foreach ($studentSkills as $value) {
							echo '<div class="currentSkills">
						<div class="pure-g">
				    		<div class="pure-u-1-1">
				    			<h2>'.
				    				$value["skillName"]
				    			.'</h2>
				   			</div>
				   			
				   		</div>
			    	</div>';
						}
					 ?>
			    </div>
		    </div>
		</div>
	</div>
</div>

<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
<script src="node_modules/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
<script type="text/javascript">
	$('#main').click(function(){
		var elmnt = document.getElementById("main_info");
		elmnt.scrollIntoView();
	})

	$('#workExperience').click(function(){
		var elmnt = document.getElementById("work_experience");
		elmnt.scrollIntoView();
	})

	$('#projects').click(function(){
		var elmnt = document.getElementById("projects_");
		elmnt.scrollIntoView();
	})

	$('#skills').click(function(){
		var elmnt = document.getElementById("skills_");
		elmnt.scrollIntoView();
	})
</script>
</body>
</html>