<?php 
include("./inc/header.inc.php"); 
$username =  $_SESSION["user_login"];
?>


	<title><?php echo $_SESSION["user_login"]; ?> </title>
</head>
<body>
	<a href="<?php echo $username; ?>"> Profile>></a><br>
	<a href="logout.php"><button> LogOut? </button>
		<?php include("./inc/footer.inc.php") ?>

