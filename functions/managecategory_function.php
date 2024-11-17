<?php
session_start();
include(__DIR__ . '/../db_connect/db.php');


// Category function start

// Get Category by ID (For Editing)
if (isset($_GET['action']) && $_GET['action'] === 'get_category') {
    $categoryId = $_GET['id'];

    $sql = "SELECT * FROM categories WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':category_id' => $categoryId]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($category);
    exit;
}

// Create Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createCategory'])) {
    $categoryName = $_POST['category_name'];
    $description = $_POST['description'];
    $image = null;

    // Handle Image Upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Make sure it's writable
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Set file permissions automatically
            if (!is_writable($imagePath)) {
                chmod($imagePath, 0644); // Ensure the file is readable by others
            }

            $image = $imageName; // Save the filename in the database
        }
    }

    insertCategory($categoryName, $description, $image);

    // Redirect to category management page
    header('Location: ../superadmin/category.php');
    exit;
}

// Edit Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateCategory'])) {
    $categoryId = $_POST['category_id'];
    $categoryName = $_POST['category_name'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Use the old image if no new image is uploaded

    // Handle Image Upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        // Ensure the uploads directory exists, and create it if not
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory with the correct permissions
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Automatically set file permissions for the uploaded image
            if (!is_writable($imagePath)) {
                chmod($imagePath, 0644); // Ensure the file is readable by others
            }

            // Update the image name in the database (only store the file name, not the full path)
            $image = $imageName;
        }
    }

    // Update category with the new image or existing image
    updateCategory($categoryId, $categoryName, $description, $image);

    // Redirect back to category management
    header('Location: ../superadmin/category.php');
    exit;
}

// Delete Category
if (isset($_GET['action']) && $_GET['action'] === 'delete_category') {
    $categoryId = $_GET['id'];
    deleteCategory($categoryId);

    // Redirect back to category management
    header('Location: ../superadmin/category.php');
    exit;
}

// Function to insert a new category
function insertCategory($categoryName, $description, $image)
{
    global $conn;

    $sql = "INSERT INTO categories (category_name, description, image) VALUES (:category_name, :description, :image)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':category_name' => $categoryName,
        ':description' => $description,
        ':image' => $image
    ]);
}

// Function to update an existing category
function updateCategory($categoryId, $categoryName, $description, $image)
{
    global $conn;

    $sql = "UPDATE categories SET category_name = :category_name, description = :description, image = :image, updated_at = current_timestamp() WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':category_name' => $categoryName,
        ':description' => $description,
        ':image' => $image,
        ':category_id' => $categoryId
    ]);
}

// Delete Category logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCategory']) && isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];

    // Optional: Delete the associated image before deleting the category
    $sql = "SELECT image FROM categories WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':category_id' => $categoryId]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category && file_exists(__DIR__ . '/../uploads/' . $category['image'])) {
        unlink(__DIR__ . '/../uploads/' . $category['image']);  // Delete the image file
    }

    // Now delete the category from the database
    $sql = "DELETE FROM categories WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':category_id' => $categoryId]);

    // Redirect back to the category management page
    header('Location: ../superadmin/category.php');
    exit;
}

// category function end

?>