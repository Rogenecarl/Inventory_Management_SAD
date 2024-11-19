<?php
include '../functions/manageproduct_function.php'; // Include the login function
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" />
  <link rel="stylesheet" href="assets/css/inventory.css" />
  <title>Inventory Management</title>

</head>

<body>
  <!--=============== HEADER ===============-->
  <header class="header" id="header">
    <div class="header__container">
      <a href="#" class="header__logo">
        <img class="header__logo-img" src="assets/img/techno.png" alt="" />
        <!-- <i class="ri-cloud-fill"></i> -->
        <!-- <span>Inventory</span> -->
      </a>

      <button class="header__toggle" id="header-toggle">
        <i class="ri-menu-line"></i>
      </button>
    </div>
  </header>

  <!--=============== SIDEBAR ===============-->
  <nav class="sidebar" id="sidebar">
    <div class="sidebar__container">
      <div class="sidebar__user">
        <div class="sidebar__img">
          <img src="assets/img/techno.png" alt="" />
        </div>

        <div class="sidebar__info">
          <h3>Super Admin</h3>
          <span>TechNo Core</span>
        </div>
      </div>

      <div class="sidebar__content">
        <!-- Main Management Section -->
        <div>
          <h3 class="sidebar__title">MANAGE</h3>
          <div class="sidebar__list">
            <a href="index.php" class="sidebar__link">
              <i class="ri-dashboard-line"></i>
              <span>Dashboard</span>
            </a>

            <a href="usermanagement.php" class="sidebar__link">
              <i class="ri-user-settings-fill"></i>
              <span>User Management</span>
            </a>

            <a href="#" class="sidebar__link" id="inventory-link"
              style="display: flex; align-items: start; justify-content: start;">
              <i class="ri-git-repository-fill"></i>
              <span>Inventory</span>
              <i class="ri-arrow-down-s-line" style="margin-left: auto; padding-right:20px"></i>
            </a>

            <!-- Dropdown Menu (Initially Hidden) -->
            <div class="sidebar__submenu" id="inventory-submenu">
              <a href="inventory.php" class="sidebar__link">
                <i class="ri-file-list-2-fill"></i>
                <span>Product List</span>
              </a>
              <a href="#" class="sidebar__link sidesub">
                <i class="ri-folder-2-fill"></i>
                <span>Manage Stocks</span>
              </a>
              <a href="#" class="sidebar__link sidesub">
                <i class="ri-search-line"></i>
                <span>Inventory History</span>
              </a>
            </div>


            <a href="category.php" class="sidebar__link">
              <i class="ri-bar-chart-fill"></i>
              <span>Category</span>
            </a>

            <a href="supplier.php" class="sidebar__link">
              <i class="ri-truck-fill"></i>
              <span>Supplier</span>
            </a>

            <a href="reports.php" class="sidebar__link">
              <i class="ri-file-list-2-fill"></i>
              <span>Reports</span>
            </a>
          </div>
        </div>

        <!-- Settings and Configuration Section -->
        <div>
          <h3 class="sidebar__title">SETTINGS</h3>
          <div class="sidebar__list">
            <!-- <a href="#" class="sidebar__link">
              <i class="ri-settings-5-fill"></i>
              <span>System Settings</span>
            </a> -->

            <a href="#" class="sidebar__link">
              <i class="ri-key-fill"></i>
              <span>Account Settings</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Theme Toggle and Logout -->
      <div class="sidebar__actions">
        <button>
          <i class="ri-moon-clear-fill sidebar__link sidebar__theme" id="theme-button">
            <span>Theme</span>
          </i>
        </button>

        <button class="sidebar__link">
          <i class="ri-logout-box-r-fill"></i>
          <span>Log Out</span>
        </button>
      </div>
    </div>
  </nav>

  <!--=============== MAIN ===============-->
  <main class="main container" id="main">
    <h1 class="dash-fix">Inventory</h1>
    <div class="main__container">

      <!-- Add Product Button -->
      <div class="search-create-container">
        <button class="add-product-btn" onclick="openCreateProductModal()">Add Product</button>
      </div>

      <!-- Create Product Modal -->
      <div id="createProductModal" class="modal">
        <div class="modal-content">
          <h2>Create Product</h2>
          <form id="createProductForm" action="../functions/manageproduct_function.php" method="POST"
            enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="name" required>

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
              <!-- Populate categories dynamically -->
              <?php while ($category = $categoryStmt->fetch()) { ?>
                <option value="<?= $category['category_id']; ?>"><?= $category['category_name']; ?></option>
              <?php } ?>
            </select>

            <label for="supplier_id">Supplier:</label>
            <select id="supplier_id" name="supplier_id" required>
              <!-- Populate suppliers dynamically -->
              <?php while ($supplier = $suppliersStmt->fetch()) { ?>
                <option value="<?= $supplier['supplier_id']; ?>"><?= $supplier['supplier_name']; ?></option>
              <?php } ?>
            </select>

            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand">

            <label for="model">Model:</label>
            <input type="text" id="model" name="model">

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image">

            <div class="modal-buttons">
              <button type="submit" name="createProduct" class="createbtn">Create</button>
              <button type="button" class="cancel-btn" onclick="closeCreateProductModal()">Cancel</button>
            </div>
          </form>
        </div>
      </div>


      <!-- Edit Product Modal -->
      <div id="editProductModal" class="modal">
        <div class="modal-content">
          <form id="editProductForm" action="../functions/manageproduct_function.php" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" id="editProductId" name="product_id">

            <label for="editProductName">Product Name:</label>
            <input type="text" id="editProductName" name="name" required>

            <label for="editCategoryId">Category:</label>
            <select id="editCategoryId" name="category_id" required>
              <!-- Categories will be dynamically loaded here -->
            </select>

            <label for="editSupplierId">Supplier:</label>
            <select id="editSupplierId" name="supplier_id" required>
              <!-- Suppliers will be dynamically loaded here -->
            </select>

            <label for="editBrand">Brand:</label>
            <input type="text" id="editBrand" name="brand">

            <label for="editModel">Model:</label>
            <input type="text" id="editModel" name="model">

            <label for="editPrice">Price:</label>
            <input type="number" step="0.01" id="editPrice" name="price" required>

            <label for="editQuantity">Quantity:</label>
            <input type="number" id="editQuantity" name="quantity" required>

            <label for="editImage">Product Image:</label>
            <input type="file" id="editImage" name="image">

            <div class="modal-buttons">
              <button type="submit" name="updateProduct" class="save-btn">Save Changes</button>
              <button type="button" class="cancel-btn" onclick="closeModal('editProductModal')">Cancel</button>
            </div>
          </form>
        </div>
      </div>


      <!-- Delete Product Modal -->
      <div id="deleteProductModal" class="modal">
        <div class="modal-content">
          <h2>Are you sure you want to delete this product?</h2>
          <form id="deleteProductForm" method="POST" action="../functions/manageproduct_function.php">
            <input type="hidden" name="product_id" id="deleteProductId">
            <button type="submit" name="deleteProduct">Yes, Delete</button>
            <button type="button" class="cancel" onclick="closeModal('deleteProductModal')">Cancel</button>
          </form>
        </div>
      </div>


      <div class="table-container">
        <table id="productTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Category</th>
              <th>Supplier</th>
              <th>Brand</th> <!-- Added -->
              <th>Model</th> <!-- Added -->
              <th>Price</th>
              <th>Quantity</th>
              <th>Image</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            <?php
            // Fetch products from the database
            $stmt = $conn->query("SELECT product_id, name, category_id, supplier_id, price, quantity, image, brand, model, created_at, updated_at FROM products");

            while ($row = $stmt->fetch()) {
              // Fetch category and supplier names
              $categoryStmt = $conn->prepare("SELECT category_name FROM categories WHERE category_id = ?");
              $categoryStmt->execute([$row['category_id']]);
              $category = $categoryStmt->fetchColumn();

              $supplierStmt = $conn->prepare("SELECT supplier_name FROM suppliers WHERE supplier_id = ?");
              $supplierStmt->execute([$row['supplier_id']]);
              $supplier = $supplierStmt->fetchColumn();

              echo "<tr>";
              echo "<td>" . $row['product_id'] . "</td>";
              echo "<td>" . $row['name'] . "</td>";
              echo "<td>" . $category . "</td>";
              echo "<td>" . $supplier . "</td>";
              echo "<td>" . $row['brand'] . "</td>"; // Brand column
              echo "<td>" . $row['model'] . "</td>"; // Model column
              echo "<td>" . number_format($row['price'], 2) . "</td>";
              echo "<td>" . $row['quantity'] . "</td>";
              echo "<td><img src='../uploads/" . $row['image'] . "' width='50' alt='Product Image'></td>";
              echo "<td>" . $row['created_at'] . "</td>";
              echo "<td>" . $row['updated_at'] . "</td>";
              echo "<td>";
              echo "<div class='button-container'>
                        <button class='edit-btn' onclick=\"editProduct(" . $row['product_id'] . ")\"><i class='ri-pencil-line'></i></button>
                        <button class='delete-btn' onclick=\"deleteProduct(" . $row['product_id'] . ")\"><i class='ri-delete-bin-line'></i></button>
                      </div>";
              echo "</td>";
              echo "</tr>";
            }

            ?>
          </tbody>
        </table>
      </div>



    </div>

  </main>

  <!--=============== MAIN JS ===============-->
  <script src="assets/js/inventory.js"></script>
</body>

</html>