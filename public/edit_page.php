<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_pages(); ?>

<?php 
	if(!$page_name){
		redirect_to("manage_content.php");
	}
?>
<?php
	if(isset($_POST["submit"]))
	{

		$required_fields=array("menu_name", "position", "visible", "content");
		validate_has_presence($required_fields);

		$fields_with_max_lengths = array("menu_name" => 30);
  		validate_max_lengths($fields_with_max_lengths);

  		if(empty($errors))
  		{
  			$id=$page_name["id"];
		$menu_name=mysql_prep($_POST["menu_name"]);
		$position=(int)$_POST["menu_name"];
		$visible=(bool)$_POST["visible"];
		$content=mysql_prep($_POST["content"]);
  			$query="update pages set menu_name='{$menu_name}',position={$position},visible={$visible},content='{$content}' where id={$id} limit=1";
  			$result=mysqli_query($connection,$query);
  			if($result && mysqli_affected_rows($connection)>=0)
  			{
  				$_SESSION["message"]="page updated successfully!";
  				redirect_to("manage_content.php?page={$id}");
  			}
  			else
  			{
  				$_SESSION["message"]="page updation failed!!";
  			}
  		}
	}
	else
	{
		//get request
	}
?>

<?php require_once("../includes/layouts/headers.php"); ?>

<div id="main">
  <div id="navigation">
  		<?php echo navigation($subject_name,$page_name); ?>
  </div>
  <div id="page">
  	<p>ind</p>
  	<?php // $message is just a variable, doesn't use the SESSION
      if (!empty($message)) {
        echo "<div class=\"message\">" . htmlentities($message) . "</div>";
      }
    ?>
  	<?php echo form_errors($errors); ?>

  	<h2>Edit Page:<?php echo htmlentities($current_page["menu_name"]); ?></h2>
  	<form action="edit_page.php?page=<?php echo urlencode($current_page["id"]);?>" method="post" >
  	<p>Menu Name:
  	<input type="text" name="menu_name" value="<?php echo htmlentities($page_name["menu_name"]) ;?>" />
  	</p>
  	<p>Position:
  		<select name="position">
  			<?php

  				$page_set=select_pages($page_name["subject_id"]);
  				$page_count=mysqli_num_rows($page_set);
  				for($count=1;$count<=$page_count;$count++)
  				{
  					echo "<option value=\"{$count}\"";
  					if($page_name["position"] == $count)
  					{
  						echo "selected";
  					}
  					echo ">{$count}</option>";
  				} 
  			?>
  		</select>
  	</p>
  	<p>Visible:
  		<input type="radio" name="visible"  value="0" <?php if($page_name["visible"]==0){echo "checked";} ?> />No
  		&nbsp;
  		<input type="radio" name="visible" value="1" <?php if($page_name["visible"]==1){
  			echo "checked"; } ?> />
  		Yes
  	</p>
  	<p>Content:<br/>
  		<textarea name="content" rows="20" cols="80"><?php echo htmlentities($page_name["content"]); ?></textarea>
  	</p>
  	<input type="submit" value="Edit Page" name="submit" />
  	</form>
  	<br/>
  	<a href="manage_content.php?page=<?php echo urlencode($page_name["id"]); ?>" >Cancel</a>
  	&nbsp;
  	&nbsp;
  	<a href="delete_page.php?page=<?php echo urlencode($page_name["id"]); ?>" onclick="return confirm('Are You Sure?');" >Delete Page </a>
</div>
 </div>
 <?php require_once("../includes/layouts/footers.php"); ?>
