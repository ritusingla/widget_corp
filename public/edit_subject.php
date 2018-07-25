<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php
   find_selected_pages();
?>

  <?php
        if(!$subject_name)
        {
          redirect_to("manage_content.php");
        } 
   ?>

<?php

  if(isset($_POST['submit']))
  {
    $required_fields=array("menu_name","position","visible");
     validate_has_presence($required_fields);
     //echo "Here";
    $required_max_lengths_field=array("menu_name" =>30);
    validate_max_lengths($required_max_lengths_field);
    if(empty($errors))
    {
      $id=$subject_name["id"];
    $menu_name= mysql_prep($_POST['menu_name']);
    $position=(int) $_POST['position'];
    $visible=(int) $_POST['visible'];
    $query="UPDATE subjects set menu_name='$menu_name' , position={$position} , visible={$visible} where id={$id} LIMIT 1 ";
    $result = mysqli_query($connection, $query);
    
    if($result && mysqli_affected_rows($connection)>=0)
    {
      $_SESSION["message"]="subject updated";
      redirect_to("manage_content.php");
    }
    else
    {
      $message="subject updation failed!";
     // redirect_to("new_subject.php");
    }
  }
}
  else
  {
    //redirect_to("new_subject.php");
  }
?> 
 
   <?php require_once("../includes/layouts/headers.php"); ?>
    <div id="main">
      <div id="navigation">
        <?php echo  navigation($subject_name,$page_name);?>
      </div>
      <div id="page">
       <?php // $message is just a variable, doesn't use the SESSION
      if (!empty($message)) {
        echo "<div class=\"message\">" . htmlentities($message) . "</div>";
      }
    ?>
      <?php echo form_errors($errors); ?>
        <h2>Edit Subject :<?php echo htmlentities($subject_name["menu_name"]) ?></h2>
    <form action="edit_subject.php?subject=<?php echo urlencode($subject_name["id"]) ?>" method="post">
      <p>Menu name:
        <input type="text" name="menu_name" value="<?php echo htmlentities($subject_name["menu_name"]) ;?>" />
      </p>
      <p>Position:
        <select name="position">
          <?php
          $subject_array=select_subjects();
          $subject_count=mysqli_num_rows($subject_array);
          //$subject_count=8;
            for($count=1 ; $count<=$subject_count ;$count++)
            {
              echo " <option value=\"{$count}\"";
              if($subject_name["position"]==$count)
              {
                echo "selected";
              }
              echo ">{$count}</option>";
            } 
          ?>
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" <?php 
        if($subject_name["visible"]==0){
          echo "checked";
        }
         ?> /> No
        &nbsp;
        <input type="radio" name="visible" value="1" <?php 
        if($subject_name["visible"]==1){
          echo "checked";
        }
         ?>/> Yes
      </p>
      <input type="submit" name="submit" value="Edit Subject" />
    </form>
    <br />
    <a href="manage_content.php">Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete_subject.php?subject=<?php echo urlencode($subject_name["id"]); ?>" onclick="return confirm('Are You Sure?');">Delete</a>
    </div>
  </div>
   <!--  <?php
   // mysqli_free_result($result);
    ?> -->
      <?php require_once("../includes/layouts/footers.php"); ?>
