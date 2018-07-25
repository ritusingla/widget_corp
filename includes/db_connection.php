<?php
	define("DB_SERVER","localhost");
	define("DB_USER","ritu");
	define("DB_VALUE","ritusingla");
	define("DB_NAME","widget_corp");
	$connection=mysqli_connect(DB_SERVER,DB_USER,DB_VALUE,DB_NAME);
	if(mysqli_connect_errno())
	{
		die("database connection failed").
		 mysql_connect_error().
		 "(". mysql_connect_errno(). ")";
	}
?>