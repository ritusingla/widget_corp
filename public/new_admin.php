<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php 
    confirm_logged_in();
 ?>
<?php 
if(isset($_POST["submit"]))
{
	$required_fields = array("username", "password");
	validate_has_presence($required_fields);
	$fields_with_max_lengths=array("username" => 30);
	max_length($fields_with_max_lengths);

	if(empty($errors))
	{
		$username = mysql_prep($_POST["username"]);
        $hashed_password = sha1(mysql_prep($_POST["password"]));

        $query="insert into admins (username,hashed_password) values('{$username}','{$hashed_password}')";
        $result=mysqli_query($connection,$query);
        if($result)
        {
        	$_SESSION["message"]="Admin Created Successfully!";
        	redirect_to("manage_admins.php");
        }
        else
        {
        	$_SESSION["message"]="Admin Creation Failed!";
        }

	}

}
else
{
	//get request
}
?>
<?php $layout_context="admin" ; ?>
<?php include("../includes/layouts/headers.php"); ?>
<div id="main">
	<div id="navigation">
		 <br/> 
		 <a href="manage_admins.php">&laquo; Return to admin page.</a><br/>
		 &nbsp;
	</div>
	<div id="page">
		<?php echo message_check(); ?>
		<?php echo form_errors($errors); ?>

		<h2>Create Admin</h2>
		<form action="new_admin.php" method="post">
			<p>Username:
				<input type="text" name="username" value=""/>
			</p>
			<p>Password:
				<input type="password" name="password" value=""/>
			</p>
			<input type="submit" name="submit" value="Create Admin"/>
		</form>
		<br/>
		<a href="manage_admins.php">Cancel</a>
	</div>
</div>
<?php include("../includes/layouts/footers.php"); ?>
