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
	<title>Job Finder | Home</title>
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
	<style type="text/css">
		

		body {
			background: #584359;
			background: -webkit-linear-gradient(top left, #584359, #716EB2);
			background: -moz-linear-gradient(top left, #584359, #716EB2);
			background: linear-gradient(to bottom right, #584359, #716EB2);
			font-family: 'Josefin Sans', sans-serif;
			padding-bottom: 100px;
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
		.login {
			display: none;
		}

		h1 {
			text-align: center;
			color: #fff;
		}

		.sign_in, .register_here {
			color: #72d8ff;
			cursor: pointer;
		}

		p {
			text-align: center;
			color: #fff;
		}

		.pure-g [class*=pure-u] {
			font-family: 'Josefin Sans', sans-serif;
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


		label {
			padding-bottom: 2px;
			padding-top: 5px;
			color: white;
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
		    	<h1 class="heading">JOB <span style="color: #60a8d4">FINDER</span></h1><br>
		    </div>
			<div class="register pure-u-1-1">
				<h1>Register As A Student</h1>
				<?php
				if(isset($_SESSION['state']) && $_SESSION['state'][0] == "register_failure")
				{
					echo "<p>" . $_SESSION['state'][1] . "</p>";
					unset($_SESSION['state']);
				}
				?>
				<form class="reg_form pure-form pure-form-stacked" action="student_registration_endpoint.php" method="post">
					<input type="hidden" name="action" value="register">
				    <fieldset>
				    	<label for="first_name">First Name</label>
				        <input required type="text" name="first_name" id="first_name" class="pure-input-1-2" placeholder="First Name" />
				    	<label for="first_name">Last Name</label>
				        <input required type="text" name="last_name" id="last_name" class="pure-input-1-2" placeholder="Last Name" />
				        <label for="email">Your Bio</label>
				        <textarea name="bio" id="bio" class="pure-input-1-2" placeholder="Describe yourself in a few sentences"></textarea>
				        <label for="email">Your Student Email</label>
				        <input required type="email" name="email" id="email" class="pure-input-1-2" placeholder="Email" />
				        <label for="academic_year">Academic Year</label>
				        <select name="academic_year" id="academic_year" class="pure-input-1-2">
				        	<option>Freshman</option>
				        	<option>Sophomore</option>
				        	<option>Junior</option>
				        	<option>Senior</option>
				        </select>
				        <label for="password">Gpa</label>
				        <input required type="text" name="gpa" id="gpa" class="pure-input-1-2" placeholder="3.0" />
						<label for="password">Password</label>
				        <input required type="password" name="password" id="password" class="pure-input-1-2" placeholder="Password" />
				        <input  required type="password" name="confirm_password" id="confirm_password" class="pure-input-1-2" placeholder="Confirm Password" />

				    </fieldset>
				    <button type="button" class="send_form pure-button pure-input-1-2 pure-button-primary">Register</button>
				    <p>Already a member? <span class="sign_in">Sign In</span></p>
				</form>
			</div>
			<div class="login pure-u-1-1">
				<h1>Student Login</h1>
				<?php
				if(isset($_SESSION['state']) && $_SESSION['state'][0] == "login_failure")
				{
					echo "<p style='color: #f14545'>" . $_SESSION['state'][1] . "</p>";
				}
				else if(isset($_SESSION['state']) && $_SESSION['state'][0] == "register_success")
				{
					echo "<p style='color: #45f15a'>" . $_SESSION['state'][1] . "</p>";
				}
				?>
				<form class="log_form pure-form pure-form-stacked" action="student_login_endpoint.php" method="post">
					<input type="hidden" name="action" value="login">
				    <fieldset class="pure-group">
				        <input type="email" name="email" class="pure-input-1-2" placeholder="Email" />

				        <input type="password" name="password" class="pure-input-1-2" placeholder="Password" />
				    </fieldset>
				    <button type="submit" class="pure-button pure-input-1-2 pure-button-primary">Login</button>
				    <p>New? <span class="register_here">Register Here</span></p>
				</form>
			</div>
		</div>
	</div>
	
</div>
<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
<script type="text/javascript">
	$(document).ready(function() {
		<?php 
			if (isset($_SESSION['state']) && ($_SESSION['state'][0] == "register_success" || $_SESSION['state'][0]  == "login_failure"))
			{?>
				$('.register').hide().promise().done(function() {
					$('.login').show();
				})
			<?php unset($_SESSION['state']);}


		?>

	})
	$('.sign_in').click(function() {
		$('.register').fadeOut('fast').promise().done(function() {
			$('.login').fadeIn('fast');
		})
	})

	$('.register_here').click(function() {
		$('.login').fadeOut('fast').promise().done(function() {
			$('.register').fadeIn('fast');
		})
	})

	$('.send_form').click(function() {
		// if ($())
		console.log();
		if ($('#first_name').val() == "")
		{
			alert("Enter a valid first name");
		}
		else if ($('#last_name').val() == "")
		{
			alert("Enter a valid last name");
		}
		else if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('#email').val())))
		{
			alert("Enter a valid email");
		}
		else if($('#bio').val() == "")
		{
			alert("Enter a valid bio")
		}
		else if(!(!isNaN(parseFloat($('#gpa').val())) && parseFloat($('#gpa').val()) >= 1.0 && parseFloat($('#gpa').val()) <= 4.0))
		{
			alert("Enter a valid gpa");
		}
		else if ($('#password').val() == "")
		{
			alert("Enter a valid password")
		}
		else if ($('#password').val() != $('#confirm_password').val())
		{
			alert("Passwords must match")
		}
		else {
			$('.reg_form').submit();
		}
	})
</script>
</body>
</html>