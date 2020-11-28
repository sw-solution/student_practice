<?php
require_once("student_data.php");
require_once("interests_data.php");
if (isset($_SESSION['state']))
{
	if ($_SESSION['state'][0] == "ie_staff_logged_in"){
		header("Location: ie_staff_home.php");
	} else if ($_SESSION['state'][0] == "employer_logged_in") {
		header("Location: /employer_home.php");
	}
}

if(!isset($_SESSION['state']))
{
	header("Location: /");
}	

if(!isset($GLOBALS['classifier']))
{
	mlDataLoader();
}
$workExperience = getStudentWorkExperiences($_SESSION['state'][1]['id']);
$projects = getStudentProjects($_SESSION['state'][1]['id']);
$allSkills = getAllSkills();
$skillById = array();
$studentSkills = getStudentSkills($_SESSION['state'][1]['id']);
$studentInterests = getStudentInterests($_SESSION['state'][1]['id']);
$allAvailableCompanies = getAllCompanies();
$missingRatings = missingRatings($_SESSION['state'][1]['id']);
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

		.addWorkExperience {
		    width: 40%;
		    padding-top: 5px;
		    padding-bottom: 5px;
		    color: white;
		    border: none;
		    background-color: #60a8d4;
		    margin-right: 40px;
		}
		.updateRatings {
		    width: 20%;
		    padding-top: 15px;
		    padding-bottom: 15px;
		    color: white;
		    border: none;
		    background-color: #60a8d4;
		    margin-top: 15px;
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
</head>
<body>
	<div style="position: fixed;">
		<div style="position: absolute; width: 12vw; top: 200; z-index: 5; background-color: #5d90af; padding-top: 20px; padding-bottom: 20px;">
			<div>
				<p id="main" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Main</p>
				<p id="workExperience" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Work Experience</p>
				<p id="projects" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Projects</p>
				<p id="skills" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Skills</p>
				<p id="experienceSurveys" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Experience Surveys</p>
				<p id="positionInterests" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Company Interests</p>
				<p id="editInfo" style="cursor: pointer; padding-top: 5px; padding-bottom: 5px;">Edit Info</p>
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
		    	<li class="pure-menu-item">
		            <a href="/search_page.php" class="pure-menu-link">Search</a>
		        </li>
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
				<?php 
					if (isset($_SESSION['applicationState'])) {
						echo "<p style='font-size: 20px; color: #7bbae0;'>" .$_SESSION['applicationState'][1]. "</p>";
						unset($_SESSION['applicationState']);
					}
				?>
			</div>
			<div class="pure-u-1-1">
		    	<h1 class="heading"><?php echo $_SESSION['state'][1]['firstName']; ?> <span style="color: #60a8d4"><?php echo $_SESSION['state'][1]['lastName']; ?></span></h1><br>
		    	<h3 class="sub"><?php echo $_SESSION['state'][1]['studentEmail']; ?></h3><br>
		    	<h3 class="sub"><?php echo $_SESSION['state'][1]['year']; ?></h3><br>
		    	<h3 class="sub"><?php echo $_SESSION['state'][1]['gpa']; ?></h3><br>
		    </div>
		</div>
	</div>

	<div class="sectionSpace" id="work_experience">
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Work Experience</h1><br>
			</div>
			<div class="pure-u-1-1">
				<?php if (isset($_SESSION['workExperienceState']) && ($_SESSION['workExperienceState'][0] == "addition_success" || $_SESSION['workExperienceState'][0] == "deletion_success"))
						{
							echo "<p class='success_message'>".$_SESSION['workExperienceState'][1]."</p>";
						} 
						else if (isset($_SESSION['workExperienceState']) && ($_SESSION['workExperienceState'][0] == "addition_failure" || $_SESSION['workExperienceState'][0] == "deletion_failure"))
						{
							echo "<p class='failure_message'>".$_SESSION['workExperienceState'][1]."</p>";

						}
				?>
			</div>
			<div class="pure-u-1-6">
		    	
		    </div>
			<div class="pure-u-1-3">
				<h2 class="workExperienceHeader">Add New Work Experience</h2>
		    	<form method="post" action="/new_work_experience_endpoint.php" class="pure-form" style="text-align: center;">
		    		<fieldset style="margin-right: 40px;">
				        <input name="companyName" required  type="text" class="pure-input-1-2" placeholder="Company Name" />
				        <input name="jobRole" required type="text" class="pure-input-1-2" placeholder="Role" />
				    </fieldset>
				    <fieldset style="margin-right: 40px;">
				        <textarea required class="pure-input-1-2" name="roleDescription" placeholder="Describe your role"></textarea>
				    </fieldset>
				    <fieldset style="margin-right: 40px;">
				        <input name="jobCity" required type="text" class="pure-input-1-2" placeholder="City" />
				        <input name="jobState" required type="text" class="pure-input-1-2" placeholder="State" />
				    </fieldset>
				    <fieldset style="margin-right: 40px;">
				    	<label>
				    		Start Date
				    	</label>
				        <input name="jobStartDate"  required type="date" class="pure-input-1-2" placeholder="Start Date" />
				    </fieldset>
				    <fieldset style="margin-right: 40px;">
				        <label>
				    		End Date
				    	</label>
				        <input name="jobEndDate" required type="date" class="pure-input-1-2" placeholder="End Date" />
				    </fieldset>
				    <button type="submit" class="addWorkExperience"> Add </button>
		    	</form>
		    </div>
		    <div class="pure-u-1-2">
				<h2 class="workExperienceHeader">Past Work Experiences</h2>
				<div class="pastExperienceHolder">
					<?php

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
					    			<form style="text-align: center" method="post" action="delete_work_experience.php">
					    				<input hidden name="delete_id" value="'.$job["id"].'">
					    				<button type="submit" class="pastExperienceDelete">
						    				Delete
						    			</button>
						    		</form>
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
			<div class="pure-u-1-1">
				<?php if (isset($_SESSION['projectState']) && (
					$_SESSION['projectState'][0] == "addition_success" ||
					$_SESSION['projectState'][0] == "deletion_success"

				))
						{
							echo "<p class='success_message'>".$_SESSION['projectState'][1]."</p>";
						} 
						else if (isset($_SESSION['projectState']) && (
							$_SESSION['projectState'][0] == "addition_failure" ||
							$_SESSION['projectState'][0] == "deletion_failure"
						))
						{
							echo "<p class='failure_message'>".$_SESSION['projectState'][1]."</p>";

						}
				?>
			</div>
			<div class="pure-u-1-6">
		    	
		    </div>
			<div class="pure-u-1-3">
				<h2 class="workExperienceHeader">Add A New Project</h2>
		    	<form method="post" action="new_project_endpoint.php" class="pure-form" style="text-align: center;">
				    <fieldset style="margin-right: 40px;">
				    	<input required class="pure-input-1-2" type="text" name="projectTitle" placeholder="Title">
				        <textarea required class="pure-input-1-2" name="projectDescription" placeholder="Project description"></textarea>
				    </fieldset>
				    <button type="submit" class="addWorkExperience"> Add </button>
		    	</form>
		    </div>
		    <div class="pure-u-1-2">
				<h2 class="prevProjectsHeader">Previous Projects</h2>
				<div class="prevProjectsHolder">
					<?php
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
					    				<form method="post" action="delete_project.php">
					    					<input hidden name="delete_id" value="'.$project["id"].'">
						    				<button class="pastExperienceDelete">
							    				Delete
							    			</button>
							    		</form>
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
			<div class="pure-u-1-1">
				<?php if (isset($_SESSION['skillState']) && $_SESSION['skillState'][0] == "addition_success")
						{
							echo "<p class='success_message'>".$_SESSION['skillState'][1]."</p>";
						} 
						else if (isset($_SESSION['skillState']) && $_SESSION['skillState'][0] == "addition_failure")
						{
							echo "<p class='failure_message'>".$_SESSION['skillState'][1]."</p>";
						}
				?>
			</div>
			<div class="pure-u-1-6">
		    	
		    </div>
			<div class="pure-u-1-3">
				<h2 class="workExperienceHeader">Add A New Skill</h2>
		    	<form method="post" action="new_skill_endpoint.php" class="pure-form" style="text-align: center;">
				    <fieldset style="margin-right: 40px;">
				    	<input list="skill" class="pure-input-1-2" type="text" name="skillName" placeholder="Skill Name">
				    	<datalist id="skill">
				    		<?php 
					    		foreach ($allSkills as $key => $value) {
					    			$skillById[$value['id']] = $value['skillName'];
					    			echo "<option>".$value['skillName']."</option>";
					    		}
				    		?>
				    	</datalist>
				    </fieldset>
				    <button type="submit" class="addWorkExperience"> Add </button>
		    	</form>
		    </div>
		    <div class="pure-u-1-2">
				<h2 class="currentSkillsHeader">Current Skills</h2>
				<div class="currentSkillsHolder">
					<?php
						foreach ($studentSkills as $value) {
							echo '<div class="currentSkills">
						<div class="pure-g">
				    		<div class="pure-u-1-2">
				    			<h2>'.
				    				$value["skillName"]
				    			.'</h2>
				   			</div>
				   			<div class="pure-u-1-2">
				    			<p>
					    			<form method="post" action="delete_skill.php">
					    					<input hidden name="delete_id" value="'.$value["ssid"].'">
						    				<button class="pastExperienceDelete">
							    				Delete
							    			</button>
							    		</form>
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

	<div class="sectionSpace" id="experience_surveys">
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Rate Your Past Employers</h1><br>
			</div>
			<div class="pure-u-1-1">
				<?php if (isset($_SESSION['ratingState']) && $_SESSION['ratingState'][0] == "addition_success")
						{
							echo "<p class='success_message'>".$_SESSION['ratingState'][1]."</p>";
						} 
						else if (isset($_SESSION['ratingState']) && $_SESSION['ratingState'][0] == "addition_failure")
						{
							echo "<p class='failure_message'>".$_SESSION['ratingState'][1]."</p>";
						}
				?>
			</div>
			<div class="pure-u-1-6">
		    	
		    </div>
			<div class="pure-u-5-6">
		    	<form method="post" action="new_rating_endpoint.php" class="pure-form" style="text-align: center; width: 80%">
		    		<div class="pure-g">
							<div class="pure-u-1-3">
								<h2 class="workExperienceHeader">Company</h2>
							</div>
							<div class="pure-u-1-3">
								<h2 class="workExperienceHeader">Feedback</h2>
							</div>
							<div class="pure-u-1-3">
								<h2 class="workExperienceHeader">Ratings</h2>
							</div>
		    			</div>
		    		<div class="currentRatingsHolder">
		    			<?php 
		    				if(empty($missingRatings)) {
		    					echo "<p>You have already completed all ratings</p>";
		    				}
		    				foreach ($missingRatings as $job) {
		    					echo '<div class="pure-g">
									<div class="pure-u-1-3">
									<input hidden name="companyName[]" value="'.$job["companyName"].'">
			    						<h1>'.$job["companyName"].'</h1>
									</div>
									<div class="pure-u-1-3">
			    						<textarea name="feedback[]" style="width: 100%; margin-top: 14px;"></textarea>
									</div>
						    		<div class="pure-u-1-3">
						    			<select name="rating[]" class="starRating">
										  <option value="1">1</option>
										  <option value="2">2</option>
										  <option value="3">3</option>
										  <option value="4">4</option>
										  <option value="5">5</option>
										</select>
						   			</div>
					   			</div>';
		    				}
		    			?>
				    </div>
			    <button class="updateRatings">Submit</button>
		    	</form>
		    </div>
		</div>
	</div>

	<div class="sectionSpace" id="position_interests">
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Company Interests</h1><br>
		    	<?php if ($_SESSION['state'][1]['hasCompletedInterestSurvey'] == 0)
				{ ?>
		    	<p>What companies are you interested in working for? Let us know and we will give you suggestions on which skills to develop</p>
		    	<?php } else {?>
		    		<p>Here are your skill suggestions based on your interests</p>
		    	<?php } ?>
			</div>
			<?php if ($_SESSION['state'][1]['hasCompletedInterestSurvey'] == 0)
			{ ?>
				<form method="post" action="/new_interest_endpoint.php" style="width: 100%; text-align: center;">
					<div style="text-align: center;" class="pure-u-1-1 companyList">
						<?php 
							foreach ($allAvailableCompanies as $company) {
								echo '<label for="'.$company["company"].'" class="pure-checkbox interestLabel">
		            		<input type="checkbox" value="'.$company["company"].'" name="companies[]" id="'.$company["company"].'"/>'.ucfirst($company["company"]).'</label>';
							}
						?>
				    </div>

			    	<button class="submitCompanyInterests">Submit</button>
				</form>
			<?php } else {
				foreach ($studentInterests as $interest) {
					$interest['recommendation'] = $GLOBALS['classifier']->predict([$interest["employerId"]]);
					echo '<div class="pure-u-1-1">
						<p>'.$interest["companyName"].' - <span style="font-weight: bold;
    color: #4ebcff;">'.$skillById[(int)$interest['recommendation']].'</span></p>
					</div>';
				}
				?>
			<?php } ?>
		</div>
	</div>

	<div class="sectionSpace" id="edit_info">
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Update Your Info</h1>
		    	<div class="pure-u-1-1">
					<?php if (isset($_SESSION['updateInfoState']) && (
						$_SESSION['updateInfoState'][0] == "update_success"

					))
							{
								echo "<p class='success_message'>".$_SESSION['updateInfoState'][1]."</p>";
							} 
							else if (isset($_SESSION['updateInfoState']) && (
								$_SESSION['updateInfoState'][0] == "update_failure"
							))
							{
								echo "<p class='failure_message'>".$_SESSION['updateInfoState'][1]."</p>";

							}
					?>
				</div>
		    	<br>
				<form method="post" action="update_student_info.php" class="pure-form pure-form-aligned" style="text-align: center;">
				    <div class="pure-control-group">
			            <label for="aligned-first">First Name</label>
			            <input required name="firstName" type="text" id="aligned-first" value="<?php echo $_SESSION['state'][1]['firstName']; ?>" />
			        </div>
			        <div class="pure-control-group">
			            <label for="aligned-last">Last Name</label>
			            <input required name="lastName" type="text" id="aligned-last" value="<?php echo $_SESSION['state'][1]['lastName']; ?>" />
			        </div>
			        <div class="pure-control-group">
			            <label for="aligned-email">Student Email</label>
			            <input required name="email" type="email" id="aligned-email" value="<?php echo $_SESSION['state'][1]['studentEmail'];?>" />
			        </div>
			        <div class="pure-control-group">
			            <label for="aligned-class">Academic Class</label>
			            <select name="academic_class">
			            	<option <?php
			            		if ($_SESSION['state'][1]['year'] == "Freshman" )
			            		{
			            			echo "selected";
			            		}
			            	 ?> value="Freshman">Freshman</option>
			            	<option <?php
			            		if ($_SESSION['state'][1]['year'] == "Sophomore" )
			            		{
			            			echo "selected";
			            		}
			            	 ?> value="Sophomore">Sophomore</option>
			            	<option <?php
			            		if ($_SESSION['state'][1]['year'] == "Junior" )
			            		{
			            			echo "selected";
			            		}
			            	 ?> value="Junior">Junior</option>
			            	<option <?php
			            		if ($_SESSION['state'][1]['year'] == "Senior" )
			            		{
			            			echo "selected";
			            		}
			            	 ?> value="Senior">Senior</option>
			            </select>
			        </div>
			        <div class="pure-control-group">
			            <label for="aligned-gpa">GPA</label>
			            <input required name="gpa" type="text" id="aligned-gpa" value="<?php echo $_SESSION['state'][1]['gpa'];?>" />
			        </div>
			        <div class="pure-control-group">
				        <button class="updateStudentInfo">
		    				Update
		    			</button>
		    		</div>
				</form>
		    </div>
		</div>
	</div>

</div>

<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
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
	<?php if (isset($_SESSION['ratingState']) && 
		($_SESSION['ratingState'][0] == "addition_success" || 
			$_SESSION['ratingState'][0] == "addition_failure"
		))
			{
				echo 'var elmnt = document.getElementById("experience_surveys");
		elmnt.scrollIntoView();';
			} 
			unset($_SESSION['ratingState']);
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

	$('#experienceSurveys').click(function(){
		var elmnt = document.getElementById("experience_surveys");
		elmnt.scrollIntoView();
	})

	$('#positionInterests').click(function(){
		var elmnt = document.getElementById("position_interests");
		elmnt.scrollIntoView();
	})
	
	$('#editInfo').click(function(){
		var elmnt = document.getElementById("edit_info");
		elmnt.scrollIntoView();
	})
</script>
</body>
</html>