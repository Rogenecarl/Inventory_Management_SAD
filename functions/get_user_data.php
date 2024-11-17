<?php
include(__DIR__ . '/../db_connect/db.php');

if (isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']); // Ensure it's a valid integer

    try {
        $stmt = $conn->prepare("SELECT user_id, username, email, role FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            header('Content-Type: application/json');
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'An error occurred']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
