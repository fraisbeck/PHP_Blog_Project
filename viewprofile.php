<?php
    // Start the session
    require_once('startsession.php');
    
    // Insert the page header
    $page_title = 'Your Recipes';
    require_once('header.php');
    
    require_once('appvars.php');
    require_once('connectvars.php');
  
    // Show the navigation menu
    require_once('navmenu.php');



    // This function builds navigational page links based on the current page and
    // the number of pages
    function generate_page_links($cur_page, $num_pages) {
        $page_links = '';

        // If this page is not the first page, generate the "previous" link
        if ($cur_page > 1) {
            $page_links .= '<a href="' . $_SERVER['PHP_SELF'] . '?page=' . ($cur_page - 1) . '"><-</a> ';
        }
        else {
            $page_links .= '<- ';
        }

        // Loop through the pages generating the page number links
        for ($i = 1; $i <= $num_pages; $i++) {
            if ($cur_page == $i) {
                $page_links .= ' ' . $i;
            }
            else {
                $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?page=' . $i . '"> ' . $i . '</a>';
            }
        }

        // If this page is not the last page, generate the "next" link
        if ($cur_page < $num_pages) {
            $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?page=' . ($cur_page + 1) . '">-></a>';
        }
        else {
            $page_links .= ' ->';
        }

        return $page_links;
    }
    
    // Calculate pagination information
    $cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $results_per_page = 5;  // number of results per page
    $skip = (($cur_page - 1) * $results_per_page);
    
    // Start generating the table of results
    echo '<table border="0" cellpadding="2">';

    // Calculate pagination information
    $cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $results_per_page = 5;  // number of results per page
    $skip = (($cur_page - 1) * $results_per_page);



    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connecting to MySQL server.');

    // Grab the profile data from the database
    if (!isset($_GET['userid'])) {
        $query = "SELECT * FROM recipeList WHERE user_id = '" . 
                $_SESSION['userid'] . "'ORDER BY date DESC";
    }
    else {
        $query = "SELECT * FROM recipeList WHERE user_id = '" . 
                $_GET['userid'] . "' ORDER BY date DESC";
    }
    
    $data = mysqli_query($dbc, $query)
            or die('Error querying database.');
    $total = mysqli_num_rows($data);
    $num_pages = ceil($total / $results_per_page);
    
    // Query again to get just the subset of results
    $query = $query . " LIMIT $skip, $results_per_page";
    $result = mysqli_query($dbc, $query);
    
    echo '<table class="results">';
    echo '<tr><th>Title</th>
            <th>Date</th>
            <th>Ingredients</th>
            <th>Directions</th>
            <th></th></tr>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td style="font-weight:bold" valign="top" width="10%">' . $row['title'] . '</td>';
        echo '<td valign="top" width="10%">' . substr($row['date'], 0, 10) . '</td>';
        echo '<td valign="top" width="30%">' . preg_replace("/\r\n/", "<br />", $row['ingredients']) . '</td>';
        echo '<td valign="top" width="50%">' . preg_replace("/\r\n/", "<br />", $row['directions']) . '</td>';
        if (is_file(RECIPE_UPLOADPATH . $row['dishPicture']) 
                && filesize(RECIPE_UPLOADPATH . $row['dishPicture']) > 0) {
            echo '<td valign="top"><img src="' . RECIPE_UPLOADPATH . $row['dishPicture'] . '" 
                    alt="Dish image" /></td></tr>';
        }
        else {
            echo '<td valign="top" width="20%">' . $row['dishPicture'] . '</td>';
        }
        echo '</tr>';
    } 
    echo '</table>';
    
    // Generate navigational page links if we have more than one page
    if ($num_pages > 1) {
        echo generate_page_links($cur_page, $num_pages);
    }
   
    mysqli_close($dbc);
  
    // Insert the page footer
    require_once('footer.php');
?>

