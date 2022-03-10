<?php
    // Start the session
    require_once('startsession.php');
    
    // Insert the page header
    $page_title = 'Share a New Recipe';
    require_once('header.php');
    
    require_once('appvars.php');
    require_once('connectvars.php');
  
    // Show the navigation menu
    require_once('navmenu.php');
    
    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connecting to MySQL server.');
    
    if (isset($_POST['submit'])) {
        // Grab the recipe data from the POST
        $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
        $ingredients = mysqli_real_escape_string($dbc, trim($_POST['ingredients']));
        $directions = mysqli_real_escape_string($dbc, trim($_POST['directions']));
        $date = date("Y/m/d H:i:s");
        $userid = $_SESSION['userid'];
        $screenshot = $_FILES['dishPicture']['name'];
        $screenshot_type = $_FILES['dishPicture']['type'];
        $screenshot_size = $_FILES['dishPicture']['size'];
        
        if (!empty($title) && !empty($ingredients) && !empty($directions)) {
            if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') ||
                    ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png')) &&
                    ($screenshot_size > 0) && ($screenshot_size <= RECIPE_MAXFILESIZE)) {
                if ($_FILES['dishPicture']['error'] == 0) {
                    // Move the file to the target upload folder
                    $target = RECIPE_UPLOADPATH . $screenshot;
                    if (move_uploaded_file($_FILES['dishPicture']['tmp_name'], $target)) {
                        // Connect to the database
                        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                                or die('Error connecting to MySQL server.');
                        // Write the data to the database
                        $query = "INSERT INTO recipeList (user_id, title, date, ingredients, directions, dishPicture)
                                VALUES ('$userid', '$title', '$date', '$ingredients' , '$directions', '$screenshot')";
                        mysqli_query($dbc, $query)
                                or die('Error querying database.');
                            
                        echo '<p class="success">Your Recipe has been saved.</p>';
                        
                        // Clear the score data to clear the form
                        //$title = "";
                        //$ingredients = "";
                        //$directions = "";
                        //$screenshot = "";
                        
                        mysqli_close($dbc);
                        
                    }
                    else {
                        echo '<p class="error">Sorry, there was a problem uploading your screen shot image.</p>';
                    }
                }
            }
            else {
                echo '<p class="error">The screen shot must be a GIF, JPEG, or PNG image file no greater than ' .     
                (RECIPE_MAXFILESIZE / 1024) . ' KB in size.</p>';
            }
            // Try to delet the temporary screen shot image file
            @unlink($_FILES['dishPicture']['tmp_name']);
        }
        else {
            echo '<p class="error">Please fill out all parts of the recipe.</p>';
        }
    }
?>
<div class="results">
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend>New Recipe Entry</legend><br />
            <div class="newfield">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php $title; ?>" 
                    /><br /><br />
            <label for="post">List of Ingredients:</label>
            <textarea type="post" id="ingredients" name="ingredients" placeholder="Write something..." 
                    value="<?php $ingredients; ?>"></textarea>
            <br /><br />
            <label for="post">Recipe Directions:</label>
            <textarea type="post" id="directions" name="directions" placeholder="Write something..." 
                    value="<?php $directions; ?>"></textarea>
            <br /><br />
            <label for="screenshot">Dish Picture:</label>
            <input type="file" id="dishPicture" name="dishPicture" />
            </div>
        </fieldset>
        <input type="submit" value="Save Post" name="submit" />
    </form>
</div>
<?php    
    // Insert the page footer
    require_once('footer.php');
?>
