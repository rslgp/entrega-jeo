<?php

include 'global/db_connection.php';
include 'global/functions.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data sent from the HTML form
    //$data = json_decode(file_get_contents('php://input'), true);

    $args = array(
    'nome'  =>  $_POST['nome'],
    'genero'  =>  $_POST['genero'],
    'valor'  =>  $_POST['valor'],
    'plataforma'  =>  $_POST['plataforma']);
    
    $result = insertGame($pdo, $args);

    if ($result) {
        // Return a success message or any other response
        echo "Game inserted successfully!";
    } else {
        // Handle the case where the Game insertion failed
        echo "Failed to insert Game.";
    }
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method.";
}
?>
