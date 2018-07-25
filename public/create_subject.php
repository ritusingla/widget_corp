<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
	if(isset($_POST['submit']))
	{
		$menu_name= mysql_prep($_POST['menu_name']);
		$position=(int) $_POST['position'];
		$visible=(bool) $_POST['visible'];

		$required_fields=array("menu_name","position","visible");
		 validate_has_presence($required_fields);
		$required_max_lengths_field=array("menu_name" =>30);
		validate_max_lengths($required_max_lengths_field);
		if(!empty($errors))
		{
			$_SESSION["errors"]=$errors;
			redirect_to("new_subject.php");
		}

		$query  = "INSERT INTO subjects (";
		$query .= "  menu_name, position, visible";
		$query .= ") VALUES (";
		$query .= "  '{$menu_name}', {$position}, {$visible}";
		$query .= ")";
		$result = mysqli_query($connection, $query);
		
		if($result)
		{
			$_SESSION["message"]="subject created";
			redirect_to("manage_content.php");
		}
		else
		{
			$_SESSION["message"]="subject creation failed!";
			redirect_to("new_subject.php");
		}
	}
	else
	{
		redirect_to("new_subject.php");
	}
?> 

  <?php 
  		if(isset($connection))
  		{
  			mysqli_close($connection);
  		}
  ?>