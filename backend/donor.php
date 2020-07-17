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
			$height = (float)$_POST["height"] / 100;
			$weight = (float)$_POST["weight"];
			$bloodGroup = $_POST["blood_group"];
			$quantity = $weight / ($height * $height * 100);

			//Inserting the aadhar number
			$query = "INSERT INTO bloodBank.AadharNo(aadhar_no) VALUES( $aadhar );";
			mysqli_query($db, $query) or die('Error querying database beacuse ' . mysqli_error($db));

			//Retrieving the donor ID
			$query = "SELECT DonorID FROM bloodBank.AadharNo WHERE aadhar_no = $aadhar;";
			$donorID = mysqli_query($db, $query) or die('Error querying database beacuse ' . mysqli_error($db));
			$donorID = mysqli_fetch_row($donorID)[0];

			//Inserting the values into all other necessary tables
			$today_date = date('Y-m-d');
			$query = "INSERT INTO bloodBank.Donor VALUES( $donorID, '$name', '$add', $ph, '$gender', $age );";
			$query_1 = "INSERT INTO bloodBank.Blood VALUES( '$bloodGroup', $quantity, $donorID, $today_date );";
			
			$query_2 = "SELECT Quantity FROM Quantity WHERE BloodGroup = '$bloodGroup';";
			$quan = mysqli_fetch_assoc(mysqli_query($db, $query_2))["Quantity"];
			$fquan = $quan + $quantity;
			$query_3 = "UPDATE Quantity SET Quantity = $fquan WHERE BloodGroup = '$bloodGroup';";
			mysqli_query($db, $query_3);
			//echo "$fquan";
			
			mysqli_query($db, $query) or die('Error querying database beacuse' . mysqli_error($db));
			mysqli_query($db, $query_1) or die('Error querying database beacuse' . mysqli_error($db));
			echo "Thank you for registering!!\nYou're given a donor ID $donorID";
		}

	?>
</body>
</html>