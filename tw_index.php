<?php
if((!isset($_COOKIE['msg'])) || ($_COOKIE['msg']==null))
{
          header("Location: http://tweetbook.ntr5.com");
}
else
{

//Starting Twitter session
session_start();

echo"
<html>
<head>
<title>
Tweetbook
</title>
</head>
";

//Including the necessary library files

include_once'src/EpiCurl.php';
include_once'src/EpiOAuth.php';
include_once'src/EpiTwitter.php';
include_once'src/secret.php';

//Starting OAuth

$cons_key='';
$cons_secret='';

$twitterObj=new EpiTwitter($cons_key,$cons_secret);
$oauth_token=$_GET['oauth_token'];        //Get OAuth Token
if($oauth_token=='')
{
	$url=$twitterObj->getAuthorizationUrl();
	echo"<a href='$url'>Sign into Twitter</a>";
}
else
{
	$twitterObj->setToken($_GET['oauth_token']);
	$token=$twitterObj->getAccessToken();
	$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);	
	$_SESSION['ot']=$token->oauth_token;
	$_SESSION['ots']=$token->oauth_token_secret;
	$twitterInfo=$twitterObj->get_accountVerify_credentials();
	$twitterInfo->response;
	$username=$twitterInfo->screen_name;
	$profilepic=$twitterInfo->profile_image_url;


//Making tweet

$msg=$_COOKIE["msg"];
$twitterObj->setToken($_SESSION['ot'],$_SESSION['ots']);
$update_status=$twitterObj->post_statusesUpdate(array('status'=>$msg));
$resp=$update_status->response;
echo"<img src='".$profilepic."'>";
echo"&nbsp;&nbsp;Logged in as: ".$username;
echo"<br><br>Tweet successfully made!!!<br><br>
<b>Tweet:</b>".$msg; 
echo"<br><br><a href='http://twitter.com/#!/".$username."'>Link to Twitter Profile</a>";
}
}
