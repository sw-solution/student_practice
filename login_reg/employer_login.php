<?php
 require_once("new-connection.php");
 
 	if (isset($_SESSION['state']))
 	{
 		if ($_SESSION['state'][0] == "ie_staff_logged_in"){
 			header("Location: ie_staff_home.php");
 		} else if ($_SESSION['state'][0] == "student_logged_in") {
 			header("Location: /student_home.php");
 		} else if ($_SESSION['state'][0] == "employer_logged_in") {
 			header("Location: /employer_home.php");
 		}
 	}

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
			align-items: center;
			height: 100vh;
		}
		
		.pure-form .pure-input-1-2 {
		    width: 100%;
		}

		h1 {
			text-align: center;
			color: #fff;
		}

		.sign_in, .register_here {
			color: #0078e7;
			cursor: pointer;
		}

		p {
			text-align: center;
			color: #fff;
		}

		.heading {
			font-size: 60px;
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
		<div class="pure-g">
			<div class="pure-u-1-1">
		    	<h1 class="heading">Job <span style="color: #60a8d4">Finder</span></h1><br>
		    </div>
			<div class="login pure-u-1-1">
				<h1>Employer Login</h1>
				<?php
				if(isset($_SESSION['state']) && $_SESSION['state'][0] == "login_failure")
				{
					echo "<p style='color: #f14545'>" . $_SESSION['state'][1] . "</p>";
					unset($_SESSION['state']);
				}
				?>
				<form class="pure-form" action="employer_login_endpoint.php" method="post">
					<input type="hidden" name="action" value="login">
				    <fieldset class="pure-group">
				        <input type="email" name="email" class="pure-input-1-2" placeholder="Email" />
				        <input type="password" name="password" class="pure-input-1-2" placeholder="Password" />
				    </fieldset>
				    <button type="submit" class="pure-button pure-input-1-2 pure-button-primary">Login</button>
				</form>
			</div>
		</div>
	</div>
	
</div>
<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
</body>
</html>