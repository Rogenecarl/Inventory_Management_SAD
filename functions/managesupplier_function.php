<?php
session_start();
include(__DIR__ . '/../db_connect/db.php');

// Create Supplier
if (isset($_POST['createSupplier'])) {
    $supplier_name = $_POST['supplier_name'];
    $contact_name = $_POST['contact_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO suppliers (supplier_name, contact_name, phone, email, address) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$supplier_name, $contact_name, $phone, $email, $address])) {
        // Redirect to supplier page after successful creation
        header('Location: ../superadmin/supplier.php'); 
        exit(); // Don't forget to exit after the header redirect to prevent further execution
    } else {
        echo "Error creating supplier.";
    }
}

// Get Supplier (for editing)
if (isset($_GET['action']) && $_GET['action'] == 'get_supplier' && isset($_GET['id'])) {
    $supplier_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM suppliers WHERE supplier_id = ?");
    $stmt->execute([$supplier_id]);
    $supplier = $stmt->fetch();
    echo json_encode($supplier);
}

// Update Supplier
if (isset($_POST['updateSupplier'])) {
    $supplier_id = $_POST['supplier_id'];
    $supplier_name = $_POST['supplier_name'];
    $contact_name = $_POST['contact_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE suppliers SET supplier_name = ?, contact_name = ?, phone = ?, email = ?, address = ? WHERE supplier_id = ?");
    if ($stmt->execute([$supplier_name, $contact_name, $phone, $email, $address, $supplier_id])) {
        // Redirect to supplier page after successful update
        header('Location: ../superadmin/supplier.php'); 
        exit(); // Don't forget to exit after the header redirect
    } else {
        echo "Error updating supplier.";
    }
}

// Delete Supplier
if (isset($_POST['deleteSupplier'])) {
    $supplier_id = $_POST['supplier_id'];
    $stmt = $conn->prepare("DELETE FROM suppliers WHERE supplier_id = ?");
    if ($stmt->execute([$supplier_id])) {
        // Redirect to supplier page after successful deletion
        header('Location: ../superadmin/supplier.php'); 
        exit(); // Don't forget to exit after the header redirect
    } else {
        echo "Error deleting supplier.";
    }
}

// Fetch All Suppliers (for displaying in the table)
function fetchSuppliers($conn) {
    $stmt = $conn->query("SELECT * FROM suppliers");
    return $stmt->fetchAll();
}
?>
