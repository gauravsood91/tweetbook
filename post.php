<?php
if($_POST['sta']==null)
{
       header("Location: http://tweetbook.ntr5.com");
}
else
{
$upd=$_POST['sta'];
setcookie("msg",$upd,time()+30);
try{	
	include_once"index.php";
}catch(Exception $e){
	error_log($e);
}

try{

	
	$facebook->api('/me/feed','post',array(
		'message'=> $upd));
/*echo"Status Posted<br><br>";
	if(strlen($upd)<=140)
	{
		echo"<a href='http://tweetbook.ntr5.com/tw_index.php'>Status of 140 characters or less. Post as Tweet?</a>";
	}
	else
	{
		echo"Status of length greater than 140 characters. Make statuses of 140 characters or less to post as Tweet";
	}
	*/
}catch(FacebookApiException $e){
	print_r($e);
	echo"Error!!!";
}
}
?>


