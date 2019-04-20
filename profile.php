<?php include("./inc/header.inc.php"); ?>
<?php
$first_name = "Default";
        $last_name = "User";
if (isset($_GET['u'])) {
  $username = mysqli_real_escape_string($conn,$_GET['u']);

  if(ctype_alnum($username)){
    $check = mysqli_query($conn, "SELECT first_name, last_name, bio, profile_pic FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check)===1) {
        $get=mysqli_fetch_assoc($check);
        $first_name = $get['first_name'];
        $last_name = $get['last_name'];
        $bio = $get['bio'];
        
    }
    else{
        header("location: index.php");
        }
    }
  } 

  //Post

 if(isset($_POST['submit_post'])){ $post = @$_POST['newpost'];
if($post != ""){
    $date_added = date("d-m-y");
    $added_by = $user; 
    $user_posted_to = $username;

$query = mysqli_query($conn, "INSERT INTO posts (body,date_added,added_by,user_posted_to) VALUES('$post','$date_added','$added_by','$user_posted_to')");

if (!$query) {
    die("QUERY ERROR");
}
else{
}
}
}
//profile Pic
$check_pic = mysqli_query($conn,"SELECT profile_pic FROM users WHERE username='$username'");
  $get_pic_row = mysqli_fetch_assoc($check_pic);
  $profile_pic_db = $get_pic_row['profile_pic'];
        if ($profile_pic_db == "") {
            $profile_pic =  "img/kid.jpg";
        }
        else{
            $profile_pic = "userdata/profile_pics/".$profile_pic_db; 
        }

//Friend Request

        $msg="";
if (isset($_POST['addfriend'])) {

    $friend_request = @$_POST['addfriend'];

    $user_to = $username;
    $user_from =$user;
    $create_request = mysqli_query($conn, "INSERT into friend_requests (user_from, user_to) VALUES ('$user_from', '$user_to')");
    if(!$create_request){
        $msg = "Query error";
    }
    else{
        $msg = "Request Sent";
    }
}

if (isset($_POST['deleteRequest'])) {
    $delete_request =@$_POST['deleteRequest'];
    $delete_request_query = mysqli_query($conn,"DELETE FROM friend_requests WHERE user_from = '$user' AND user_to ='$username' ");
    if ($delete_request_query) {
        $msg = "Deleted Request";
    }
    else{
        $msg = "Query Error";
    }
}

?>






    <title><?php echo "$first_name"." $last_name"; ?></title>

</head>


<body id="personal">

    <!--Header with Nav -->
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


          <li class="nav-item">
            <a class="nav-link" href="home.php">Home </a>
          </li>

          <li class="nav-item active">
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

    <!--Left Sidebar with info Profile -->
    <nav class="sidebar col-md-2 d-none d-md-block bg-light">
        <div class="sidebar-sticky">
            <ul class=" flex-column container">
                <li class="nav-item text-center py-5 px-4 row">
                    <img src=<?php echo "$profile_pic";?> alt=<?php echo "$first_name"; ?> class="rounded-circle col-md-12" width = "150" height = "150">
                </li>
                <li class="nav-item text-center row">
                    <h2 class="text-center hidden-xs col-md-12"><a href="personal-profile.html" title="Profile"><?php echo "$first_name"." $last_name"; ?></a></h2>
                </li>

                <?php 
                
                if($username != $user){
                    //If friends
                    $friend_check_query = mysqli_query($conn,"SELECT friend_array FROM users WHERE username = '$user' ");
                    $friend_check_array = mysqli_fetch_assoc($friend_check_query);
                    $friend_array = $friend_check_array['friend_array'];

                    $friend_array_explode = explode(',', $friend_array);
                    for ($i=0; $i < count($friend_array_explode) ; $i++) { 
                        if ($friend_array_explode[$i] == $username) {
                            $flag =1;
                        }
                        else{
                            $flag=0;
                        }
                    }
                    if($flag==1){
                        echo '
                        <li class="nav-item row">
                        <form action="'.$username.'" method="POST" class="my-0 col-md-6">
                            <input type="submit" class="btn btn-outline-success" name="Friends" value="Friends &#10003" style="width: 100%;">
                        </form>
                        <form class="col-md-6" action="" method="POST">
                                <input type = "submit" value="Message" name="sendmessage" class="btn btn-outline-primary" style="width: 100%;">
                            </form>
                        </li>


                        ';
                    }
                    else{
                    //If not friends
                    $sel_req = mysqli_query($conn,"SELECT id from friend_requests WHERE user_from ='$user' AND user_to ='$username' ");
                    $check_reqest = mysqli_query($conn,"SELECT id FROM friend_requests WHERE user_from = '$username' AND user_to ='$user' ");
                    if (mysqli_num_rows($check_reqest) != 0) {
                        echo '  
                        <li class="nav-item row">
                            <form action="'.$username.'" method="POST" class="my-0 col-md-6">
                                <input type="submit" class="btn btn-outline-success" name="acceptrequest'.$username.'" value="Accept Request" style="width: 100%;">
                            </form>
                            <form class="col-md-6" action="" method="POST">
                                    <input type = "submit" value="Message" name="sendmessage" class="btn btn-outline-primary" style="width: 100%;">
                            </form>
                        </li>
                        ';
                    }
                    else{
                        if(mysqli_num_rows($sel_req) ==0){
                        echo '
                        <li class="nav-item row">
                            <form action="'.$username.'" method="POST" class="my-0 col-md-6">
                                <input type="submit" class="btn btn-outline-success" name="addfriend" value="Add as Friend" style="width: 100%;">

                            <p class="text-muted">'.$msg.'</p>
                            </form>
                            <form class="col-md-6" action="" method="POST">
                                    <input type = "submit" value="Message" name="sendmessage" class="btn btn-outline-primary" style="width: 100%;">
                            </form>
                        </li>
                        ';
                    }
                    else{
                        echo '
                        <li class="nav-item row">
                            <form action="'.$username.'" method="POST" class="my-0 col-md-6">
                                <input type="submit" class="btn btn-outline-danger" name="deleteRequest" value="Delete Friend Request" style="width: 100%; overflow:hidden;">
                                <p class="text-muted">'.$msg.'</p>
                            </form>
                            <form class="col-md-6" action="" method="POST">
                                <input type = "submit" value="Message" name="sendmessage" class="btn btn-outline-primary" style="width: 100%;">
                            </form>
                        </li>
                        ';
                    }
            }
        }
    }
                ?>


                <li class="nav-item"><p class="text-center user-description hidden-xs">
                        <?php echo "$bio"; ?>
                    </p>
                </li>

                <!-- <li class="nav-item">
                    Slider main container
                    <div class="swiper-container">
                        Additional required wrapper
                        <div class="swiper-wrapper">
                            Slides
                            <div class="swiper-slide">Slide 1</div>
                            <div class="swiper-slide">Slide 2</div>
                            <div class="swiper-slide">Slide 3</div>
                            ...
                        </div>
                
                        If we need navigation buttons
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                
                        <div class="swiper-scrollbar"></div>
                
                    </div>
                </li> -->
            </ul>
        </div>
        
    </nav>


    <div class="container">
        <div class="col-md-9 ml-sm-auto col-lg-10 p-4 mt-5">
        

        <!--Start Tab Content-->
        <div class="tab-content">
            

            <!-- Add Posts -->
            <div class="tab-pane active" role="tabpanel" id="posts" aria-labelledby="postsTab">
                <div id="posts-container" class="container-fluid container-posts">
                    <div class="card-post">
                        <div class="row">
                            <form id="post_form" action="<?php echo $username; ?>"  method="post" class="col-sm-12">
                                <div style="background-color: #efefef99; color: #0000048f; max-height: 30px; font-weight: bold; padding: 2px 10px; border-radius-top: 3px; max-width: 90%;"> Add a Post <span id="post_submit_info" style="float: right;"> </span></div>
                                    <textarea id="post_body" name="newpost" style="width: 90%;" rows="4"></textarea>

                                    <input type="submit" id="submit_post" name="submit_post" value="POST" style="float: right; background-color: #EEFFGG; max-width: 10%;">
                            </form>
                        </div>
                    </div>

            <!-- Tab Posts -->
            

            <?php
            $getposts = mysqli_query($conn, "SELECT * FROM posts WHERE user_posted_to = '$username' ORDER BY id DESC LIMIT 10" ) or die("Error getting posts");
            while ($row = mysqli_fetch_assoc($getposts)) {
                $id = $row['id'];
                $body = $row['body'];
                $date_added = $row['date_added'];
                $added_by = $row['added_by'];
                $poster_query = mysqli_query($conn, "SELECT first_name, last_name, profile_pic FROM users WHERE username = '$added_by'");
                $get_poster = mysqli_fetch_assoc($poster_query);
                $poster_fname = $get_poster['first_name'];
                $poster_lname = $get_poster['last_name'];
                $poster_profile_pic = "userdata/profile_pics/".$get_poster['profile_pic'];
                $user_posted_to = $row['user_posted_to'];
                echo '
                <form action= "" method = "POST" id="delete_form">
                <div class="card mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class=col-md-2>
                                <a href="'.$added_by.'" title="Profile">
                                    <img src="'.$poster_profile_pic.'" alt="User name" class="rounded-circle" width="100">
                                </a>
                                </div>
                                <div class="col-md-10 col-sm-10 ">
                                <h3 class="mb-0"><a href="'.$added_by.'" title="Profile">'.$poster_fname.' '.$poster_lname.'</a></h3>
                                <p class="text-muted mb-0" style="font-size: 1rem;"><i>'.$date_added.'</i></p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div class="col-sm-8 offset-sm-2 card-text">
                                <p>'.$body.'</p>
                            </div>
                        </div><div class="container ">
                                    &#x2764; 156 &#x1F603; 54
                            </div>
                        <div class="card-footer">
                            <div class="text-muted">View more comments</div>
                            <ul>
                                <li><b>Roli</b> Nice Work.</li>
                                <li><b>Somya</b> I am here too. &#x1F602;</li>
                            </ul>
                            <form>
                                <input type="text" class="form-control" placeholder="Add a comment">
                            </form>
                        </div>        
                    </div>
                    </form>
                
                    ';

                    
            }
            ?>
                    

                </div>
                <!-- Preloader -- >
                <div id="loading">
                    <img src="img/load.gif" alt="loader">
                </div>
            </div><!-- end Tab Posts -->

            <!--Start Tab Profile-->
            <div class="tab-pane " role="tabpanel" id="#profile" aria-labelledby="profileTab" display="block">
                <div class="container-fluid container-posts">
                    <div class="card-post">
                        <ul class="profile-data">
                            <li><b>Username:</b> User</li>
                            <li><b>Age:</b> 26</li>
                            <li><b>Hobbies:</b> trecking and cooking</li>
                            <li><b>Studies:</b> University of World</li>
                            <li><b>Job:</b> Full stack Developer</li>
                            <li><b>Description:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                        </ul>
                        <p><a href="" title="edit profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit profile</a></p>
                    </div>
                </div>
            </div><!-- end tab Profile -->

            <!-- Start Tab chat-->
            <div class="tb-apane " role="tabpanel" id="chat" aria-labelledby="chatTab">
                <div class="container-fluid container-posts">
                    <div class="card-post">
                        <div class="scrollbar-container">
                            <div class="row row-user-list">
                                <div class="col-sm-2 col-xs-3">

                                </div>
                                <div class="col-sm-7 col-xs-9">
                                    <p><b>User Name</b> <span class="badge">1</span></p>
                                    <p class="chat-time">An hour ago</p>
                                    <p>Lorem ipsum</p>
                                </div>
                                <div class="col-sm-3 hidden-xs">
                                    <p><a href="" title="Replay"><span class="badge badge-replay">Replay ></span></a></p>
                                </div>
                            </div>
                            <div class="row row-user-list">
                                <div class="col-sm-2 col-xs-3">
                                    <img src="img/user3.jpg" alt="User name" class="rounded-circle ">
                                </div>
                                <div class="col-sm-7 col-xs-9">
                                    <p><b>User Name</b></p>
                                    <p class="chat-time">Yesterday</p>
                                    <p>Lorem ipsum</p>
                                </div>
                                <div class="col-sm-3 hidden-xs">
                                    <p><a href="" title="Start chat"><span class="badge badge-message">Start chat ></span></a></p>
                                </div>
                            </div>
                            <div class="row row-user-list">
                                <div class="col-sm-2 col-xs-3">
                                    <img src="img/user4.jpg" alt="User name" class="rounded-circle  ">
                                </div>
                                <div class="col-sm-7 col-xs-9">
                                    <p><b>User Name</b></p>
                                    <p class="chat-time">2 days ago</p>
                                    <p>Lorem ipsum</p>
                                </div>
                                <div class="col-sm-3 hidden-xs">
                                    <p><a href="" title="Start chat"><span class="badge badge-message">Start chat ></span></a></p>
                                </div>
                            </div>
                            <div class="row row-user-list">
                                <div class="col-sm-2 col-xs-3">
                                    <img src="img/user5.jpg" alt="User name" class="rounded-circle">
                                </div>
                                <div class="col-sm-7 col-xs-9">
                                    <p><b>User Name</b></p>
                                    <p class="chat-time">2 days ago</p>
                                    <p>Lorem ipsum</p>
                                </div>
                                <div class="col-sm-3 hidden-xs">
                                    <p><a href="" title="Start chat"><span class="badge badge-message">Start chat ></span></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Tab chat-->

        </div><!-- Close Tab Content-->

    </div>
    </div><!--Close content posts-->

    <!-- Modal container for settings--->
    <div id="settingsmodal" class="modal fade text-center">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

</div>
    <?php include("./inc/footer.inc.php"); ?>

