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
			$name = $_POST["name"];
			$add = $_POST["address"];
			$ph = $_POST["phno"];
			$gender = $_POST["gender"];
			$age = $_POST["age"];
			$reason = $_POST["reason"];
			$bloodGroup = $_POST["blood_group"];
			$quantity = (float)$_POST["quantity"];
			$account_no = $_POST["account"];
			$cheque_no = $_POST["cheque"];
			$bank_name = $_POST["bank"];
			$trans_code = mt_rand(100000, 999999);
			//echo $cheque_no . "<br>";

			//Querying to check for availability
			$query = "SELECT Quantity from Quantity where BloodGroup = '$bloodGroup'";
			$temp = mysqli_query($db, $query) or die('Error connecting to table because ' . mysqli_error($db));
			$quanFloat = mysqli_fetch_assoc($temp)["Quantity"];
			//echo $bloodGroup . "<br>" . gettype($quanFloat) . "<br>";
			if($quanFloat > $quantity)
			{
				$managerID = 400000 + (mt_rand() % 2);
				$today_date = date("Y-m-d");
				//echo $today_date;
				$query_1 = "INSERT INTO Recipient(AadharNo, Name, Address, Age, ContactNumber, Sex, TransCode) VALUES($aadhar, '$name', '$add', $age, $ph, '$gender', $trans_code);";
				mysqli_query($db, $query_1) or die("Error connecting to SQL because " . mysqli_error($db));
				$recepID = 300000 + (mt_rand(1, 10) % 3);
				$query_2 = "SELECT Quantity FROM Quantity WHERE BloodGroup = '$bloodGroup';";
				$quan = mysqli_fetch_assoc(mysqli_query($db, $query_2))["Quantity"];
				$fquan = $quan - $quantity;
				$query_3 = "UPDATE Quantity SET Quantity = $fquan WHERE BloodGroup = '$bloodGroup';";
				mysqli_query($db, $query_3);
				$amt = $quantity * 500;
				$query_4 = "INSERT INTO Payment VALUES ($amt, $account_no, $cheque_no, '$bank_name', $recepID, $trans_code);";
				mysqli_query($db, $query_4) or die("Error connecting to SQL because " . mysqli_error($db));
				$query_5 = "INSERT INTO BloodInventory VALUES($trans_code, '$bloodGroup', $quantity, '$reason');";
				mysqli_query($db, $query_5);
				$query_6 = "INSERT INTO Transaction VALUES($trans_code, $recepID, '$today_date', $managerID);";
				mysqli_query($db, $query_6);
				echo "We can give the required amount of blood";
			}
			else
				echo "We're very sorry to say that the required amount of blood isn't available.";
			
		}

	?>
</body>
</html>