<?php  
//	mysql_connect("localhost", "root", "root`" )or die(mysql_error());
//	mysql_select_db("ussd") or die(mysql_error());
$db = new mysqli('localhost', 'root', 'root', 'ussd');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
?>



