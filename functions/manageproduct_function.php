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
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = null;

    // Handle Image Upload (existing logic)
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        $imageName = preg_replace("/[^a-zA-Z0-9\-_\.]/", "", $imageName);
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            if ($_FILES['image']['size'] > 5000000) {
                echo "File is too large. Maximum size is 5MB.";
                exit;
            }
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imageName;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    }

    // Insert product into database
    insertProduct($productName, $categoryId, $supplierId, $brand, $model, $price, $quantity, $image);

    $_SESSION['message'] = "Product created successfully!";
    header('Location: ../superadmin/inventory.php');
    exit;
}

// Function to insert a new product
function insertProduct($productName, $categoryId, $supplierId, $brand, $model, $price, $quantity, $image)
{
    global $conn;

    $sql = "INSERT INTO products (name, category_id, supplier_id, brand, model, price, quantity, image) 
            VALUES (:name, :category_id, :supplier_id, :brand, :model, :price, :quantity, :image)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $productName,
        ':category_id' => $categoryId,
        ':supplier_id' => $supplierId,
        ':brand' => $brand,
        ':model' => $model,
        ':price' => $price,
        ':quantity' => $quantity,
        ':image' => $image
    ]);
}

// Update Product (updated to include brand and model)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProduct'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['name'];
    $categoryId = $_POST['category_id'];
    $supplierId = $_POST['supplier_id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image'];

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        $imageName = preg_replace("/[^a-zA-Z0-9\-_\.]/", "", $imageName);
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            if ($_FILES['image']['size'] > 5000000) {
                echo "File is too large. Maximum size is 5MB.";
                exit;
            }
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imageName;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    }

    updateProduct($productId, $productName, $categoryId, $supplierId, $brand, $model, $price, $quantity, $image);

    $_SESSION['message'] = "Product updated successfully!";
    header('Location: ../superadmin/inventory.php');
    exit;
}

// Function to update an existing product
function updateProduct($productId, $productName, $categoryId, $supplierId, $brand, $model, $price, $quantity, $image)
{
    global $conn;

    $sql = "UPDATE products SET name = :name, category_id = :category_id, supplier_id = :supplier_id, 
            brand = :brand, model = :model, price = :price, quantity = :quantity, image = :image, 
            updated_at = current_timestamp() 
            WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $productName,
        ':category_id' => $categoryId,
        ':supplier_id' => $supplierId,
        ':brand' => $brand,
        ':model' => $model,
        ':price' => $price,
        ':quantity' => $quantity,
        ':image' => $image,
        ':product_id' => $productId
    ]);
}

// Delete Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteProduct'])) {
    $productId = $_POST['product_id'];
    deleteProduct($productId);

    $_SESSION['message'] = "Product deleted successfully!";
    header('Location: ../superadmin/inventory.php');
    exit;
}

// Function to delete a product
function deleteProduct($productId)
{
    global $conn;

    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':product_id' => $productId]);
}

// Delete Product logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteProduct']) && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Optional: Delete the associated image before deleting the product
    $sql = "SELECT image FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':product_id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && !empty($product['image']) && file_exists(__DIR__ . '/../uploads/' . $product['image'])) {
        unlink(__DIR__ . '/../uploads/' . $product['image']);  // Delete the image file
    }

    // Now delete the product from the database
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':product_id' => $productId]);

    // Redirect back to the inventory management page
    header('Location: ../superadmin/inventory.php');
    exit;
}


?>