<?php
session_start();
include(__DIR__ . '/../db_connect/db.php');

if (isset($_GET['action']) && $_GET['action'] === 'get_user') {
    $userId = $_GET['id'];

    $sql = "SELECT user_id, username, email, role, status FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($user);
    exit;
}


//edit user modal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateUser'])) {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password']; // Optional field
    $status = $_POST['status']; // New field

    updateUser($userId, $username, $email, $role, $password, $status);

    // Redirect back to user management
    header('Location: ../superadmin/usermanagement.php');
    exit;
}




// Function to insert a new user
function insertUser($username, $email, $password, $role)
{
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':role' => $role
    ]);
}

// Function to update an existing user's information (including password if provided)
function updateUser($userId, $username, $email, $role, $password = null, $status)
{
    global $conn;

    if ($password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users 
                SET username = :username, email = :email, role = :role, status = :status, password = :password, updated_at = current_timestamp() 
                WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':role' => $role,
            ':status' => $status, // Ensure proper binding
            ':password' => $hashedPassword,
            ':user_id' => $userId
        ]);
    } else {
        $sql = "UPDATE users 
                SET username = :username, email = :email, role = :role, status = :status, updated_at = current_timestamp() 
                WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':role' => $role,
            ':status' => $status, // Ensure proper binding
            ':user_id' => $userId
        ]);
    }
}




// Function to delete a user
function deleteUser($userId)
{
    global $conn;

    $sql = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
}
?>