<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
// Can't add a new page unless we have a subject as a parent!
	if(!$subject_name)
	{
		//either subject id is missing or subject not found in database
		redirect_to("manage_content.php");
	}
?>
<?php
	if(isset($_POST['submit'])){
		//form processing
		//validations!!
		$required_fields=array("menu_name","position","visible","content");
		validate_has_presence($required_fields);

		$fields_with_max_lengths= array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lengths);

		if(empty($errors)){
			//page creation and subject id should be added
			$subject_id=$subject_name["id"];
			$menu_name = mysql_prep($_POST["menu_name"]);
			$position= (int) $_POST["position"];
			$visible= (bool) $_POST["visible"];
			$content= mysql_prep($_POST["content"]);

			$query1="insert into pages(";
			$query1.=" subject_id,menu_name,position,visible,content";
			$query1.=" ) values (";
			$query1.=" {$subject_id},'{$menu_name}',{$position},{$visible},'{$content}'";
			$query1.=")";
			$result1=mysqli_query($connection,$query1);

			if($result1)
			{
				$_SESSION["message"]="Page successfully created!";
				redirect_to("manage_content.php?subject=" . urlencode($subject_name["id"]));
			}
			else
			{
				$_SESSION["message"]="Page creation failed!";
				redirect_to("new_page.php");	
			}
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