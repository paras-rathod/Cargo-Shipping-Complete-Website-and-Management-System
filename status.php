<?php error_reporting(E_ERROR | E_PARSE);
?>
<?php


//$Connection = mysqli_connect('localhost','theunite_neeraj', '',) or die("No Connection"); 

//$ConnectionDB = mysqli_select_db('theunite_unitedcargo',$Connection);

$query = mysqli_query("SELECT * FROM shippingdata");

if($query){
	while($row = mysql_fetch_array($query)){
		$flag[] = $row['invoiceclient'];
	}

	print(json_encode($flag));
}

mysql_close($connection);

?>
