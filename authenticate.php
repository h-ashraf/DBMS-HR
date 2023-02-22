<?php
	session_start();
	$DATABASE_HOST = "localhost";
	$DATABASE_USER = "root";
	$DATABASE_PASS = "";
	$DATABASE_NAME = "project"

	//Try to connect to db using credentials
	$con = mysqli_connect($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASS,$DATABASE_NAME);
	if (mysqli_connect_errno() ){
		//if there is an error, stop and display error
		exit("Failed to connect to MySQL: ".mysql_error());
	}

	// Now check if the data from the login form was submitted, isset() will check if the data exists.
	if ( !isset($_POST['username'], $_POST['password']) ) {
		// Could not get the data that should have been sent.
		exit('Please fill both the username and password fields!');
	}

	// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	if ($stmt = $con->prepare('SELECT Emp_ID, Emp_Password FROM employee WHERE Emp_Username = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		// Store the result so we can check if the account exists in the database.
		$stmt->store_result();


		$stmt->close();

		if ($stmt -> num_rows > 0) {
			$stmt -> bind_result($id, $password);
			$stmt -> fetch();
			//acount exits, now verify password
			// Note: remember to use password_hash in your registration file to store the hashed passwords.
			if (password_verify($_POST['passowrd'], $password)) {
				// Verification success! User has logged-in!
				// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['id'] = $id;
				header('Location: home.php');

			} else {
				//Incorrect Password
				echo 'Incorrect Usename and/or Password!';
			}
		} else {
			//Incorrect Password
			echo 'Incorrect Usename and/or Password!';
		}
	}
?>