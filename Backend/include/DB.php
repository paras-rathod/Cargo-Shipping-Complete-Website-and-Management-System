<?php error_reporting(E_ERROR | E_PARSE);
?>
<?php
//$Connection = mysql_connect('localhost','theunite_unitedcargo','') or die("No Connection"); 
$connection = mysqli_connect("localhost","root","","theunite_unitedcargo");

/*
By Red Server Host:
Wrong connection string found: Correct syntax $Connection = mysql_connect('localhost', 'mysql_user', 'mysql_password');
The password is not present in the connection line above.
*/

//$ConnectionDB = mysql_select_db('theunite_unitedcargo',$Connection);
?>
