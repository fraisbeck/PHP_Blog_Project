
<?php
    // Start the session
    require_once('startsession.php');
      
    // Insert the page header
    $page_title = 'Friends and Family Cookbook';
    require_once('header.php');
    
    require_once('appvars.php');
    require_once('connectvars.php');
    
    // Show the navigation menu
    require_once('navmenu.php');
?>
    <div class="search">
        <form method="get" action="search.php">
            <label class="searchLabel" for="usersearch">Find your favorite recipe:</label><br />
            <input type="text" id="usersearch" name="usersearch" placeholder="Search..."/><br />
            <input type="submit" name="submit" value="Submit" />
        </form>
    </div>
  
<?php
    // Connect to the database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connecting to MySQL server.');

    // Retrieve the score data from MySQL
    $query = "SELECT * FROM recipeList ORDER BY date DESC LIMIT 10";
    $data = mysqli_query($dbc, $query)
            or die('Error querying database.');
    
    echo '<div class="results">';    
    echo '<h2>Check out some of our latest recipes from our users</h2>';
    
    // Loop through the array of recipe data, formatting it as HTML 
    echo '<table>';
    echo '<tr><th>Name</th>
            <th>Ingredients</th>
            <th>Directions</th>
            <th></th></tr>';
    while ($row = mysqli_fetch_array($data)) {
        echo '<tr>';
        echo '<td style="font-weight:bold" valign="top" width="10%">' . $row['title'] . '</td>';
        echo '<td valign="top" width="30%">' . preg_replace("/\r\n/", "<br />", $row['ingredients']) . '</td>';
        echo '<td valign="top" width="60%">' . preg_replace("/\r\n/", "<br />", $row['directions']) . '</td>';
        if (is_file(RECIPE_UPLOADPATH . $row['dishPicture']) && filesize(RECIPE_UPLOADPATH . $row['dishPicture']) > 0) {
            echo '<td valign="top"><img src="' . RECIPE_UPLOADPATH . $row['dishPicture'] . '" alt="Dish image" /></td></tr>';
        }
        else {
            echo '<td valign="top" width="20%">' . $row['dishPicture'] . '</td>';
        }
        echo '</tr>';
    } 
    echo '</table>';
    echo '</div>';
    // Insert the page footer
    require_once('footer.php');
?>
