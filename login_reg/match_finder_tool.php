<?php
	require_once('match_finder_algorithm.php');
	if (!isset($_GET['id'])) {
		header("Location: /");
	}
	$matches = getStudentMatches($_GET['id']);
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
			min-height: 100vh;
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
			font-size: 44px;
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
			text-decoration: none;
			color: inherit;
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
		<div class="pure-g main">
			<div class="pure-u-1-1">
		    	<h1 style="color: #9587bf; margin-bottom: 5px;">MATCH FINDER TOOL</h1>
		    	<h1 style="color: #403858; margin-bottom: 60px; font-size: 18px;">HERE ARE YOUR TOP MATCHES</h1>
			</div>
			<div class="pure-u-1-1">
				<?php
					foreach ($matches as $match) {
						echo '
						<a href="view_student_profile.php?id='.$match["id"].'">
						<div class="job_entry">
					    		<div class="pure-g">
					    			<div class="pure-u-1-5" style="display: flex; align-items: center;justify-content: center;">
					    				<img class="company_logo" src="/static/img/user_profile.png">
					    			</div>
					    			<div class="pure-u-3-5" style="display: flex; align-items: center;">
					    				<p class="job_desc">'.$match["firstName"]." ".$match["lastName"].' - <span>'.$match["studentEmail"].'</span></p>
					    			</div>
					    			<div class="pure-u-1-5">
					    				<p class="match">'.$match["match"].'%</p>
					    			</div>
					    		</div>
					    	</div></a>';
					}
				 ?>
		    	
			</div>
		</div>
	</div>
	<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
	<script type="text/javascript">
	</script>
</body>
</html>