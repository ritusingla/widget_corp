<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php include("../includes/layouts/headers.php"); ?>
<?php
   find_selected_pages();
?>
    <div id="main">
      <div id="navigation">
      	<br/>
      	<a href="admin.php">&laquo; Main menu </a><br />
  			<?php echo  navigation($subject_name,$page_name);?>
  			<a href="new_subject.php">+ Add a Subject</a>
      </div>
      <div id="page">
      	<?php 
          echo message_check();
      ?>
        <?php if($subject_name) { ?> 
        <h2>Manage SUBJECT</h2>
        	MENU NAME: <?php echo  htmlentities($subject_name["menu_name"]) ; ?><br/>
        	Position:  <?php echo $subject_name["position"]; ?><br/>
        	Visible:  <?php echo $subject_name["visible"]==1 ? 'yes' : 'no'; ?><br/>
        	<a href="edit_subject.php?subject=<?php echo urlencode($subject_name["id"]); ?>">
        	Edit Subject
        </a>
          <div style="margin-top: 2em; border-top: 1px solid #000000;">
            <h3>Available pages in the subject are:</h3>
            <ul>
              <?php
                $subject_pages=select_pages($subject_name["id"]);
                while($page=mysqli_fetch_assoc($subject_pages)){
                  echo "<li>";
                  $s_page_id= urlencode($page["id"]);
                  echo "<a href=\"manage_content.php?page={$s_page_id}\">";
                  echo htmlentities($page["menu_name"]);
                  echo "</a>";
                  echo "</li>";
                }

              ?>
            </ul>
            <br/>
            + <a href="new_page.php?subject=<?php echo urlencode($subject_name["id"]); ?>">Add a new page to this subject</a>
          </div>
        <?php 
         } 
                  
         elseif($page_name) { ?>
         	<h2>Manage PAGE</h2>
        MENU NAME:<?php  echo htmlentities($page_name["menu_name"]) ; ?>
        <br/>
        Position:  <?php echo $page_name["position"]; ?><br/>
        Visible:  <?php echo $page_name["visible"]==1 ? 'yes' : 'no'; ?><br/>
        Content: <br/>
        <div class="view-content">
        	<?php echo htmlentities($page_name["content"]); ?>
        </div>
        <br/>
        <br/>
         <a href="edit_page1.php?page=<?php echo urlencode($page_name["id"]); ?>">Edit page</a> 
        <!-- <a href=" https://mail.google.com/mail/u/0/#inbox">Edit page</a> -->
        <?php 
         } 
         else
         {
         	?>
         	please select some id
         <?php  }
         ?>
    </div>
  </div>
    <!-- <?php
    //mysqli_free_result($result);
    ?> -->
      <?php require_once("../includes/footers.php"); ?>
