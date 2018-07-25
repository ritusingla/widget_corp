<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
	$page_name=find_page_by_id($_GET["page"]);
	if(!$page_name){
		redirect_to("manage_content.php");
	}
	$id=$page_name["id"];
	 $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
	$result=mysqli_connect($connection,$query);

	if($result && mysqli_affected_rows($connection) == 1)
	{
		$_SESSION["message"]="page deleted";
		redirect_to("manage_content.php");
	}
	else
	{
		$_SESSION["message"]="page deletion failed";
		redirect_to("manage_content.php?page={$id}");
	}
?>

