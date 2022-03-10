<?php
    // Insert the page header
    $page_title = 'Remove User';
    require_once('header.php');
    
    require_once('appvars.php');
    require_once('connectvars.php');
  
    if (isset($_GET['userid']) && isset($_GET['username'])) {
   
        // Grab the score data from the GET
        $userid = $_GET['userid'];
        $username = $_GET['username'];
    
    }
    else if (isset($_POST['userid']) && isset($_POST['username'])) {
  
        // Grab the score data from the post
        $userid = $_POST['userid'];
        $username = $_POST['username'];
    
    }
    else {
        echo '<p class="error"> Sorry, no user was specified for removal.</p>';
    }
    
    if (isset($_POST['submit'])) {
        if ($_POST['confirm'] == 'Yes') {
      
            // Connect to the database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
              or die("Error connecting to DB_NAME server.");
      
            // Delete the score data from the database
            $query = "DELETE FROM recipeUser WHERE userid = '$userid' LIMIT 1";
            mysqli_query($dbc, $query)
                    or die("Error querying DB_NAME.");
            
            mysqli_close($dbc);
      
            // Confirm success with the user
            echo '<p>The user of ' . $username . ' was successfully removed.';
        }
        else {
            echo '<p class="error">The user was not removed.</p>';
        }
    }    
  
    else if (isset($userid) && isset($username)) {
        echo '<p>Are you sure you want to delete the following user?</p>';
        echo '<p><strong>Name: </strong>' . $username . '</p>';
        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
        echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
        echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
        echo '<input type="submit" value="submit" name="submit" />';
        echo '<input type="hidden" id="userid" name="userid" value="' . $userid . '" />';
        echo '<input type="hidden" id="username" name="username" value="' . $username . '" />';
        echo '</form>';
    }
  
    echo '<p><a href="admin.php"> Back to admin page</a></p>';
    
    // Insert the page footer
    require_once('footer.php');
?>  

