<?php include("../includes/functions.php"); ?>
<?php include("../includes/db_connection.php"); ?>
<?php include("../includes/session.php"); ?>
<?php include("../includes/validation_functions.php"); ?>
<?php
	if(isset($_SESSION["admin_id"])){
		redirect_to("admin.php");
	}
 ?>
 <?php $username="";
	if(isset($_POST["submit"]))
	{
		//validations
		$required_fields=array("username","password");
		validate_has_presence($required_fields);

		if(empty($errors))
		{
			$username=$_POST["username"];
			$password=$_POST["password"];

			$admin_found=login_attempt($username,$password);
			if($admin_found)
			{
				$_SESSION["admin_id"]=$admin_found["id"];
				$_SESSION["username"]=$admin_found["username"];
				redirect_to("admin.php");
			}
			else
			{
				$_SESSION["message"]="Username/Password Not Found!!";
			}
		}
	}
	else
	{
		if(isset($_GET["logout"]) && $_GET["logout"]==1)
  {
    $_SESSION["message"]="You Are Now Logged Out!";
  }
	}
 ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/headers.php"); ?>
<div id="main">
	<div  id="navigation">
		&nbsp;
	</div>
	<div id="page">
		<?php echo message_check(); ?>
		<?php echo form_errors($errors); ?>
		<h2>Login:</h2>
		<form action="login.php" method="post">
			<p>Username:
				<input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
			</p>
			<p>Password:
             <input type="password" name="password" value="" />
			</p>
			<input type="submit" value="submit" name="submit" />
		</form>
	</div>
</div>

<?php include("../includes/layouts/footers.php"); ?>