<?php
session_start();
include(__DIR__ . '/../db_connect/db.php');
include(__DIR__ . '/../functions/manageuser_function.php'); // include the function file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit'])) {
    // Retrieve and sanitize form data
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $role = htmlspecialchars(trim($_POST['role']));

    // Call the insertUser function to insert the data into the database
    try {
        insertUser($username, $email, $password, $role);
        $_SESSION['message'] = "User created successfully!";
    } catch (Exception $e) {
        $_SESSION['message'] = "Failed to create user: " . $e->getMessage();
    }

    // Redirect back to the user management page
    header("Location: ../superadmin/usermanagement.php");
    exit;
}
?>
