<?php
session_start();
$connection = new mysqli('mydb.itap.purdue.edu', 'zqubain', 'qewqew', 'zqubain');

//make sure connection is good or die
if ($connection->connect_errno) 
{
    die("Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error);
}

?>