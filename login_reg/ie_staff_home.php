<?php
require_once("ie_staff_data.php");

if(!isset($_SESSION['state']) || $_SESSION['state'][0] != "ie_staff_logged_in")
{
	header("Location: /");
}	
$skills = getStats()["skills"];
$applied = getStats()["applied"];
$previous = getStats()["previous"];
?>
<html>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">
	<title>Staff Profile</title>
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

		.sectionSpace {
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
			width: 90%;
		}

		.prevProjectsHolder, .currentSkillsHolder {
			max-height: 220px;
			overflow-y: scroll;
			width: 90%;
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
	<script>
		<?php
			$skillList = "";
			$skillCount = "";
			foreach ($skills as $skill) {
				$skillList .= "'" .$skill['skillName'] . "', ";
				$skillCount .= "'" .$skill['num'] . "', ";
			}
			echo "let skills = [" . $skillList . "];";
			echo "let num = [" . $skillCount . "];";
		 ?>

		 <?php
			$companyListA = "";
			$appliedCountA = "";
			foreach ($applied as $each) {
				$companyListA .= "'" .$each['company'] . "', ";
				$appliedCountA .= "'" .$each['amount'] . "', ";
			}
			echo "let companyListA = [" . $companyListA . "];";
			echo "let appliedCountA = [" . $appliedCountA . "];";
		 ?>

		 <?php
			$prevCompanies = "";
			$prevCount = "";
			foreach ($previous as $each) {
				$prevCompanies .= "'" .$each['companyName'] . "', ";
				$prevCount .= "'" .$each['amount'] . "', ";
			}
			echo "let prevCompanies = [" . $prevCompanies . "];";
			echo "let prevCount = [" . $prevCount . "];";
		 ?>
	window.onload = function () {

	//Better to construct options first and then pass it as a parameter
	points = [];
	pointsB = [];
	pointsC = [];
	for (var i = 0; i < skills.length; i++) {
		var objects = {};
		objects['label'] = skills[i];
		objects['y'] = Number(num[i]);
		points.push(objects);
	}

	for (var i = 0; i < companyListA.length; i++) {
		var objects = {};
		objects['label'] = companyListA[i];
		objects['y'] = Number(appliedCountA[i]);
		pointsB.push(objects);
	}

	for (var i = 0; i < prevCompanies.length; i++) {
		var objects = {};
		objects['label'] = prevCompanies[i];
		objects['y'] = Number(prevCount[i]);
		pointsC.push(objects);
	}

	var options = {
		theme: "dark2",
		title: {
			text: "Most Used Skills"              
		},
		data: [              
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
			dataPoints: points
		}
		]
	};

	var options2 = {
		theme: "dark2",
		title: {
			text: "Most Applied To Companies"              
		},
		data: [              
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
			dataPoints: pointsB
		}
		]
	};

	var options3 = {
		theme: "dark2",
		title: {
			text: "Most Previous Employees"              
		},
		data: [              
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
			dataPoints: pointsC
		}
		]
	};

	$("#chartContainer").CanvasJSChart(options);
	$("#chartContainer2").CanvasJSChart(options2);
	$("#chartContainer3").CanvasJSChart(options3);
	}
	</script>
</head>
<body>
	<div style="position: fixed;">
		<div style="position: absolute; width: 12vw; top: 200; z-index: 5; background-color: #5d90af; padding-top: 20px; padding-bottom: 20px;">
			<div>
				<p id="main" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Highest Skills</p>
				<p id="workExperience" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Most Applied To Companies</p>
				<p id="projects" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Most Previous Employees</p>
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
	<h1>JOB <span>FINDER</span> STATS</h1>
	<div class="sectionSpace" id="layer1">
		<div id="chartContainer" style="height: 300px; width: 40%;"></div>
	</div>

	<div class="sectionSpace" id="layer2">
		<div id="chartContainer2" style="height: 300px; width: 40%;"></div>
	</div>

	<div class="sectionSpace" id="layer3">
		<div id="chartContainer3" style="height: 300px; width: 40%;"></div>
	</div>
<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<script src="node_modules/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
<script type="text/javascript">
	<?php if (isset($_SESSION['workExperienceState']) && 
		($_SESSION['workExperienceState'][0] == "addition_success" || 
			$_SESSION['workExperienceState'][0] == "deletion_success" || 
			$_SESSION['workExperienceState'][0] == "deletion_failure" || 
			$_SESSION['workExperienceState'][0] == "addition_failure"
		))
			{
				echo 'var elmnt = document.getElementById("work_experience");
		elmnt.scrollIntoView();';
			} 
			unset($_SESSION['workExperienceState']);
	?>
	<?php if (isset($_SESSION['projectState']) && 
		($_SESSION['projectState'][0] == "addition_success" || 
			$_SESSION['projectState'][0] == "addition_failure" ||
			$_SESSION['projectState'][0] == "deletion_success" ||
			$_SESSION['projectState'][0] == "deletion_failure"
		))
			{
				echo 'var elmnt = document.getElementById("projects_");
		elmnt.scrollIntoView();';
			} 
			unset($_SESSION['projectState']);
	?>
	<?php if (isset($_SESSION['skillState']) && 
		($_SESSION['skillState'][0] == "addition_success" || 
			$_SESSION['skillState'][0] == "addition_failure" ||
			$_SESSION['skillState'][0] == "deletion_success" ||
			$_SESSION['skillState'][0] == "deletion_failure"
		))
			{
				echo 'var elmnt = document.getElementById("skills_");
		elmnt.scrollIntoView();';
			} 
			unset($_SESSION['skillState']);
	?>
	<?php if (isset($_SESSION['updateInfoState']) && ($_SESSION['updateInfoState'][0] == "update_success" || $_SESSION['updateInfoState'][0] == "update_failure"))
			{
				echo 'var elmnt = document.getElementById("edit_info");
		elmnt.scrollIntoView();';
			} 
			unset($_SESSION['updateInfoState']);
	?>

	$('.starRating').barrating({
        theme: 'fontawesome-stars'
      });
	$('#main').click(function(){
		var elmnt = document.getElementById("layer1");
		elmnt.scrollIntoView();
	})

	$('#workExperience').click(function(){
		var elmnt = document.getElementById("layer2");
		elmnt.scrollIntoView();
	})

	$('#projects').click(function(){
		var elmnt = document.getElementById("layer3");
		elmnt.scrollIntoView();
	})
</script>
</body>
</html>