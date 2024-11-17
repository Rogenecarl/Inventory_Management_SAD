<?php
include 'functions/login_function.php'; // Include the login function

// Check if the form is submitted
if (isset($_POST['Submit'])) {
    $username_or_email = $_POST['username_or_email'];  // Username or email entered by the user
    $password = $_POST['password'];  // Password entered by the user

    // Call the login function and pass the username/email and password
    $error_message = loginUser($username_or_email, $password);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webleb</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="login/style.css">
    <link rel="stylesheet" href="screenloader/style.css">
    <link rel="stylesheet" href="toastfolder/style.css">
</head>

<body style="display:flex; align-items:center; justify-content:center;">
    <div class="login-page">
        <div class="form">
            <form class="login-form" method="post">
                <h2><i class="fas fa-lock"></i> Login</h2>
                <input type="text" name="username_or_email" placeholder="Username or Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" name="Submit">Login</button>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"
        data-message="<?php echo isset($_SESSION['toast_message']) ? $_SESSION['toast_message'] : ''; ?>"
        data-type="<?php echo isset($_SESSION['toast_type']) ? $_SESSION['toast_type'] : ''; ?>">
    </div>

    <!-- Screen loader -->
    <div class="screenloader">
        <div class="loading-wave">
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="login/index.js"></script>
    <script src="screenloader/script.js"></script>
    <script src="toastfolder/script.js"></script>
</body>

</html>

<?php
// Clear the session variables after the message is passed to JavaScript
unset($_SESSION['toast_message']);
unset($_SESSION['toast_type']);
?>