<?php include("./inc/header.inc.php"); ?>

<title>Friend Requests</title>
</head>
<body>

	 <nav class="navbar navbar-expand-lg navbar-dark fixed-top flex-md-nowrap p-0 shwadow">

      <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-center" style="font-size: 30px;" href="#">SOClAl</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <form class="form-inline my-2 mr-auto my-lg-0 search">
          <input class="form-control mr-sm-2 " type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
        <ul class="navbar-nav mr-5">


          <li class="nav-item active">
            <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
          </li>

          <li class="nav-item">
                <?php echo '<a class = "nav-link "href="'.$user.'" title="Profile"><span class="hidden-xs hidden-sm">Profile</span> </a>' ; ?>
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
              <a class="dropdown-item" href="account_settings.php">Accounts Settings</a>
              <a class="dropdown-item" href="friend_requests.php">Friend Requests</a>
              
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">LogOut!</a>
            </div>
          </li>

         

        </ul>
      </div>  


    </nav> 
    <div class="container">

<?php 
	$user_from ="";
	$user_to="";
	$user_friend_requests = mysqli_query($conn, "SELECT * FROM friend_requests WHERE user_to = '$user' ");
	$numrows = mysqli_num_rows($user_friend_requests);
	if ($numrows == 0) {
		echo '<h4 class="my-5 py-5" >No Friend Requests </h4>';
		exit();
	}
	else{
		while ($get_row = mysqli_fetch_assoc($user_friend_requests)) {
			$user_from = $get_row['user_from'];
			$user_to = $get_row['user_to'];
			echo "$user_from sent you a request";
			echo '

			';
		
?> 
<?php 
	if (isset($_POST['acceptrequest'.$user_from])) {
		$add_friend_check = mysqli_query($conn,"SELECT friend_array FROM users WHERE username = '$user_to'");
		$get_friend_row = mysqli_fetch_assoc($add_friend_check);
		$friend_array = $get_friend_row['friend_array'];
		$friend_array_explode = explode(",", $friend_array);
		$friend_array_count = count($friend_array_explode);
		



		$add_friend_check_friend = mysqli_query($conn,"SELECT friend_array FROM users WHERE username = '$user_from'");
		$get_friend_row_friend = mysqli_fetch_assoc($add_friend_check_friend);
		$friend_array_friend = $get_friend_row_friend['friend_array'];
		$friend_array_explode_friend = explode(",", $friend_array_friend);
		$friend_array_count_friend = count($friend_array_explode_friend);


		if ($friend_array =="") {
			$friend_array_count = 0;
		}
		if ($friend_array_friend =="") {
			$friend_array_count_friend = 0;
		}

		if ($friend_array_count== 0) {
			$add_friend_query = mysqli_query($conn, "UPDATE users SET friend_array = CONCAT(friend_array, '$user_from') WHERE username = '$user_to'");
		}
		if($friend_array_count >=1){
			$add_friend_query = mysqli_query($conn, "UPDATE users SET friend_array = CONCAT(friend_array, ',$user_from') WHERE username = '$user_to'");

		}
		if ($friend_array_count_friend== 0) {
			$add_friend_query_friend = mysqli_query($conn, "UPDATE users SET friend_array = CONCAT(friend_array, '$user_to') WHERE username = '$user_from'");
		}
		if ($friend_array_count_friend >=1) {

			$add_friend_query_friend = mysqli_query($conn, "UPDATE users SET friend_array = CONCAT(friend_array, ',$user_to') WHERE username = '$user_from'");
		}
    	
    	$delete_request_query = mysqli_query($conn,"DELETE FROM friend_requests WHERE user_from = '$user_from' AND user_to ='$user_to' ");
    	if (!$delete_request_query) {
    		echo "Query Error";
    	}


	}

	if (isset($_POST['deleterequest'.$user_from])) {
		$delete_request_query = mysqli_query($conn,"DELETE FROM friend_requests WHERE user_from = '$user_from' AND user_to ='$user_to' ");
    	if (!$delete_request_query) {
    		echo "Query Error";
    	}
    	header('location: friend_requests.php');
	}
?>

</div>
<form method="post" action="friend_requests.php">
	<input class="btn btn-outline-success" type="submit" value="Accept Request" name="acceptrequest<?php echo $user_from; ?>">
	<input class="btn btn-outline-danger" type="submit" value="Delete Request" name="deleterequest<?php echo $user_from; ?>">
</form>

<?php 
	}
	}
?>
<?php  include('./inc/footer.inc.php')?>