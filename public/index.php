<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/headers.php"); ?>


<?php find_selected_pages(true); ?>

<div id="main" >
	<div id="navigation" >
		<?php echo public_navigation($subject_name,$page_name); ?>
	</div>
	<div id="page">
		<?php if ($page_name) { ?>
			<h2><?php echo htmlentities($page_name["menu_name"]); ?></h2>
			<?php echo strip_tags(nl2br($page_name["content"]),"<b><br><p><a>"); ?>
			
		<?php } else { ?>
			<p>Welcome!!</p>
		<?php }?>
	</div>
</div>

<?php include("../includes/layouts/footers.php"); ?>
