<?php
require("config.php");
if(isset($_GET['login']))
{
$username=$_GET['username'];
$password=$_GET['password'];
$vtb=mysqli_query($mysqli,"select * from tbllogin where username='$username' and password='$password'");
if(mysqli_num_rows($vtb)>0)
{
session_start();
$_SESSION['usr']=$username;
header("location:user.php");
}
else
{
echo"<script>alert('invalid user')</script>";
}

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
    <link rel="stylesheet" href="in.css">
</head>
<body>

	<div class="cheader">
     <a href="login.php"><center>HOME</center></a> 
	</div>

	<!-- partial:index.partial.html -->
<form class="login">
  <input type="text" placeholder="Username" name="username"  required="1">
  <input type="password" placeholder="Password" name="password"  required="1">
  <button type="submit" name="login">Login</button>
</form>
<!-- partial -->
	
</body>

</html>