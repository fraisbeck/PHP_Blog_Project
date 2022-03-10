<?php
    session_start();

    // If the session vars aren't set, try to set them with a cookie
    if (!isset($_SESSION['userid'])) {
        if (isset($_COOKIE['userid']) && isset($_COOKIE['username'])) {
            $_SESSION['userid'] = $_COOKIE['userid'];
            $_SESSION['username'] = $_COOKIE['username'];
        }
    }
?>
