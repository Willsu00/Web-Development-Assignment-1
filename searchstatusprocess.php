<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="content">
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="p-5 mb-4 bg-light rounded-3">
                        <h1>Search Status Result</h1><hr />
    
                        <?php

                            require_once("../../files/settings.php");
                            
                            // Connect to the database using credentials from settings.php
                            $conn = @mysqli_connect($host, $user, $psw, $dbnm);

                            // Check the connection to the database
                            if (!$conn){
                                echo "<p>Database connection failure </p>";
                                exit;
                            }

                            // Retrieve the search term from the form
                            $search = isset($_GET['search']) ? trim($_GET['search']) : '';


                            // Validate that the search field is not empty
                            if(empty($search)) {
                                echo "<p>Search term is required. Please enter a keyword to serach for.</p>";
                                echo '<a href="searchstatusform.php">Return to Search Form</a>';
                                echo '<a href="index.html">Return to Home Page</a>';
                                exit;
                            }

                            // Check if table status exists
                            $checkTableQuery = "SHOW TABLES LIKE 'status'";
                            $checkTableResult = mysqli_query($conn, $checkTableQuery);

                            // Returns message if table does not exist
                            if (mysqli_num_rows($checkTableResult) == 0) {
                                echo "<p>There are no status found in the system. Please make a status post.</p>";
                                echo '<a href="index.html">Return to Home Page</a>';
                                exit;
                            }

                            // Search for matching statuses
                            $searchQuery = "SELECT * FROM status WHERE LOWER(status_message) LIKE LOWER(?)";
                            $searchStmt = mysqli_prepare($conn, $searchQuery);
                            $searchParam = "%" . $search . "%";
                            mysqli_stmt_bind_param($searchStmt, "s", $searchParam);
                            mysqli_stmt_execute($searchStmt);
                            $result = mysqli_stmt_get_result($searchStmt);

                            if (mysqli_num_rows($result) == 0) {
                                echo "<p>Status not found for the keyword: <strong>$search</strong></p>";
                            } else {
                                // Loop through all results with matching status message keyword then printing the results
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<strong>Status Code:</strong> " . htmlspecialchars($row['status_code']) . "<br />";
                                    echo "<strong>Status Message:</strong> " . htmlspecialchars($row['status_message']) . "<br /><br />";

                                    // Format the date to "Month Day, Year" e.g., January 1, 2025
                                    $formattedDate = date("F j, Y", strtotime($row['date']));

                                    echo "<strong>Share With:</strong> " . htmlspecialchars($row['share_with']) . "<br />";
                                    echo "<strong>Date:</strong> " . htmlspecialchars($formattedDate) . "<br>";
                                    echo "<strong>Permissions:</strong> " . htmlspecialchars($row['permissions']) . "<br /><br />";
                                    echo "<hr />";
                                }

                            }

                            echo '<a href="index.html">Return to Home Page</a><br />';
                            echo '<a href="searchstatusform.html">Return to Search Status Page</a>';

                            // Close connection to db
                            mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>