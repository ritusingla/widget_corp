<?php
	$dbhost="localhost";
	$dbuser="ritu";
	$dbvalue="ritusingla";
	$dbname="widget_corp";
	$connection=mysqli_connect($dbhost,$dbuser,$dbvalue,$dbname);
	if(mysqli_connect_errno())
	{
		die("database connection failed").
		 mysql_connect_error().
		 "(". mysql_connect_errno(). ")";
	}
?>