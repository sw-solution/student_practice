<?php 
    require_once("job_data.php");
	if (!isset($_GET['id']) || !isset($_GET['company']))
	{
		header("Location: /student_home.php");
	}
	//Retrieve job info
	$jobInfo = getJobInformation($_GET['id'])[0];
	$skills = getRequiredSkills($_GET['id']);
?>
<html>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">
	<title>Login and Registration</title>
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
	<style type="text/css">
		

		body {
			background: #584359;
			background: -webkit-linear-gradient(top left, #584359, #716EB2);
			background: -moz-linear-gradient(top left, #584359, #716EB2);
			background: linear-gradient(to bottom right, #584359, #716EB2);
			font-family: 'Josefin Sans', sans-serif;
		}

		.content_parent {
			display: flex;
			justify-content: center;
			margin: 0 auto;
			margin-top: 150px;
			margin-bottom: 150px;
			text-align: center;
			background-color: white;
			width: 80%;
			padding: 30px;
		}
		.pure-form .pure-input-1-2 {
		    width: 100%;
		}
		.pure-menu-item {
			height: auto;
		}

		.job_description {
			text-align: left;
		}

		.pure-menu-link {
			color: white;
		}

		.pure-menu-active>.pure-menu-link, .pure-menu-link:focus, .pure-menu-link:hover {
			background-color: #41384e !important;
		}

		.submit {
			background-color: #41384e;
			color: white;
			border: none;
			font-family: 'Josefin Sans', sans-serif;
			padding: 15px;
    		width: 160px;
    		cursor: pointer;
		}


	</style>
</head>
<body>
	<nav>
		<div class="pure-menu pure-menu-horizontal">
		    <a href="#" class="pure-menu-heading pure-menu-link">Job Finder</a>
		    <ul class="pure-menu-list">
		        <li class="pure-menu-item">
		            <a href="/" class="pure-menu-link">Students</a>
		        </li>
		        <li class="pure-menu-item">
		            <a href="/employer_login.php" class="pure-menu-link">Employers</a>
		        </li>
		        <li class="pure-menu-item">
		            <a href="/ie_staff_login.php" class="pure-menu-link">IE Staff</a>
		        </li>
		    </ul>
		</div>
	</nav>
	<div class="content_parent">
		<div class="pure-g" style="width: 100%;">
			<div class="pure-u-1-6">
		    	<h1 style="color: #9587bf; font-family: 'Josefin Sans', sans-serif; font-size: 40px;"><?php if (isset($_GET['match'])) {echo $_GET['match'] . "%";} else if($_SESSION['state'][0] == "employer_logged_in") {
		    		echo "<a href='match_finder_tool.php?id=".$_GET['id']."'><button style='    font-size: 18px;
    background-color: #675d8e;
    border: none;
    color: white;
    padding: 15px; cursor: pointer'>Find Employee Matches</button></a>";
		    	} ?></h1>
			</div>
			<div class="pure-u-2-3">
		    	<h1 style="font-family: 'Josefin Sans', sans-serif; font-size: 40px;"><?php echo $jobInfo['title']; ?></h1>
		    	<h3 style="font-family: 'Josefin Sans', sans-serif; color: #9f7dc1"><?php echo $jobInfo['city'] .", ".$jobInfo['state']; ?></h3>
		    	<p class="job_description">
		    		<?php echo $jobInfo['description']; ?>
		    	</p>
		    	<h4 style="font-family: 'Josefin Sans', sans-serif;">APPLICANT REQUIREMENTS</h4>
		    	<div style="font-family: 'Josefin Sans', sans-serif;">
		    		<p>Minimum GPA - <?php echo $jobInfo['requiredGpa']; ?></p>
		    		<p>Student Year - <?php echo $jobInfo['requiredYear']; ?></p>
		    		<p>Skill Requirements</p>
		    		<?php foreach ($skills as $skill) {
		    			echo "<p style='color: #6b639c'>".$skill['skillName']."</p>";
		    		} ?>
		    	</div>
		    	<?php if($_SESSION['state'][0] != "employer_logged_in") { ?>
			    	<div class="submit_parent">
			    		<a href="/insert_application.php?jobId=<?php echo $jobInfo['id']; ?>">
			    			<button class="submit">APPLY</button>
			    		</a>
			    	</div>
			    <?php } ?>
			</div>
			<div class="pure-u-1-6">
				<p style="font-size: 40px;"><?php echo $_GET['company']; ?></p>
			</div>
		</div>
	</div>
	
</div>
<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
<script type="text/javascript">
</script>
</body>
</html>