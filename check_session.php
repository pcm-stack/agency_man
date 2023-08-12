<?php session_start(); 
	include("settings.php");
if(isset($_SESSION['LOGID']))
{
   // $username=$_SESSION['LOGID'];
	//echo "Welcome ".$username;
}
else
{
	echo "<script type='text/javascript'>";
	// echo "alert('chck_sess')";
	//echo "location.href='$web_path"."login/login.php'";
	echo "location.href='$web_path"."index.php'";
	echo "</script>";
    }
?>