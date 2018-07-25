<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php find_selected_pages(); ?>

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
			$visible= (int) $_POST["visible"];
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
			}
			}
	}
	else
			{
				//echo "<p>amdo</p>";
								//may be a get request!
			}
?>
<?php include("../includes/layouts/headers.php"); ?>
	<div id="main" >
		<div id="navigation">
			<?php echo navigation($subject_name,$page_name); ?>
		</div>
		<div id="page" >
			<?php echo message_check(); ?>
			<?php echo form_errors($errors); ?>

			<h2>Create Page</h2>
			<form action="new_page.php?subject=<?php echo urlencode($subject_name["id"]); ?>" method="post">
				<p>Menu Name:
					<input type="text" name="menu_name" value="" />
				</p>
				<p>Position:
					<select name="position">
					<?php
						$page_set=select_pages($subject_name["id"]);
						$page_count= mysqli_num_rows($page_set);
						for($count=1;$count<=($page_count+1);$count++)
						{
							echo "<option value=\"{$count}\">{$count}</option>";
						} 
					?>
				</select>
				</p>
				<p>Visible:
					<input type="radio" name="visible" value="0" />No
					&nbsp;
					<input type="radio" name="visible" value="1" />Yes
				</p>
				<p>Content:<br/>
					<textarea name="content" rows="20" cols="80">
					</textarea>
				</p>
				<input type="submit" name="submit" value="create Page" />
			</form>
			<br/>
			<a href="manage_content.php?subject=<?php echo urlencode($subject_name["id"]); ?>">Cancel</a>
		</div>
	</div>
	<?php 
  		if(isset($connection))
  		{
  			mysqli_close($connection);
  		}
    ?>
<?php include("../includes/layouts/footers.php"); ?>