<?php
	$db = mysqli_connect('localhost', 'root', '', 'login_credentials') or die('Error connecting to MySql');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Query Page</title>
</head>
<body>
	<?php
		if(isset($_POST["submit"]))
		{
			$uname = $_POST["Username"];
			$password = $_POST["password"];

			//Retrieving the password
			$query = "SELECT password FROM login_credentials.login WHERE username = '$uname';";
			$db_query_password = mysqli_query($db, $query) or die('Error querying database because ' . mysqli_error($db));
			$db_password = mysqli_fetch_row($db_query_password)[0];
			
			//Checking if the password entered is right
			if($password == $db_password)
			{
				header('Location: query.html');
				exit;
			}
			else
			{
				header('Location: login.html');
				exit;
			}
		}
	?>
</body>
</html>
