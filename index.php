<?php
$fbconfig['appid' ] = "";
$fbconfig['secret'] = "";
$fbconfig['baseurl'] = "";
 
//User Id initially null
 
$usr=null;
 
//Check to see if facebook.php is present or not
 
try{
include_once "src/facebook.php";
include_once "src/facebook.php";
}catch(Exception $o){
error_log($o);
}
 
//Create Application instance
 
$facebook=new Facebook(array(
'appId'=>$fbconfig['appid'],
'secret'=>$fbconfig['secret'],
'cookie'=>true,));
 
//Authentication process
 
$sess=$facebook->getUser();
echo"
<html>
<head>
<link rel='stylesheet' type='text/css' href='test.css' />
<title>
Tweetbook
</title>
</head>
<body>
";
if($sess){
try{
 
//$logoutUrl=$facebook->getLogoutUrl();
/*for($i=0;$i<345;$i++)
  {
  echo"&nbsp;";
  }*/
//echo"<a id='logouturl' href='".$logoutUrl."'>Logout</a>";
//echo"<font size='10'><center><u><b>Tweetbook</b></u></center></font><br><br>";
echo"<center><img src='tweetbook_header.jpg'><br><br></center>";
 
$usr=$facebook->api('/me?fields=name,username,id');
echo"<table border=0 cellpadding=3 cellspacing=20>
<tr>
<td rowspan=5><img src='http://graph.facebook.com/".$usr['id']."/picture?type=large'></td>";
echo"<td colspan=7>Logged in as: <a href='http://facebook.com/".$usr['username']."'>".$usr['name']."</td></tr>";
 
echo"<tr>
<td colspan=5>Status Message:</td>
<td><form method='POST' action='post.php'>
<textarea name='sta' rows=3 cols=50 onkeydown='count(this.form.sta,this.form.charlen)' onkeyup='count(this.form.sta,this.form.charlen)' id='statusarea'></textarea></tr>";
 
echo"<tr>";
 
for($i=0;$i<5;$i++)
{
echo"<td></td>";
}
echo"<td><textarea name='charlen' rows=1 cols=4 readonly='readonly'>0</textarea>";
 
echo"<tr>";
 
for($i=0;$i<5;$i++)
{
echo"<td></td>";
}
echo"<td><input type='submit' value='POST'></form></td></tr>";
 
if(isset($_POST['sta']))
{
$upd=$_POST['sta'];
if($upd<=140)
{
echo"<tr><td><a href='tw_index.php'>Status Posted. Tweet?</a></td></tr>";
}
else
{
echo"<tr><td>Status greater than 140 characters. Cannot tweet</td></tr>";
}
}
 
}catch(FacebookApiException $e){
print_r($e);
}
}
else{
try{
$loginUrl = $facebook->getLoginUrl(
array(
'scope' => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown',
'redirect_uri' => $fbconfig['baseurl']
)
);
echo"<a href='$loginUrl'>Login</a>";
}catch(FacebookApiException $e){
print_r($e);
}
}
 
//Function to display the no. of characters in post
echo"
<script>
function count(field,countfield)
{
countfield.value=field.value.length;
}
</script>";
 
/*<a id='logout' href='logout.php' onclick='FB.logout(function(response) { window.location = 'logout.php' }); return false;" title='<?php echo $lang['logout']; ?>'><?php echo $lang['logout']; ?></a>*/
 
 
 
