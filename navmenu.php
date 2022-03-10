<?php
    // Generate the navigation menu
    if (isset($_SESSION['username'])) {
        echo '<div class="navbar">';
        echo '<a href="index.php">Home</a>';
        echo '<a href="viewprofile.php">View Personal Recipes</a>';
        echo '<a href="newrecipe.php">Save a new Recipe</a>';
        echo '<a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a>';
        echo '</div>';
    }
    else {
        echo '<div class="navbar">';
        echo '<a href="index.php">Home</a>';
        echo '<a href="login.php">Log In</a>';
        echo '<a href="signup.php">Sign Up</a>';
        echo '</div>';
    }
?>

