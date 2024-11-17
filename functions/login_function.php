<?php
// login_function.php
session_start(); // Make sure the correct file name is used
// In login_function.php
include(__DIR__ . '/../db_connect/db.php');


function loginUser($username_or_email, $password) {
    global $conn;

    // Default superadmin credentials
    $superadmin_username = 'superadmin';
    $superadmin_email = 'superadmin@gmail.com';
    $superadmin_password = 'sadmin123';  // Plaintext password for superadmin

    // Check if the input matches superadmin credentials
    if (($username_or_email == $superadmin_username || $username_or_email == $superadmin_email) && $password == $superadmin_password) {
        // Set session variables for superadmin
        $_SESSION['user_id'] = 1;  // You can set this manually as superadmin's ID
        $_SESSION['username'] = $superadmin_username;
        $_SESSION['role'] = 'super_admin';

        // Set success message for toast notification
        $_SESSION['toast_message'] = "Login Successful! Welcome Super Admin.";
        $_SESSION['toast_type'] = 'success';

        // Redirect to Super Admin Dashboard
        header("Location: superadmin/index.php");
        exit();
    }

    // Query to check for user by username or email
    $query = "SELECT * FROM users WHERE username = :username_or_email OR email = :username_or_email LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username_or_email', $username_or_email);
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password with the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // Check if the user is active
            if ($user['status'] == 'active') {
                // Set session variables for the logged-in user
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Set success message for toast notification
                $_SESSION['toast_message'] = "Login Successful! Welcome " . $user['role'];
                $_SESSION['toast_type'] = 'success';

                // Redirect based on user role
                if ($user['role'] == 'super_admin') {
                    header("Location: superadmin/index.php");
                    exit();
                } elseif ($user['role'] == 'admin') {
                    header("Location: admin_dashboard.php");
                    exit();
                } elseif ($user['role'] == 'staff') {
                    header("Location: staff_dashboard.php");
                    exit();
                }
            } else {
                // User is inactive, show error message
                $_SESSION['toast_message'] = "Your account is inactive. Please contact the administrator.";
                $_SESSION['toast_type'] = 'error';
                header("Location: index.php");
                exit();
            }
        } else {
            // Incorrect password
            $_SESSION['toast_message'] = "Invalid password. Please try again.";
            $_SESSION['toast_type'] = 'error';
            header("Location: index.php");
            exit();
        }
    } else {
        // No user found with the provided username or email
        $_SESSION['toast_message'] = "No user found with that username or email.";
        $_SESSION['toast_type'] = 'error';
        header("Location: index.php");
        exit();
    }
}



?>
