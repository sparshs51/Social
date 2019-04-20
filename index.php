<?php include ("./inc/header.inc.php"); ?> 
<?php 
if(isset($_SESSION['user_login']))
{
  header("location: $user");
}
?>
<?php   //LOGIN SCRIPT
                            if(isset($_POST['user_login']) && isset($_POST["password_login"])){

                              $user_login = preg_replace('#[^A-Za-z0-9]#i', '' , $_POST["user_login"]);
                              $password_login = preg_replace('#[^A-Za-z0-9]#i', '' , $_POST["password_login"]);
                              $pass_md5 = md5($password_login);
                              $sql = mysqli_query($conn, "SELECT id FROM users WHERE username='$user_login' AND password='$pass_md5' ");
                              if(mysqli_num_rows($sql) == 1) {
                                while($row = mysqli_fetch_array($sql)){ 
                                         $id = $row["id"];      
                              }
                                 $_SESSION["id"] = $id;
                                 $_SESSION["user_login"] = $user_login;
                                 $_SESSION["password_login"] = $password_login;
                                 header("location: $user_login");
                                     exit();
                                } 
                                else {
                                echo '<center> <h3> Wrong Username/ Password Login Again </h3></center>';
                                
                              }
                            }


                          ?>  

<?php ?> 
    <title>Social</title>  
  <link rel="stylesheet" href="css/indexstyle.css">
</head>
  <body>
    <span class="all">
      <div id="tit"><a href="index.html"><h1 id="heading">Student blog</h1></a></div>
      <div id="butt">
        <button onclick="document.getElementById('id01').style.display='block'" class="log">Login </button>
        <div id="id01" class="modal">
    <!-- TO OPEN THE MODAL LOGIN-->
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close">&times;</span>
              <form class="modal-content animate" action="index.php " method="post">

                        <div class="imgcontainer">
                          <img src="images/download.png" alt="Avatar" class="avatar">
                        </div>

                        <div class="container" id="formtext">
                          <label for="uname"><b>Username</b></label>
                          <input type="text" placeholder="Enter Username" name="user_login" required>

                          <label for="psw"><b>Password</b></label>
                          <input type="password" placeholder="Enter Password" name="password_login" required>
                      
                          <button>Login</button>

                          

                          <label>
                            <input type="checkbox" checked="checked" name="remember"> Remember me
                          </label>
                        </div>

                        <div class="container" style="background-color:#e9e9e9">
                         <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn animate2">Cancel</button>
                         <span class="psw"><a href="#">Forgot password?</a></span>
                        </div>

              </form>

        </div>
        </span>
<div id="text">
<div style="color: #202835">Not a member?</div>
<div><a href="signup.php" style="font-size: 1.5em; text-decoration: none;" target="_blank">Sign up!</a></div>
</div>
</div>


<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>
<?php include("./inc/footer.inc.php"); ?>
