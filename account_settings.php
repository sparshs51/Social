<?php include("./inc/header.inc.php") ?>


<?php
if (isset($_SESSION["user_login"])) {
	$username = $_SESSION["user_login"];
	$check = mysqli_query($conn, "SELECT first_name, last_name, bio FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check)===1) {
        $get=mysqli_fetch_assoc($check);
        $first_name = strip_tags($get['first_name']);
        $last_name = strip_tags($get['last_name']);
        $bio = $get['bio'];
    }

    $sendpass = @$_POST['sendpass'];
    $oldpassword = @$_POST['oldpassword'];
    $oldpassword_md5 = md5($oldpassword);
    $newpassword1 = @$_POST['newpassword1'];
    $newpassword2 = @$_POST['newpassword2'];
    

    if ($sendpass) 
    {
    	$pass_query = mysqli_query($conn, "SELECT password FROM users WHERE username = '$username'");
        if (!$pass_query) {
            die("Query Error");
        }
        else{
		    	if (mysqli_num_rows($pass_query) >0) 
		    	{
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

    $personal_submit = @$_POST['personal_submit'];
    $new_first_name = strip_tags(@$_POST['new_first_name']);
    $new_last_name= strip_tags(@$_POST['new_last_name']);
    $new_bio = @$_POST['new_bio'];

    if ($personal_submit) {
    	$info_query = mysqli_query($conn, "UPDATE users SET first_name = '$new_first_name', last_name = '$new_last_name', bio='$new_bio' WHERE username = '$username'");
    	if (!$info_query) {
    		die("Query Error");
    	}
    	else{
    		header("location: account_settings.php");

    	}
    }


    	$check_pic= mysqli_query($conn, "SELECT profile_pic FROM users WHERE username = '$username'");
    	$get_pic_row = mysqli_fetch_assoc($check_pic);
  		$profile_pic_db = $get_pic_row['profile_pic'];
  		if ($profile_pic_db == "") {
  			$profile_pic =  "img/kid.jpg";
  		}
  		else{
  			$profile_pic = "userdata/profile_pics/".$profile_pic_db; 
  		}

	    if (@$_POST['upload_profile_pic']) {
	    	if(@$_FILES['new_profile_pic']["size"] < 104857600)   {
	    		if (  (@$_FILES['new_profile_pic']["type"] == "image/jpeg") || (@$_FILES['new_profile_pic']["type"] == "image/jpg") || (@$_FILES['new_profile_pic']["type"] == "image/png") ){
	    		
	    		$chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    		$random_dir_name = substr(str_shuffle($chars), 0, 15);
	    		mkdir("userdata/profile_pics/$random_dir_name");
	    		if (file_exists("userdata/profile_pics/$random_dir_name/".@$_FILES['new_profile_pic']['name'])) {
	    			echo @$_FILES['new_profile_pic']['name']. "Already Exits";
	    		}
	    		else{
	    			move_uploaded_file(@$_FILES['new_profile_pic']['tmp_name'], "userdata/profile_pics/$random_dir_name/".$_FILES['new_profile_pic']['name'] );
	    			$profile_pic_name=$_FILES['new_profile_pic']['name'];
	    			$profile_pic_query = mysqli_query($conn, "UPDATE users SET profile_pic = '$random_dir_name/$profile_pic_name' WHERE username = '$username'");
	    			if ($profile_pic_query) {
	    			echo "Picture Uploaded";
	    			header("location: account_settings.php");
	    			}
	    			else{
	    				echo "could not upload into DB";
	    			}

	    		}
	    	}
	    	else{
	    		echo "File too large";
	    	}
		    	}
	    	else{
	    		echo " wrong ext";
	    	}
	    
	    }


}
else{
	header("location: index.php");
}
?>






    <title>Account Settings</title>
    <link rel="stylesheet" href="css/newstyle.css" type="text/css">


</head>


<body id="personal">

<nav class="navbar navbar-expand-lg navbar-dark">
	<div class="container-fluid">
  <a class="navbar-brand" href="#">Social</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="navbarSupportedContent">
  	<form class="form-inline my-2 mr-auto ml-4 my-lg-0 search">
      <input class="form-control mr-sm-2 " type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
    <ul class="navbar-nav mr-5">


      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item">
      	<div class="second-icon menu-icon">
            <?php echo '<span><a class = "nav-link "href="'.$username.'" title="Profile"><span class="hidden-xs hidden-sm">'.$first_name.'</span> </a>
            </span>' ; ?>
        </div>
      </li>

       <li class="nav-item dropdown">
        <span class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Notifications <span class="badge">2</span>
        </span>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Not 1</a>
          <a class="dropdown-item" href="#">Not 2</a>
          <a class="dropdown-item" href="#">Not 3</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Al Notifications</a>
        </div>
      </li>


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          More
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="account_settings.php">Action Settings</a>
          
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">LogOut!</a>
        </div>
      </li>

     

    </ul>
  </div>  
  </div>

</nav>

<div class="container">
	<div class="row">
		<div><h3>Edit Password Settings</h3></div>

		<div >


			<button type="button" class="btn btn-secondary back" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Change Password</button>
			
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Change your Password!<span id="post_change_pass_info"></span></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form id="change_pass_form" action="" method="post" >
			          <div class="form-group">
			            <label for="recipient-name" class="col-form-label">Old Password</label>
			            <input type="password" class="form-control" id="old-password" name="oldpassword" required>
			          </div>
			          <div class="form-group">
			            <label for="message-text" class="col-form-label">New Password</label>
			            <input type="password" class="form-control" id="new-password-1" name="newpassword1" required>
			          </div>
			          <div class="form-group">
			            <label for="message-text" class="col-form-label">Re-enter New Password</label>
			            <input type="password" class="form-control" id="new-password-2" name="newpassword2" required>
			          </div>
				      <div class="modal-footer">
				        <input type="submit" value="Submit" class="btn back btn-secondary mx-auto" id="sendpass" name="sendpass">
				      </div>
			      	</form>
			      </div>
			     </div>
			  </div>
			</div>
		</div>

    </div>
    <div class="row">
    	<h3>Edit Profile Picture</h3>
    </div>
    <div class="row">
    	<form action="account_settings.php" method="POST" id="profile_pic_form" enctype="multipart/form-data"> 
    		<img src=<?php echo "$profile_pic"?> width="100" class="rounded-circle">
    		<input type="file" name="new_profile_pic" class="form-control">
    		<input type="submit" name="upload_profile_pic" id="upload_profile_pic" class="btn back btn-secondary mx-auto"><br>
    	</form>
    </div>
	<div class="row">
		<form id="change_personal_form" method="post" action="account_settings.php">
			<h3>Edit Personal Information</h3>
			<div class="row">
				<div class="col-md-6">
			  	<div class="form-group">
				    <label for="new_first_name">First Name</label>
				    <input type="text" class="form-control" name="new_first_name" id="new_first_name" value="<?php echo "$first_name" ?>">
				</div>
			</div>
			<div class="col-md-6">
			  	<div class="form-group">
			    	<label for="new_last_name">Last Name</label>
			    	<input type="text" class="form-control" name="new_last_name" id="new_last_name" value="<?php echo "$last_name" ?>">
			  	</div>
		  	</div>
			</div>
		  <div class="form-group">
		    <label for="new_bio">Bio</label>
		    <input type="text" class="form-control" id="bio" name="new_bio" value="<?php echo "$bio" ?>">
		  </div>
		  <input type="submit" class="btn back btn-secondary mx-auto" id="personal_submit" name="personal_submit" value="Save">
		</form>
	</div>





</div>
    <?php include("./inc/footer.inc.php"); ?>

