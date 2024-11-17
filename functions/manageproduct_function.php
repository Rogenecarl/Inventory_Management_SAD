<?php
session_start();
include(__DIR__ . '/../db_connect/db.php');

$categoryStmt = $conn->query("SELECT * FROM categories");
$suppliersStmt = $conn->query("SELECT * FROM suppliers");

// Add Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createProduct'])) {
    $productName = $_POST['name'];
    $categoryId = $_POST['category_id'];
    $supplierId = $_POST['supplier_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = null;

    // Handle Image Upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        // Sanitize file name and validate image type
        $imageName = preg_replace("/[^a-zA-Z0-9\-_\.]/", "", $imageName); // Remove any non-alphanumeric characters

        // Check if the file is an image (Optional)
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            // Check file size (max 5MB)
            if ($_FILES['image']['size'] > 5000000) {
                echo "File is too large. Maximum size is 5MB.";
                exit;
            }

            // Create the directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Move the uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imageName; // Save the image filename
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    }

    // Insert product into database
    insertProduct($productName, $categoryId, $supplierId, $price, $quantity, $image);

    // Redirect to product management page with success message
    $_SESSION['message'] = "Product created successfully!";
    header('Location: ../superadmin/inventory.php');
    exit;
}

// Update Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProduct'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['name'];
    $categoryId = $_POST['category_id'];
    $supplierId = $_POST['supplier_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image']; // Use old image if no new image is uploaded

    // Handle Image Upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        // Sanitize file name and validate image type
        $imageName = preg_replace("/[^a-zA-Z0-9\-_\.]/", "", $imageName); // Remove any non-alphanumeric characters

        // Check if the file is an image (Optional)
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            // Check file size (max 5MB)
            if ($_FILES['image']['size'] > 5000000) {
                echo "File is too large. Maximum size is 5MB.";
                exit;
            }

            // Create the directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Move the uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imageName; // Save the image filename
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    }

    // Update the product in the database
    updateProduct($productId, $productName, $categoryId, $supplierId, $price, $quantity, $image);

    // Redirect to product management page with success message
    $_SESSION['message'] = "Product updated successfully!";
    header('Location: ../superadmin/inventory.php');
    exit;
}

// Delete Product
if (isset($_GET['action']) && $_GET['action'] === 'delete_product') {
    $productId = $_GET['id'];
    deleteProduct($productId);

    // Redirect to product management page with success message
    $_SESSION['message'] = "Product deleted successfully!";
    header('Location: ../superadmin/inventory.php');
    exit;
}

// Function to insert a new product
function insertProduct($productName, $categoryId, $supplierId, $price, $quantity, $image)
{
    global $conn;

    $sql = "INSERT INTO products (name, category_id, supplier_id, price, quantity, image) 
            VALUES (:name, :category_id, :supplier_id, :price, :quantity, :image)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $productName,
        ':category_id' => $categoryId,
        ':supplier_id' => $supplierId,
        ':price' => $price,
        ':quantity' => $quantity,
        ':image' => $image
    ]);
}

// Function to update an existing product
function updateProduct($productId, $productName, $categoryId, $supplierId, $price, $quantity, $image)
{
    global $conn;

    $sql = "UPDATE products SET name = :name, category_id = :category_id, supplier_id = :supplier_id, 
            price = :price, quantity = :quantity, image = :image, updated_at = current_timestamp() 
            WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $productName,
        ':category_id' => $categoryId,
        ':supplier_id' => $supplierId,
        ':price' => $price,
        ':quantity' => $quantity,
        ':image' => $image,
        ':product_id' => $productId
    ]);
}

// Delete Product logic
function deleteProduct($productId)
{
    global $conn;

    // Optionally delete the image
    $sql = "SELECT image FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':product_id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && file_exists(__DIR__ . '/../uploads/' . $product['image'])) {
        unlink(__DIR__ . '/../uploads/' . $product['image']);
    }

    // Now delete the product from the database
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':product_id' => $productId]);
}
?>
