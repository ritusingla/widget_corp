<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php $admin=admin_by_id($_GET["id"]);
	if(!$admin)
	{
		redirect_to("manage_admins.php");
	}
 ?>
 <?php
 	if(isset($_POST["submit"]))
 	{
 		$required_fields=array("username","password");
 		validate_has_presence($required_fields);

 		$fields_with_max_lengths=array("username"=>30);
 		validate_max_lengths($fields_with_max_lengths);

 		if(empty($errors))
 		{
 			$id=$admin["id"];
 			$username=mysql_prep($_POST["username"]);
 			$hashed_password=mysql_prep($_POST["password"]);

 			 $query  = "UPDATE admins SET ";
			 $query .= "username = '{$username}', ";
		     $query .= "hashed_password = '{$hashed_password}' ";
	    	 $query .= "WHERE id = {$id} ";
			 $query .= "LIMIT 1";
		     $result = mysqli_query($connection, $query);

		     if($result && mysqli_affected_rows($connection)==1)
		     {
		     	$_SESSION["message"]="Successfully updated!";
		     	redirect_to("manage_admins.php");
		     }
		     else
		     {
		     	$_SESSION["message"]="Admin Updation Failed!";
		     }
 		}
 	}
 	else
 	{
 		//get request
 	}
 ?>

<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/headers.php"); ?>
<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
  	<?php echo message_check(); ?>
    <?php echo form_errors($errors); ?>
    <h2>Edit Admin: <?php echo htmlentities($admin["username"]); ?></h2>
    <form action="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>" method="post" >
    	<p>Username:
    		<input type="text" name="username" value="<?php echo htmlentities($admin["username"]) ?>" />
    	</p>
    	<p>Password:
    		<input type="password" name="password" value="" />
    	</p>
    	<input type="submit" value="Edit Admin" name="submit"/>
    </form>
    <br/>
    <a href="manage_admins.php">Cancel</a>
  </div>
</div>
<?php include("../includes/layouts/footers.php"); ?>