<?php
require_once("admin-header.php");
require_once("../include/db_info.inc.php");
require_once("../include/my_func.inc.php");
if(!(isset($_SESSION['password_setter'])|| isset($_SESSION['administrator'])  )) return;
function update_for_user($user_id){
	$sql="SELECT `user_id`,`password` FROM `users` WHERE `user_id`='".$user_id."' ";
	$result=mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_array($result);
	if ($row){
		$oldpw = $row['password'];
		if (!isOldPW($oldpw)) return False;
		$newpw = pwGen($row['password'],True);
		$sql="UPDATE `users` set `password`='$newpw' where `user_id`='$user_id' LIMIT 1";
		mysqli_query($mysqli,$sql);
		return True;
	}
	return False;
}

$sql="select user_id from `users`";
$result=mysqli_query($mysqli,$sql);
while ($row=mysqli_fetch_array($result)){
	$uid = $row['user_id'];
	echo $uid.">".update_for_user($uid)."\n";
}
unlink("update_pw.php");
?>
