<?php
	$con = mysqli_connect("localhost","root","","project");
	if (mysli_connect_errno()) {
		echo "Failed to connect to MySQL: ".mysqli_connect_error();
	}
?>