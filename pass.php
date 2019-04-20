<?php include("./inc/header.inc.php") ?>
<?php 
$username = $_SESSION["user_login"];
    $sendpass = @$_POST['sendpass'];
    $oldpassword = @$_POST['oldpassword'];
    $oldpassword_md5 = md5($oldpassword);
    $newpassword1 = @$_POST['newpassword1'];
    $newpassword2 = @$_POST['newpassword2'];
    if ($sendpass) {
    	$pass_query = mysqli_query($conn, "SELECT password FROM users WHERE username = '$username'");
        if (!$pass_query) {
            die("Query Error");
        }
        else{
    	if (mysqli_num_rows($pass_query) >0) {
    		$row = mysqli_fetch_assoc($pass_query);
    		$db_password = $row['password']; 
    		if ($oldpassword_md5 == $db_password) {
    			if ($newpassword1 == $newpassword2) {
    				$newpassword1_md5 = md5($newpassword1);
    				$update_pass = mysqli_query($conn, "UPDATE users SET password = '$newpassword1_md5' WHERE username = '$username'");
    				echo "Password Changed";
    			}
    			else{
    				echo "New Passwords dont match";
    			}
    		}
    		else{
    			echo "Old Password incorrect";
    		}
    	}
    }
    }
    else{
    }
    ?>