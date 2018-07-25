<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_pages(); ?>

<?php
  if (!$page_name) {
    redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  $id = $page_name["id"];
  $menu_name = mysql_prep($_POST["menu_name"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);
  $required_fields = array("menu_name", "position", "visible", "content");
  validate_has_presence($required_fields);
  
  $fields_with_max_lengths = array("menu_name" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {

    $query  = "UPDATE pages SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      $_SESSION["message"] = "Page updated.";
      redirect_to("manage_content.php?page={$id}");
    } else {
      $_SESSION["message"] = "Page update failed.";
    }
  
  }
} else {
  // GET request
}
?>

<?php include("../includes/layouts/headers.php"); ?>

<div id="main">
  <div id="navigation">
    <?php echo navigation($subject_name, $page_name); ?>
  </div>
  <div id="page">
    <?php echo message_check(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Edit Page: <?php echo htmlentities($page_name["menu_name"]); ?></h2>
    <form action="edit_page1.php?page=<?php echo urlencode($page_name["id"]); ?>" method="post">
      <p>Menu name:
        <input type="text" name="menu_name" value="<?php echo htmlentities($page_name["menu_name"]); ?>" />
      </p>
      <p>Position:
        <select name="position">
        <?php
          $page_set =select_pages($page_name["subject_id"]);
          $page_count = mysqli_num_rows($page_set);
          for($count=1; $count <= $page_count; $count++) {
            echo "<option value=\"{$count}\"";
            if ($page_name["position"] == $count) {
              echo " selected";
            }
            echo ">{$count}</option>";
          }
        ?>
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" <?php if ($page_name["visible"] == 0) { echo "checked"; } ?> /> No
        &nbsp;
        <input type="radio" name="visible" value="1" <?php if ($page_name["visible"] == 1) { echo "checked"; } ?>/> Yes
      </p>
      <p>Content:<br />
        <textarea name="content" rows="20" cols="80"><?php echo htmlentities($page_name["content"]); ?></textarea>
      </p>
      <input type="submit" name="submit" value="Edit Page" />
    </form>
    <br />
    <a href="manage_content.php?page=<?php echo urlencode($page_name["id"]); ?>">Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete_page1.php?page=<?php echo urlencode($page_name["id"]); ?>" onclick="return confirm('Are you sure?');">Delete page</a>
    
  </div>
</div>

<?php include("../includes/layouts/footers.php"); ?>
