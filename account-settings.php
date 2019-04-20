<?php include("./inc/header.inc.php") ?>






    <title>Account Settings</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">

</head>


<body id="personal">

    <!--Header with Nav -->
    <header class="text-right" id="bru">
        <form class="text-left search" method="GET">
            <input name="q" type="text" placeholder="Search..">
        </form>


        <div class="menu-icon">
            <div class="dropdown" >
                <div class="second-icon dropdown menu-icon">
            <span class="dropdown-toggle" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <span class="hidden-xs hidden-sm" >More</span> 
            </span>
            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownSettings" id="More-settings" >
                
                <li class="new-not"><a href="account_settings.php">Settings</a></li>
                <li class="new-not"><a href="logout.php">LogOut</a></li>
            </ul>
                
            </div>
        </div>

        <div class="second-icon dropdown menu-icon">
            <span class="dropdown-toggle" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <span class="hidden-xs hidden-sm" >Notifications</span> <span class="badge">2</span>
            </span>
            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownNotification" id="notis" >
                <li class="new-not">
                    <a href="#" title="User name comment"><img src="img/user2.jpg" alt="User name" class="rounded-circle img-user-mini"> User comments your post</a>
                </li>
                <li class="new-not">
                    <a href="#" title="User name comment"><img src="img/user3.jpg" alt="User name" class="rounded-circle img-user-mini"> User comments your post</a>
                </li>
                <li>
                    <a href="#" title="User name comment"><img src="img/user4.jpg" alt="User name" class="rounded-circle img-user-mini"> User comments your post</a>
                </li>
                <li role="separator" class="divider"></li>
                <li><a href="#" title="All notifications">All Notifications</a></li>
            </ul>
        </div>
        <div class="second-icon menu-icon">
            <?php echo '<span><a href="'.$username.'" title="Profile"><span class="hidden-xs hidden-sm">'.$first_name.'</span> </a>
            </span>' ; ?>
        </div>
        <div class="second-icon menu-icon">
            <span><a href="timeline.html" title="Wall"><span class="hidden-xs hidden-sm">Wall</span></a>
            </span>
        </div>
    </header>



</div>
    <?php include("./inc/footer.inc.php"); ?>

