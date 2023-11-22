<?php

include 'global/db_connection.php';
include 'global/functions.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data sent from the HTML form
    //$data = json_decode(file_get_contents('php://input'), true);
    
    $result = deleteGame($pdo, $_POST['id']);

    if ($result) {
        // Return a success message or any other response
        echo "Game removed successfully!";
    } else {
        // Handle the case where the Game insertion failed
        echo "Failed to remove Game.";
    }
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method.";
}
?>
