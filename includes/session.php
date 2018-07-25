<?php require_once("../includes/functions.php");?>
<?php session_start();
    function message_check(){
	   if(isset($_SESSION["message"])) {
             $output=" <div class=\"message\">";
             $output.= htmlentities($_SESSION["message"]); 
             $output.= "</div>";
             $_SESSION["message"]=null;
             return $output;
        }
	}
	function errors(){
	 if(isset($_SESSION["errors"])) {
         $errorrs= $_SESSION["errors"]; 
         $_SESSION["errors"]=null;
        return $errorrs;
        }
	}
    function confirm_logged_in(){
        if(!isset($_SESSION["admin_id"]))
    {
      redirect_to("login.php");
    }
    }
?>