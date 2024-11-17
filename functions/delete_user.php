<?php
include(__DIR__ . '/../functions/manageuser_function.php');

// Handling delete user action
if (isset($_POST['deleteUser'])) {
    $userId = $_POST['user_id'];
    deleteUser($userId);
    header("Location: ../superadmin/usermanagement.php");  // Correct the header redirection
    exit();
}
?>
