<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php include("../includes/layouts/headers.php"); ?>
<?php
   find_selected_pages();
   ?>
    <div id="main">
      <div id="navigation">
  			<?php echo  navigation($subject_name,$page_name);?>
      </div>
      <div id="page">
        <?php 
          echo message_check();
      ?>
      <?php $errors=errors(); ?>
      <div id="errors">
      <?php  echo form_errors($errors);?>
    </div>
        <h2>Create Subject</h2>
    <form action="create_subject.php" method="post">
      <p>Menu name:
        <input type="text" name="menu_name" value="" />
      </p>
      <p>Position:
        <select name="position">
          <?php
          $subject_array=select_subjects();
          $subject_count=mysqli_num_rows($subject_array);
          //$subject_count=8;
            for($count=1 ; $count<=($subject_count +1) ;$count++)
            {
              echo " <option value=\"{$count}\">{$count}</option>";
            } 
          ?>
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" /> No
        &nbsp;
        <input type="radio" name="visible" value="1" /> Yes
      </p>
      <input type="submit" name="submit" value="Create Subject" />
    </form>
    <br />
    <a href="manage_content.php">Cancel</a>
    </div>
  </div>
   <!--  <?php
    mysqli_free_result($result);
    ?> -->
      <?php include("../includes/layouts/footers.php"); ?>
