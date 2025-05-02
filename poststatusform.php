<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Post a New Status</title>
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
          <h1>Post a New Status</h1><hr />

          <form action="poststatusprocess.php" method="post">
            
            <!-- Status Code -->
            <label class="post-labels" for="stcode">Status Code:</label>
            <input type="text" id="stcode" name="stcode" 
              pattern="^S\d{4}$" 
              title="Status code must start with 'S' followed by 4 digits (e.g., S0001)"
              required>
            <br><br>

            <!-- Status -->
            <label class="post-labels" for="st">Status:</label>
            <input type="text" id="st" name="st" 
              pattern="^[A-Za-z0-9 ,.?!]+$" 
              title="Only letters, numbers, spaces, commas, periods, exclamation marks, and question marks are allowed." 
              required>
            <br><br>

            <!-- Share -->
            <p class="post-labels">Share with:</p>
            <input type="radio" id="university" name="share" value="University" required>
            <label for="university">University</label><br>

            <input type="radio" id="class" name="share" value="Class">
            <label for="class">Class</label><br>

            <input type="radio" id="private" name="share" value="Private">
            <label classfor="private">Private</label>
            <br><br>

            <!-- Date -->
            <?php
              $today = date("d/m/Y");
            ?>
            <label class="post-labels" for="date">Date (dd/mm/yyyy):</label>
            <input type="text" id="date" name="date" value="<?php echo $today; ?>" required pattern="\d{2}/\d{2}/\d{4}">
            <br><br>

            <!-- Permission -->
            <p class="post-labels">Permissions:</p>
            <input type="checkbox" id="like" name="permission[]" value="Like">
            <label for="like">Allow Like</label><br>

            <input type="checkbox" id="comment" name="permission[]" value="Comments">
            <label for="comment">Allow Comments</label><br>

            <input type="checkbox" id="share" name="permission[]" value="Share">
            <label for="share">Allow Share</label>
            <br><br>

            <!-- Submit -->
            <button type="submit">Post Status</button>
          </form>

          <!-- Link to return to home page -->
          <p><a href="index.html">Return to Home Page</a></p>

        </div>
      </div>
    </div>
  </div>
  

</body>
</html>
