<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php
		$subject_name=find_subject_by_id($_GET["subject"]);
        if(!$subject_name)
        {
          redirect_to("manage_content.php");
        } 
        $page_array=select_pages($subject_name["id"]);
        if(mysqli_num_rows($page_array) >0)
        {
        	$_SESSION["message"]="Can't delete subject with pages!";
        	redirect_to("manage_content.php?subject={$subject_name["id"]}");	
        }
        $id=$subject_name["id"];
        $query="DELETE from SUBJECTS where id={$id} LIMIT 1";
        $result=mysqli_query($connection,$query);
        if($result && mysqli_affected_rows($connection)==1)
        {
        	$_SESSION["message"]="Successfully Deleted!";
        	redirect_to("manage_content.php");
        }
        else
        {
        	$_SESSION["message"]="Subject Deletion failed!";
        	redirect_to("manage_content.php?subject={$id}");
        }

   ?>