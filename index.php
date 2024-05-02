<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Create Database and Table</title>
</head>
<body>

<div class="container">
    <h2>Create Database and Table</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="servername">Server Name:</label>
        <input type="text" id="servername" name="servername">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">

        <label for="dbname">Database Name:</label>
        <input type="text" id="dbname" name="dbname">

        <label for="tablename">Table Name:</label>
        <input type="text" id="tablename" name="tablename">

        <label for="tablefields">Table Fields (comma separated, e.g., field1 VARCHAR(255), field2 INT):</label>
        <input type="text" id="tablefields" name="tablefields">

        <input type="submit" name="create" value="Create">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
        
        $servername = $_POST['servername'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $dbname = $_POST['dbname'];
        $tablename = $_POST['tablename'];
        $tablefields = $_POST['tablefields'];

        // Connect to MySQL server
        $conn = new mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create database
        $sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $dbname";
        if ($conn->query($sqlCreateDatabase) === TRUE) {
            echo "<p>Database created successfully</p>";

            // Select the database
            $conn->select_db($dbname);

            // Create table
            $sqlCreateTable = "CREATE TABLE IF NOT EXISTS $tablename ($tablefields)";
            if ($conn->query($sqlCreateTable) === TRUE) {
                echo "<p>Table created successfully</p>";
            } else {
                echo "<p>Error creating table: " . $conn->error . "</p>";
            }

            // Close connection
            $conn->close();
        } else {
            echo "<p>Error creating database: " . $conn->error . "</p>";
        }
    }
    ?>
</div>

</body>
</html>
