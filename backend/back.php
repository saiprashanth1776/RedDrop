<?php
	 $db = mysqli_connect('localhost','root','','bloodBank') or die('Error connecting to MySQL server.');
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		if(isset($_POST["submit"]))
		{
			$aadhar = $_POST["aadhar"];
			$height = (float)$_POST["height"] / 100;
			$weight = (float)$_POST["weight"];
			$quantity = $weight / ($height * $height * 100);

			$query_1 = "SELECT DonorID FROM AadharNo WHERE aadhar_no = $aadhar;";
			$res = mysqli_query($db, $query_1) or die('Error because ' . mysqli_error($db));
			$donor_id = mysqli_fetch_row($res)[0];

			$query_4 = "SELECT Donation_Date, BloodType FROM Blood WHERE DonorID = $donor_id;";
			$res = mysqli_query($db, $query_4);
			$temp = mysqli_fetch_row($res);
			$date1 = $temp[0];
			$BloodType = $temp[1];
			$date2 = date("Y-m-d");
			//echo gettype($date1) . "<br>";
			$myDate1 = date_create($date1);
			$myDate2 = date_create($date2);
			$diff = (int)date_diff($myDate1, $myDate2, True) -> format("%a");
			if($diff <= 90)
				echo "Sorry Please come back after " . (90 - $diff) . " days";
			else
			{
				$query_2 = "UPDATE Blood SET Donation_Date = '$date2', Quantity = $quantity WHERE DonorID = $donor_id;";
				mysqli_query($db, $query_2);
				echo "Updated";
				$query_1 = "SELECT Quantity FROM Quantity WHERE BloodGroup = '$BloodType';";
				$quan = mysqli_fetch_assoc(mysqli_query($db, $query_1))["Quantity"];
				$fquan = $quan + $quantity;
				$query_3 = "UPDATE Quantity SET Quantity = $fquan WHERE BloodGroup = '$BloodType';";
				mysqli_query($db, $query_3);
			}
		}

	?>
</body>
</html>

<!-- UPDATE Payment SET TransCode = 441913 WHERE Amount = 2300 -->
<!-- UPDATE Payment SET TransCode = 631771 WHERE Amount = 2450 -->
<!-- UPDATE Payment SET TransCode = 160701 WHERE Amount = 1500 -->