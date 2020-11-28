<?php
/** File responsible for logging out **/
	require_once('new-connection.php');
	if (isset($_SESSION['state']))
	{
		unset($_SESSION['state']);
		header("Location: /");
	}
	else {
		echo "significant error";
	}
?>