<?php
include '../functions/managesupplier_function.php'; // Include the supplier management functions
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" />
  <link rel="stylesheet" href="assets/css/supplier.css" />
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

            <a href="#" class="sidebar__link active-link">
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
    <h1 class="dash-fix">Supplier</h1>
    <div class="main__container">
      <!-- Create Supplier Button -->
      <div class="search-create-container">
        <button class="createbtn" onclick="openCreateSupplierModal()">Add Supplier</button>
      </div>

      <!-- Create Supplier Modal -->
      <div id="createSupplierModal" class="modal">
        <div class="modal-content">
          <h2>Create Supplier</h2>
          <form id="createSupplierForm" action="../functions/managesupplier_function.php" method="POST">
            <label for="supplier_name">Supplier Name:</label>
            <input type="text" id="supplier_name" name="supplier_name" required>

            <label for="contact_name">Contact Name:</label>
            <input type="text" id="contact_name" name="contact_name">

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="address">Address:</label>
            <textarea id="address" name="address"></textarea>

            <div class="modal-buttons">
              <button type="submit" name="createSupplier" class="createbtn">Create</button>
              <button type="button" class="cancel-btn" onclick="closeCreateSupplierModal()">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Edit Supplier Modal -->
      <div id="editSupplierModal" class="modal">
        <div class="modal-content">
          <form id="editSupplierForm" action="../functions/managesupplier_function.php" method="POST">
            <input type="hidden" id="editSupplierId" name="supplier_id">

            <label for="editSupplierName">Supplier Name:</label>
            <input type="text" id="editSupplierName" name="supplier_name" required>

            <label for="editContactName">Contact Name:</label>
            <input type="text" id="editContactName" name="contact_name">

            <label for="editPhone">Phone:</label>
            <input type="text" id="editPhone" name="phone">

            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" name="email">

            <label for="editAddress">Address:</label>
            <textarea id="editAddress" name="address"></textarea>

            <div class="modal-buttons">
              <button type="submit" name="updateSupplier" class="save-btn">Save Changes</button>
              <button type="button" class="cancel-btn" onclick="closeModal('editSupplierModal')">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Supplier Modal -->
      <div id="deleteSupplierModal" class="modal">
        <div class="modal-content">
          <h2>Are you sure you want to delete this supplier?</h2>
          <form id="deleteForm" method="POST" action="../functions/managesupplier_function.php">
            <input type="hidden" name="supplier_id" id="deleteSupplierId">
            <button type="submit" name="deleteSupplier">Yes, Delete</button>
            <button type="button" class="cancel" onclick="closeModal('deleteSupplierModal')">Cancel</button>
          </form>
        </div>
      </div>

      <!-- Supplier Table -->
      <div class="table-container">
        <table id="supplierTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Supplier Name</th>
              <th>Contact Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Address</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Fetch suppliers from the database
            $stmt = $conn->query("SELECT * FROM suppliers");
            while ($row = $stmt->fetch()) {
              echo "<tr>";
              echo "<td>" . $row['supplier_id'] . "</td>";
              echo "<td>" . $row['supplier_name'] . "</td>";
              echo "<td>" . $row['contact_name'] . "</td>";
              echo "<td>" . $row['phone'] . "</td>";
              echo "<td>" . $row['email'] . "</td>";
              echo "<td>" . $row['address'] . "</td>";
              echo "<td>" . $row['created_at'] . "</td>";
              echo "<td>" . $row['updated_at'] . "</td>";
              echo "<td>";
              echo "<div class='button-container'>
            <button class='edit-btn' onclick=\"editSupplier(" . $row['supplier_id'] . ")\"><i class='ri-pencil-line'></i></button>
            <button class='delete-btn' onclick=\"deleteSupplier(" . $row['supplier_id'] . ")\"><i class='ri-delete-bin-line'></i></button>
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
  <script src="assets/js/supplier.js"></script>
</body>

</html>