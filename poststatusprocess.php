<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Processing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-5">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="p-5 mb-4 bg-light rounded-3">
            <h1>Status Processing</h1><hr />
    

            <?php

                require_once("../../files/settings.php");
                
                // Connect to the database using credentials from settings.php
                $conn = @mysqli_connect($host, $user, $psw, $dbnm);

                // Check the connection to the database
                if (!$conn){
                    echo "<p>Database connection failure </p>";
                    exit;
                }
                
                // Retrieve user selection from form
                $stcode = $_POST["stcode"];
                $status = $_POST["st"];
                $share = $_POST["share"];
                $date = $_POST["date"];
                $permissions = isset($_POST["permission"]) ? implode(", ", $_POST["permission"]) : "None";

                // Validate the status code
                // NOTE: Duplication check is done after table check
                if (!preg_match("/^S\d{4}$/", $stcode)) {
                    echo "<p>Invalid status code format. It should start with 'S' followed by 4 digits.</p>";
                    echo '<a href="index.html">Return to Home Page</a>';
                    exit;
                }

                // Validate the status message
                if (!preg_match("/^[A-Za-z0-9 ,.?!]+$/", $status)) {
                    echo "<p>Invalid status message format. Only letters, numbers, spaces, commas, periods, exclamation marks, and question marks are allowed.</p>";
                    echo '<a href="index.html">Return to Home Page</a>';
                    exit;
                }

                // Validate the date
                list($day, $month, $year) = explode("/", $date);
                if (!checkdate($month, $day, $year)) {
                    echo "<p>Invalid date format. Please use dd/mm/yyyy.</p>";
                    echo '<a href="index.html">Return to Home Page</a>';
                    exit;
                }

                // Create table if it doesn't exist
                $createTableQuery = "CREATE TABLE IF NOT EXISTS status (
                    status_code VARCHAR(5) PRIMARY KEY,
                    status_message TEXT NOT NULL,
                    share_with ENUM('University', 'Class', 'Private') NOT NULL,
                    date DATE NOT NULL,
                    permissions TEXT
                )";

                // Error handling for table creation
                if (!mysqli_query($conn, $createTableQuery)) {
                    echo "<p>Error creating table: " . mysqli_error($conn) . "</p>";
                    exit;
                }

                // Check for duplicate status code
                $checkQuery = "SELECT * FROM status WHERE status_code = ?"; // The SQL query to check for duplicates
                $checkStmt = mysqli_prepare($conn, $checkQuery); // Prepare the check query as statement
                mysqli_stmt_bind_param($checkStmt, "s", $stcode); // Bind the parameter
                mysqli_stmt_execute($checkStmt); // Execute the statement
                $result = mysqli_stmt_get_result($checkStmt); // Get the result of the statement

                // Error handling for duplicate check
                if (mysqli_num_rows($result) > 0) {
                    echo "<p>Status code already exists. Please choose a different code.</p>";
                    echo '<a href="index.html">Return to Home Page</a>';
                    exit;
                }

                // Insert status into the table
                $insertQuery = "INSERT INTO status (status_code, status_message, share_with, date, permissions) VALUES (?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?)"; // The SQL query to insert the status. Reformats date using STR_TO_DATE SQL function
                $insertStmt = mysqli_prepare($conn, $insertQuery); // Prepare the insert query as statement
                mysqli_stmt_bind_param($insertStmt, "sssss", $stcode, $status, $share, $date, $permissions); // Bind the parameters

                // Error handling for inserting status to table
                if (!mysqli_stmt_execute($insertStmt)) {
                    echo "<p>Error posting status: " . mysqli_stmt_error($insertStmt) . "</p>";
                    exit;
                } else {
                    echo "<p>Status posted successfully!</p>";
                }

                echo "<a href='index.html'>Return to Home Page</a></p>";

                // Close db connection
                mysqli_close($conn);
            ?>
          </div>
        </div>
      </div>
    </div>
</body>
</html>