<?php
    // Insert the page header
    $page_title = 'Remove Recipe';
    require_once('header.php');
    
    require_once('appvars.php');
    require_once('connectvars.php');
  
    if (isset($_GET['id']) && isset($_GET['date']) && isset($_GET['title']) &&
        isset($_GET['ingredients']) && isset($_GET['screenshot'])) {
    
        // Grab the score data from the GET
        $id = $_GET['id'];
        $date = $_GET['date'];
        $title = $_GET['title'];
        $ingredients = $_GET['ingredients'];
        $screenshot = $_GET['screenshot'];
    
    }
    else if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['ingredients'])) {
  
        // Grab the score data from the post
        $id = $_POST['id'];
        $title = $_POST['title'];
        $ingredients = $_POST['ingredients'];
        $screenshot = $_POST['screenshot'];
    
    }
    else {
        echo '<p class="error"> Sorry, no recipe was specified for removal.</p>';
    }
  
    if (isset($_POST['submit'])) {
        if ($_POST['confirm'] == 'Yes') {
      
        // Connect to the database
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
              or die("Error connecting to DB_NAME server.");
      
        // Delete the screen shot image file from the server
        @unlink(RECIPE_UPLOADPATH . $screenshot);
      
        // Delete the score data from the database
        $query = "DELETE FROM recipeList WHERE id = '$id' LIMIT 1";
        mysqli_query($dbc, $query)
                or die("Error querying DB_NAME.");
            
        mysqli_close($dbc);
      
        // Confirm success with the user
        echo '<p>The recipe of ' . $title . ' was successfully removed.';
        }
        else {
        echo '<p class="error">The recipe was not removed.</p>';
        }
    }
  
    else if (isset($id) && isset($title) && isset($date) &&
        isset($ingredients) && isset($screenshot)) {
        echo '<p>Are you sure you want to delete the following recipe?</p>';
        echo '<p><strong>Name: </strong>' . $title . '<br /><strong>Date: </strong>' . $date . 
                '<br /><strong>Score: </strong>' . $ingredients . '</p>';
        echo '<form method="post" action="removerecipe.php">';
        echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
        echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
        echo '<input type="submit" value="submit" name="submit" />';
        echo '<input type="hidden" name="id" value="' . $id . '" />';
        echo '<input type="hidden" name="title" value="' . $title . '" />';
        echo '<input type="hidden" name="ingredients" value="' . $ingredients . '" />';
        echo '<input type="hidden" name="screenshot" value="' . $screenshot . '" />';
        echo '</form>';
    }
  
    echo '<p><a href="admin.php"> Back to admin page</a></p>';
    
    // Insert the page footer
    require_once('footer.php');
?>  

