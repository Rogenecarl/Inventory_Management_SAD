<?php
include '../functions/manageuser_function.php';
// Include the login function
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" />
  <link rel="stylesheet" href="assets/css/category.css" />
  <title>Inventory Management</title>

</head>

<body>
  <!--=============== HEADER ===============-->
  <header class="header" id="header">
    <div class="header__container">
      <a href="#" class="header__logo">
        <img class="header__logo-img" src="assets/img/techno.png" alt="" />
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

            <a href="#" class="sidebar__link" id="inventory-link" style="display: flex; align-items: start; justify-content: start;">
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
              <a href="inventory-item2.php" class="sidebar__link sidesub">
                <i class="ri-folder-2-fill"></i>
                <span>Manage Stocks</span>
              </a>
              <a href="inventory-item3.php" class="sidebar__link sidesub">
                <i class="ri-search-line"></i>
                <span>Inventory History</span>
              </a>
            </div>


            <a href="category.php" class="sidebar__link active-link">
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
    <h1 class="dash-fix">Category</h1>
    <div class="main__container">
      <!-- Create Category Button -->
      <div class="search-create-container">
        <button class="createbtn" onclick="openCreateCategoryModal()">Add Category</button>
      </div>

      <!-- Create Category Modal -->
      <div id="createCategoryModal" class="modal">
        <div class="modal-content">
          <h2>Create Category</h2>
          <form id="createCategoryForm" action="../functions/managecategory_function.php" method="POST"
            enctype="multipart/form-data">
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image">

            <div class="modal-buttons">
              <button type="submit" name="createCategory" class="createbtn">Create</button>
              <button type="button" class="cancel-btn" onclick="closeCreateCategoryModal()">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Edit Category Modal -->
      <div id="editModal" class="modal">
        <div class="modal-content">
          <form id="editCategoryForm" action="../functions/managecategory_function.php" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" id="editCategoryId" name="category_id">

            <label for="editCategoryName">Category Name:</label>
            <input type="text" id="editCategoryName" name="category_name" required>

            <label for="editDescription">Description:</label>
            <textarea id="editDescription" name="description"></textarea>

            <label for="editImage">Image:</label>
            <input type="file" id="editImage" name="image">

            <div class="modal-buttons">
              <button type="submit" name="updateCategory" class="save-btn">Save Changes</button>
              <button type="button" class="cancel-btn" onclick="closeModal('editModal')">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Category Modal -->
      <div id="deleteModal" class="modal">
        <div class="modal-content">
          <h2>Are you sure you want to delete this category?</h2>
          <form id="deleteForm" method="POST" action="../functions/managecategory_function.php">
            <input type="hidden" name="category_id" id="deleteCategoryId">
            <button type="submit" name="deleteCategory">Yes, Delete</button>
            <button type="button" class="cancel" onclick="closeModal('deleteModal')">Cancel</button>
          </form>
        </div>
      </div>


      <!-- Category Table -->
      <div class="table-container">
        <table id="categoryTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Category Name</th>
              <th>Description</th>
              <th>Image</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Fetch categories from the database
            $stmt = $conn->query("SELECT * FROM categories");
            while ($row = $stmt->fetch()) {
              echo "<tr>";
              echo "<td>" . $row['category_id'] . "</td>";
              echo "<td>" . $row['category_name'] . "</td>";
              echo "<td>" . $row['description'] . "</td>";
              echo "<td><img src='../uploads/" . $row['image'] . "' width='50' alt='Category Image'></td>";
              echo "<td>" . $row['created_at'] . "</td>";
              echo "<td>" . $row['updated_at'] . "</td>";
              echo "<td>";
              echo "<div class='button-container'>
                <button class='edit-btn' onclick=\"editCategory(" . $row['category_id'] . ")\"><i class='ri-pencil-line'></i></button>
                <button class='delete-btn' onclick=\"deleteCategory(" . $row['category_id'] . ")\"><i class='ri-delete-bin-line'></i></button>
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
  <script src="assets/js/category.js"></script>
</body>

</html>