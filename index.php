<!DOCTYPE html>
<html>
<head>
	<title>MySQL Table Viewer</title>
</head>
<body>
    <?php
    $sql="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = $_POST["sql"]; 
    }
    ?>
	<h1>MySQL Table Viewer</h1>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
	SQL: <textarea name="sql" rows="5" cols="40"><?php echo $sql; ?></textarea>
	<input type="submit" name="submit" value="Submit"> 
</form>
	<?php
		// Define database connection variables
		$servername = getenv("DB_URL");
		$username = getenv("DB_USER");
		$password = getenv("DB_PASS");
		$dbname = getenv("DATABASE");
     
        try{
            // Create database connection
 		    $conn = mysqli_connect($servername, $username, $password, $dbname);
 		    // Check connection
		    if (!$conn) {
			    //die("Connection failed: " . $conn->connect_error);
                echo "connection failed";
                exit();
		    }
            // Query database for all rows in the table
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "Number of rows:" . $result->num_rows;
                // Display table headers
                echo "<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
                // Loop through results and display each row in the table
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["emp_no"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] .
                    "</td><td>" . $row["email_id"] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }

            // Close database connection
            $conn->close();
        }
        catch(Exception $e) {
            echo "Error executing the query";
            echo $e;
        }
	?>
</body>
</html>
