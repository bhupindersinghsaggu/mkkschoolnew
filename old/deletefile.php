<?php
include('Session.php'); 
if(isset($_GET['file'])){
$file=$_GET['file'];
$folder=$_GET['folder'];
$id=$_GET['id'];
if(file_exists($file))
	{	
	unlink($file);	
	}
	$_SESSION['message']= "Record has been deleted!"; 
	$_SESSION['msg_type']= "danger"; 
header("location: FrmBulkUpload.php?folder=$folder&id=$id");
}
?>

