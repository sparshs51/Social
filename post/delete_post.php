<?php 
include ('./inc/header.inc.php');
?>

<?php
	$delete_post = mysqli_query($conn, "DELETE FROM posts WHERE id = '$id'");
	header("location: profile.php")
?>