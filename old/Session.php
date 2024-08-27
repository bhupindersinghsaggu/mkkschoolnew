<?php
	   include('config.php');
	   $user_check = $_SESSION['User_Id'];
	   $ses_sql  = "select UserId,grp from tbluser where UserId = '$user_check'";
	   $r = $dbh->prepare($ses_sql);
	   $r->execute();
	   $res = $r->fetch(PDO::FETCH_ASSOC);
		$login_session = $res['UserId'];
		$login_Grp = $res['grp'];
		
		$expireAfter = 40; 
//Check to see if our "last action" session
//variable has been set.
if(isset($_SESSION['last_action'])){
    
    //Figure out how many seconds have passed
    //since the user was last active.
    $secondsInactive = time() - $_SESSION['last_action'];
    
    //Convert our minutes into seconds.
    $expireAfterSeconds = $expireAfter * 60;
    
    //Check to see if they have been inactive for too long.
    if($secondsInactive >= $expireAfterSeconds){
        //User has been inactive for too long.
        //Kill their session.
        session_unset();
        session_destroy();
    }
    
}
 
//Assign the current timestamp as the user's
//latest activity
$_SESSION['last_action'] = time();
	   if(!isset($_SESSION['User_Id'])){
		  header("location:login.php");
		  die();
	   }
	   
	   
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
