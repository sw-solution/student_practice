<?php 

require_once("job_match_algorithm.php");
if (!isset($_SESSION['state']) || $_SESSION['state'][0] != "student_logged_in")
 	{
 		header("Location: /");
 		
 	}
	//retrieve jobs with appropriate matching data
$jobs =getJobMatches();
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
			height: 100vh;
			margin-top: 150px;
			text-align: center;
		}
		.pure-form .pure-input-1-2 {
		    width: 100%;
		}
		.pure-menu-item {
			height: auto;
		}

		.job_entry {
			/*min-height: 200px;*/
			background-color: white;
			margin-bottom: 30px;
			cursor: pointer;
		}

		.main {
			width: 70%;
		}

		.company_logo 
		{
			width: 60%;
			padding: 10px;
		}

		.job_desc {
			padding-left: 40px;
			text-align: left;
			font-family: 'Josefin Sans', sans-serif;
			font-size: 24px;
		}

		.match {
			font-size: 30px;
			font-family: 'Josefin Sans', sans-serif;
    		color: #8369e2;	
		}

		.pure-menu-link {
			color: white;
		}

		.pure-menu-active>.pure-menu-link, .pure-menu-link:focus, .pure-menu-link:hover {
			background-color: #41384e !important;
		}

		a {
			color: black;
			text-decoration: none;
		}
		a: visited {
			color: inherit !important;
		}

	</style>
</head>
<body>
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
	<div class="content_parent">
		<div class="pure-g main">
			<div class="pure-u-1-1">
		    	<h1 style="color: #9587bf; margin-bottom: 5px;">JOB FINDER TOOL</h1>
		    	<h1 style="color: #403858; margin-bottom: 60px; font-size: 18px;">HERE ARE YOUR TOP MATCHES</h1>
			</div>
			<div class="pure-u-1-1">
				<?php
					foreach ($jobs as $job) {
						echo '<div class="job_entry">
						<a href="job_page.php?match='.$job['match'].'&id='.$job['id'].'&company='.$job['company'].'">
				    		<div class="pure-g">
				    			<div class="pure-u-1-5" style="display: flex; align-items: center;justify-content: center;">
				    				<p style="font-size:30px;">'.$job['company'].'</p>
				    			</div>
				    			<div class="pure-u-3-5" style="display: flex; align-items: center;">
				    				<p class="job_desc">'.$job['title'].'- <span>'.$job['city'].', '.$job['state'].'</span></p>
				    			</div>
				    			<div class="pure-u-1-5">
				    				<p class="match">'.$job['match'].'%</p>
				    			</div>
				    		</div>
				    	</a>
		    	</div>';
					}
				 ?>
		    	
			</div>
		</div>
	</div>
	
</div>
<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
<script type="text/javascript">
</script>
</body>
</html>