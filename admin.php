<?php
    require_once('authorize.php');
   
    // Insert the page header
    $page_title = 'Admin Page';
    require_once('header.php');
    
    echo '<p>Below is a list of all Recipes submitted.  Use this page to remove recipes as needed.</p>
            <hr />';
            
    require_once('appvars.php');
    require_once('connectvars.php');

    // Connect to the database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Retrieve the score data from MySQL
    $userquery = "SELECT * FROM recipeUser ORDER BY username ASC";
    $userdata = mysqli_query($dbc, $userquery);

    // Loop through the array of user data, formatting it as HTML 
    echo '<table>';
    while ($row = mysqli_fetch_array($userdata)) { 
        // Display the score data
        echo '<tr class="User"><td><strong>' . $row['username'] . '</strong></td>';
        echo '<td><a href="removeuser.php?userid=' . $row['userid'] . '&amp;username=' . $row['username'] . '&amp;password=' . 
                $row['password'] . '">Remove</a></td></tr>';
    }
  
    echo '</table>';

    echo '<br /><hr><br />';
    
    // Retrieve the recipe data from MySQL
    $recipequery = "SELECT * FROM recipeList ORDER BY date DESC";
    $recipedata = mysqli_query($dbc, $recipequery);

    // Loop through the array of score data, formatting it as HTML 
    echo '<table>';
    while ($row = mysqli_fetch_array($recipedata)) { 
        // Display the score data
        echo '<tr class="Recipe"><td><strong>' . $row['title'] . '</strong></td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['ingredients'] . '</td>';
        echo '<td><a href="removerecipe.php?id=' . $row['id'] . '&amp;date=' . $row['date'] .
                '&amp;title=' . $row['title'] . '&amp;ingredients=' . $row['ingredients'] . '&amp;screenshot=' . 
                $row['dishPicture'] . '">Remove</a></td></tr>';
    }
  
    echo '</table>';
  
    mysqli_close($dbc);
  
    // Insert the page footer
    require_once('footer.php');
?>
