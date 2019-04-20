<?php 
include("./inc/header.inc.php");

$post = @$_POST['newpost'];
if($post != ""){
	$date_added = date("d-m-y");
	$added_by = $user; 
	$user_posted_to = $username;

$query = mysqli_query($conn, "INSERT INTO posts (body,date_added,added_by,user_posted_to) VALUES('$post','$date_added','$added_by','$user_posted_to')");

if (!$query) {
	die("QUERY ERROR");
}
else{
	$last_id = mysqli_insert_id($conn);
    echo "Posted Successfully. Last inserted ID is: " . $last_id;

}
}
else
{
	echo "Enter something to post!";
}




?>