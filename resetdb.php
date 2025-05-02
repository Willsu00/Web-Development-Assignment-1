<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <h1>Reset Database</h1>
    
                <?php

                    require_once("../../files/settings.php");
                    
                    // Connect to the database using credentials from settings.php
                    $conn = @mysqli_connect($host, $user, $psw, $dbnm);

                    // Check the connection to the database
                    if (!$conn){
                        echo "<p>Database connection failure </p>";
                        exit;
                    }
                    
                    // Drop the "status" table if it exists
                    $dropTableQuery = "DROP TABLE IF EXISTS status";
                    if (mysqli_query($conn, $dropTableQuery)) {
                        echo "<p>Database reset successfully.</p>";
                    } else {
                        echo "<p>Error resetting database: " . mysqli_error($conn) . "</p>";
                    }

                    echo '<p><a href="index.html">Return to Home Page</a></p>';

                    // Close the database connection
                    mysqli_close($conn);

                ?>

          </div>
        </div>
      </div>
    </div>
</body>
</html>
