<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Replace with your login page URL
    exit;
}

function set_session_message($message) {
    $_SESSION['message'] = $message;
}

function display_session_message() {
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
        unset($_SESSION['message']);
    }
}

function display_errors($errors=array()) {
    $output = '';
    if(!empty($errors)) {
        $output .= "<div class=\"alert alert-danger\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul class=\"list-group\">";
        foreach($errors as $error) {
            $output .= "<li class=\"list-group-item\">" . $error . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

require_once('database_functions.php');
require_once('validation_functions.php');
$connection = db_connect();

?>