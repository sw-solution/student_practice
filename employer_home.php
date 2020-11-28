<?php
require_once("employer_data.php");
if (isset($_SESSION['state']))
 	{
 		if ($_SESSION['state'][0] == "ie_staff_logged_in"){
 			header("Location: ie_staff_home.php");
 		} else if ($_SESSION['state'][0] == "student_logged_in") {
 			header("Location: /student_home.php");
 		}
 	}
if(!isset($_SESSION['state']))
{
	header("Location: /");
}	
$jobs = getJobsForEmployer();
$skills = getAllSkills();
?>
<html>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">
	<title>Company Profile</title>
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

		.createNewJob, .updateRatings {
		    width: 20%;
		    padding-top: 15px;
		    padding-bottom: 15px;
		    color: white;
		    border: none;
		    background-color: #60a8d4;
		    margin-right: 40px;
		    margin-top: 40px;
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

		.unselected_option_parent {
			cursor: pointer;
		}

		.skill_option_selected {
			background-color: #413c6b !important;
		    border: none !important;
		    border-radius: 0 !important;
		    box-shadow: 0 0 black !important;
		    text-align: center !important;
		    cursor: pointer !important;
		    color: white !important;
		    width: 100% !important;
		}

		.openJob {
			background-color: #7f70af;
			margin-bottom: 10px;
		}

		.openJobDelete, .viewJob {
			background-color: rebeccapurple;
    		color: white;
    		border: none;
			width: 40%;
			padding-top:5px;
			padding-bottom: 5px;
		}

		.viewJob {
			cursor: pointer;
		}
		
	</style>
</head>
<body>
	<div style="position: fixed;">
		<div style="position: absolute; width: 12vw; top: 200; z-index: 5; background-color: #5d90af; padding-top: 20px; padding-bottom: 20px;">
			<div>
				<p id="main" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Main</p>
				<p id="newJob" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Create A New Job</p>
				<p id="manageJobs" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Manage Your Jobs</p>
			</div>
		</div>
	</div>
	<nav>
		<div class="pure-menu pure-menu-horizontal">
		    <a href="/" class="pure-menu-heading pure-menu-link">Job Finder</a>
		    <ul class="pure-menu-list">
		        <li class="pure-menu-item">
		            <a href="/match_finder_tool.php" class="pure-menu-link">Find Employees</a>
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
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading"><?php echo $_SESSION['state'][1]['firstName']; ?> <span style="color: #60a8d4"><?php echo $_SESSION['state'][1]['lastName']; ?></span></h1><br>
		    	<h3 class="sub"><?php echo $_SESSION['state'][1]['company']; ?></h3><br>
		    	<h3 class="sub"><?php echo $_SESSION['state'][1]['corporateEmail']; ?></h3><br>
		    </div>
		</div>
	</div>

	<div class="sectionSpace" id="new_job">
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Create A New Job</h1><br>
			</div>
			<div class="pure-u-1-1">
				<?php if (isset($_SESSION['jobState']) && $_SESSION['jobState'][0] == "addition_failure")
						{
							echo "<p class='failure_message'>".$_SESSION['jobState'][1]."</p>";
						}
				?>
			</div>
			<div class="pure-u-1-1">
		    	<form method="post" action="new_job_endpoint.php" class="pure-form" style="text-align: center; width: 50%; margin: 0 auto;">
				    <fieldset style="margin-right: 40px;">
				    	<input required class="pure-input-1-2" type="text" name="title" placeholder="Job Title">
				    </fieldset>
				    <fieldset style="margin-right: 40px;">
				    	<input required class="pure-input-1-2" type="text" name="city" placeholder="Location, City">
				    	<input required class="pure-input-1-2" type="text" name="state" placeholder="Location, State">
				    </fieldset>
				    <fieldset style="margin-right: 40px;">
				    	<textarea required class="pure-input-1-2" type="text" name="description" placeholder="Job Description"></textarea>
				    </fieldset>
			        <fieldset style="margin-right: 40px;">
			        	<input required class="pure-input-1-2" type="text" name="minimum_gpa" placeholder="Minimum Gpa">
			        </fieldset>
			        <fieldset style="margin-right: 40px;">
				     	<label for="aligned-class">Academic Class</label><br><br>
			            <select name="academic_class">
			            	<option value="Freshman">Freshman</option>
			            	<option value="Sophomore">Sophomore</option>
			            	<option value="Junior">Junior</option>
			            	<option value="Senior">Senior</option>
			            </select>
			        </fieldset>
			        <fieldset style="margin-right: 40px;">
				     	<label for="aligned-class">Required Skills</label><br><br>
			        	<div class="pure-u-1-1">
			        		<div style="background: #413c6b; height: 300px; overflow-y: scroll" class="pure-u-5-12 unselected_skills_holder">
			        			<?php 
			        				foreach ($skills as $skill) {
			        					echo '<div class="unselected_option_parent">
			        				<p class="skill_option_unselected">'.$skill["skillName"].'</p>
			        			</div>';
			        				}
			        			?>
			        		</div>
			        		<div class="pure-u-1-12">
			        		</div>
			        		<div style="background: #413c6b; height: 300px; overflow-y: scroll" class="pure-u-5-12 selected_skills_holder">
			        		</div>
			        	</div>
			        </fieldset>
				    <button type="submit" class="createNewJob"> Create </button>
		    	</form>
		    </div>
		</div>
	</div>

	<div class="sectionSpace" id="manage_jobs">
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Open Jobs</h1><br>
		    	<?php if (isset($_SESSION['jobState']) && (
					$_SESSION['jobState'][0] == "addition_success" ||
					$_SESSION['jobState'][0] == "deletion_success"

				))
						{
							echo "<p class='success_message'>".$_SESSION['jobState'][1]."</p>";
						} 
						else if (isset($_SESSION['projectState']) && (
							$_SESSION['jobState'][0] == "addition_failure" ||
							$_SESSION['jobState'][0] == "deletion_failure"
						))
						{
							echo "<p class='failure_message'>".$_SESSION['jobState'][1]."</p>";

						}
				?>
			</div>
			<div class="pure-u-1-1">
		    	<?php 
		    	if (sizeof($jobs) == 0)
		    	{
		    		echo "<p style='color: white; text-align: center'>No jobs are currently open</p>";
		    	}
		    	foreach ($jobs as $job) {
		    		echo '<div class="openJob">
						<div class="pure-g">
				    		<div class="pure-u-1-2">
				    			<h2>
				    				'.$job["title"].'
				    			</h2>
				    			<p>
				    				'.$job["description"].'
				    			</p>
				    			<p>
				    				'.$job["city"].", ".$job["state"].'
				    			</p>
				   			</div>
				   			<div class="pure-u-1-2">
				    			<p>
				    				Required Year: '.$job["requiredYear"].'
				    			</p>
				    			<p>
				    				Required Gpa: '.$job["requiredGpa"].'
				    			</p>
				    			<p>	
				    					<a href="job_page.php?id='.$job["id"].'&company='.$_SESSION['state'][1]['company'].'">
					    					<button type="submit" class="viewJob">
							    				View
							    			</button>
						    			</a>
					    			<form style="text-align: center" method="post" action="delete_job.php">
					    				<input hidden name="delete_id" value="'.$job["id"].'">
					    				<button type="submit" class="openJobDelete">
						    				Delete
						    			</button>
						    		</form>
				    			</p>
				   			</div>
				   		</div>
			    	</div>';
		    	} ?>
		    </div>
		</div>
	</div>


</div>

<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
<script src="node_modules/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
<script type="text/javascript">
	<?php
		if (isset($_SESSION['error_status']) && $_SESSION['error_status'][0] == "job_creation")
		{ ?>
			alert("<?php echo $_SESSION['error_status'][1]; ?>")
		<?php 
		unset($_SESSION['error_status']);
		}

	 ?>

	 <?php if (isset($_SESSION['jobState']) && 
		(
			$_SESSION['jobState'][0] == "deletion_success" ||
			$_SESSION['jobState'][0] == "deletion_failure" || $_SESSION['jobState'][0] == "addition_success" || 
			$_SESSION['jobState'][0] == "addition_failure" 
		))
			{
				echo 'var elmnt = document.getElementById("manage_jobs");
		elmnt.scrollIntoView();';
			} 
			unset($_SESSION['jobState']);
	?>

	$('#main').click(function() {
		var element = document.getElementById('main_info')
		element.scrollIntoView();
	});

	$('#newJob').click(function() {
		var element = document.getElementById('new_job')
		element.scrollIntoView();
	});

	$('#manageJobs').click(function() {
		var element = document.getElementById('manage_jobs')
		element.scrollIntoView();
	});

	$('body').on('click','.skill_option_unselected', function() {
		//Pop this item out of the unselected box
		$(this).parent().remove();
		$('.selected_skills_holder').append('<div class="selected_skills_parent"><input class="skill_option_selected" readonly type="text" name="skills[]" value="'+ $(this).text() +'"></div>')
	});
	$('body').on('click', '.selected_skills_parent', function() {
		//Pop this item out of the unselected box
		$(this).remove();
		$('.unselected_skills_holder').append('<div class="unselected_option_parent"><p class="skill_option_unselected">'+ $(this).children('.skill_option_selected').val() +'</p></div>')
	});
</script>
</body>
</html>