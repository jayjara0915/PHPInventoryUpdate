<html>
	<head>
		<meta charset="UTF-8">
		<title> Inventory </title>
	</head>
	<body style="background-color:beige;">
	<center><h1> Food-Truck Lunch Inventory </h1></center>
<?php

	$servername = "localhost";
	$username = "hcifall22";
	$password = "hcifall22";
	$dbname = "hcifall22";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error($conn));
	}
	
	mysqli_select_db($conn, $dbname);

?>

<?php
	if(isset($_POST['update'])){

		$itemdesc = $_POST['itdesc'];
		$itemcost = $_POST['itcost'];
		$itemprice = $_POST['itprice'];
		$quty = $_POST['quty'];
		
		$query = "select item_num from module5 where item_desc = '$itemdesc'";
		
		$retval = mysqli_query( $conn, $query );
		if(! $retval ) {
			die('Could not find item: ' . mysqli_error($conn));
		}
		//echo "Updated data successfully\n";
		
		if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
		if (!$row) {
			die('Item is not in table: ' . mysqli_error($conn));
		}
		$itnum = $row['item_num'];
		
		$sql = "UPDATE module5 SET item_cost = $itemcost, item_price = $itemprice, qty = qty - '$quty' WHERE item_num= $itnum";

		$retval = mysqli_query( $conn, $sql );
		if(! $retval ) {
			die('Could not update data: ' . mysqli_error($conn));
		}
		//echo "Updated data successfully\n";
		}
		else {
			$query = "INSERT INTO module5(item_desc, item_cost, item_price, qty) " .
            "values('$itemdesc', '$itemcost', '$itemprice', '$quty')";
			
			$retcontents = mysqli_query( $conn, $query );
				if(! $retcontents ) {
				die('Could not update data: ' . mysqli_error($conn));
				}
		}
		
		$rowchange = "select * from module5";
		$return = mysqli_query( $conn, $rowchange );
		if(! $return ) {
			die('Could not find item: ' . mysqli_error($conn));
		}
		echo"<h2>Updated Quantity Database Content </h2>";
		
		if ($return->num_rows > 0) {
			while($row = $return->fetch_assoc()) {
			echo "<br>Item Description: " . $row["item_desc"]. "<br/> Item Cost: " . 
			$row["item_cost"] . "<br/> Item Price: " . 
			$row["item_price"] . "<br/> Quantity: " . 
			$row["qty"] . "<br/> Created:" . $row["add_time"]. "<br/><br/>";
			}
		}
	}
	
	echo "Connected successfully";
	$conn->close();
?>

	</body>
</html>