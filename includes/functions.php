<?php
function redirect_to($new_location)
{
	header("Location: " . $new_location);
	exit;
}

function mysql_prep($string){
	global $connection;
	$escaped_string=mysqli_real_escape_string($connection,$string);
	return $escaped_string;
}

function form_errors($errorss=array())
	{
		$output="";
		if(!empty($errorss))
		{
			$output.= "<div class=\"error\">";
			$output.="please fix following errors:";
			$output.="<ul>";
			foreach ($errorss as $key => $value) {
				$output.="<li>";
				$output.=htmlentities($value) ;
				$output.= "</li>";
			}
			$output .= "</ul>";
			$output .= "</div>";
		}
		return $output;
	}

function confirm_query($result){
	if(!$result)
		{
			die("Database Connection Failed");
		}
}
function select_subjects($public=false){
	global $connection;
	$query="select * from subjects";
	if($public){
	    $query.=" where visible=1";
	}
	$query.=" order by position asc";
		$subject_result=mysqli_query($connection,$query);
		confirm_query($subject_result); 
		return $subject_result;
}
function select_pages($page_id,$public=true){
	global $connection;
	$safe_page_id=mysqli_real_escape_string($connection,$page_id);
	if($public){
		$query="select * from pages where visible=1 and subject_id ={$safe_page_id} order by position asc";
	}
	else
		$query="select * from pages where subject_id ={$safe_page_id} order by position asc";
		$page_result=mysqli_query($connection,$query);
		confirm_query($page_result); 
		return $page_result;
}

function find_subject_by_id($subject_id){
	global $connection;
	$safe_subject_id=mysqli_real_escape_string($connection,$subject_id);
	$query="select * from subjects where id={$safe_subject_id} LIMIT 1";
		$subject_result=mysqli_query($connection,$query);
		confirm_query($subject_result); 
		$subject=mysqli_fetch_assoc($subject_result);
		return $subject;
}

function find_page_by_id($page_id){
	global $connection;
	$safe_page_id=mysqli_real_escape_string($connection,$page_id);
	$query="select * from pages where id={$safe_page_id} LIMIT 1";
		$page_result=mysqli_query($connection,$query);
		confirm_query($page_result); 
		if($page = mysqli_fetch_assoc($page_result)) {
			return $page;
		} else {
			return null;
		}
}

function get_default_page($subject_id){
	$page_set=select_pages($subject_id);
	if($first_page=mysqli_fetch_assoc($page_set))
	{
		return $first_page;
	}
	else
	{
		return null;
	}
}

function find_all_admins(){
	global $connection;

	$query="select * from admins order by username asc";
	$admin_set=mysqli_query($connection,$query);
	confirm_query($admin_set);
	return $admin_set;
}

function find_selected_pages()
{
	global $subject_name;
	global $page_name;
	if(isset($_GET["subject"]))
   {
   	$subject_name=find_subject_by_id($_GET["subject"]);
   	$page_name=get_default_page($subject_name["id"]);
   	return $subject_name;
   } 
   elseif (isset($_GET["page"]))
   {
   	$page_name=find_page_by_id($_GET["page"]);
   	$subject_name=null;
   	return $page_name;
   }
   else
   {
   	$subject_name=null;
   	$page_name=null;
   	return null;
   }
}

 function admin_by_id($admin_id) {
    global $connection;
    
    $safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
    
    $query  = "SELECT * ";
    $query .= "FROM admins ";
    $query .= "WHERE id = {$safe_admin_id} ";
    $query .= "LIMIT 1";
    $admin_set = mysqli_query($connection, $query);
    confirm_query($admin_set);
    if($admin = mysqli_fetch_assoc($admin_set)) {
      return $admin;
    } else {
      return null;
    }
  }

function find_admin_by_username($username){
	global $connection;
	$safe_username=mysqli_real_escape_string($connection,$username);
	$query="select * from admins where username='{$safe_username}' limit 1";
	$result=mysqli_query($connection,$query);
	confirm_query($result);
	if($admin=mysqli_fetch_assoc($result))
	{
		return $admin;
	}
	else
	{
		return null;
	}
}

function password_match($password,$database_password){
	$check_password=sha1($password);
	if($check_password===$database_password)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function login_attempt($username,$password){
	$admin=find_admin_by_username($username);
	if($admin)
	{
		if(password_match($password,$admin["hashed_password"]))
		{
			return $admin;
		}
		else
		{
			return null;
		}
	}
	else
	{
		return null;
	}
}

function navigation($subject,$page,$public=false){
	      $output="<ul class=\"subjects\">";
		$subject_result=select_subjects($public); 
		while($row=mysqli_fetch_assoc($subject_result))
		{
			$output.= "<li";
				if($row["id"]==$subject["id"]){
					$output.= " class=\"selected\" ";
				}
				$output.= ">"; 
			$output.="<a href=\"manage_content.php?subject=";
			 $output.= urlencode($row["id"]); 
			 $output.="\">";
				
				   $output.= htmlentities($row["menu_name"]) ;
				   $output.="</a>";
		$page_result=select_pages($row["id"],$public);
		$output.="<ul class=\"pages\">";
			while($row1=mysqli_fetch_assoc($page_result)){
				$output.= "<li";
				if($row1["id"]==$page["id"]){
					$output.= " class=\"selected\" ";
				}
				$output.= ">"; 
			$output.="<a href=\"manage_content.php?page=";
			 $output.= urlencode($row1["id"]); 
			 $output.="\">";
			 $output.= htmlentities($row1["menu_name"])  ;
			$output.="</a></li>";
					}
		$output.="</ul>";
	$output.="</li>";
		}
$output.="</ul>";
return $output;
}

function public_navigation($subject_array,$page_array,$public=true){
	$output="<ul class=\"subjects\">";
	$subject_set=select_subjects($public);
	while($subject=mysqli_fetch_assoc($subject_set))
	{
		$output.="<li";
		if($subject_array && $subject["id"]==$subject_array["id"])
		{
			$output.="class=\"selected\"";
		}
		$output.=">";
		$output.="<a href=\"index.php?subject=";
		$output .= urlencode($subject["id"]);
		$output.="\"> ";
		$output .= htmlentities($subject["menu_name"]);
		$output.="</a>";

		if($subject_array["id"]==$subject["id"] || $page_array["subject_id"]==$subject["id"])
		{
			$page_set=select_pages($subject["id"],$public);
			$output.="<ul class=\"pages\">";
			while($page=mysqli_fetch_assoc($page_set))
			{
				$output.="<li";
				if($page_array && $page["id"]==$page_array["id"])
				{
					$output.="class=\"selected\" ";
				}
				$output.=">";
				$output.="<a href=\"index.php?page= ";
				$output.=urlencode($page["id"]);
				$output.="\">";
				$output.=htmlentities($page["menu_name"]);
				$output.="</a></li>";
			}
			$output.="</ul>";
			mysqli_free_result($page_set);
		}
		$output.="</li>";//of subject
	}
    mysqli_free_result($subject_set);
    $output.="</ul>";
    return $output;
}

?>