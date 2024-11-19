<?php
include '../functions/manageuser_function.php'; // Include the login function
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" />
  <link rel="stylesheet" href="assets/css/usermstyle.css" />
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

            <a href="usermanagement.php" class="sidebar__link active-link">
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
    <h1 class="dash-fix">User Management</h1>
    <div class="main__container">
      <!-- Search and Create Account Button Row -->
      <div class="search-create-container">
        <button class="createbtn" onclick="openCreateAccountModal()">Add User</button>
      </div>

      <!-- Modal structure -->
      <div id="createAccountModal" class="modal">
        <div class="modal-content">
          <h2>Create User</h2>
          <form id="createAccountForm" action="../functions/M_createuseracc.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
              <option value="super_admin">Dev</option>
              <option value="admin">Admin</option>
              <option value="staff">Staff</option>
            </select>

            <div class="modal-buttons">
              <button type="submit" class="createbtn" name="Submit">Create</button>
              <button type="button" class="cancel-btn" onclick="closeCreateAccountModal()">Cancel</button>
            </div>
          </form>
        </div>
      </div>


      <!-- edit and delete modal for table -->

      <!-- Edit User Modal -->
      <div id="editModal" class="modal">
        <div class="modal-content">
          <form id="editUserForm" action="../functions/manageuser_function.php" method="POST">
            <input type="hidden" id="editUserId" name="user_id">

            <label for="editUsername">Username:</label>
            <input type="text" id="editUsername" name="username" required>

            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" name="email" required>

            <label for="editRole">Role:</label>
            <select id="editRole" name="role" required>
              <option value="super_admin">Super Admin</option>
              <option value="admin">Admin</option>
              <option value="staff">Staff</option>
            </select>

            <label for="editStatus">Status:</label>
            <select id="editStatus" name="status" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>


            <label for="editPassword">Password:</label>
            <input type="password" id="editPassword" name="password" placeholder="Leave blank to keep unchanged">

            <div class="modal-buttons">
              <button type="submit" name="updateUser" class="save-btn">Save Changes</button>
              <button type="button" class="cancel-btn" onclick="closeModal('editModal')">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete User Modal -->
      <div id="deleteModal" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModal('deleteModal')">&times;</span>
          <h2>Are you sure you want to delete this user?</h2>
          <form id="deleteForm" method="POST" action="../functions/delete_user.php">
            <input type="hidden" name="user_id" id="deleteUserId">
            <button type="submit" name="deleteUser">Yes, Delete</button>
            <button type="button" class="cancel" onclick="closeModal('deleteModal')">Cancel</button>
          </form>
        </div>
      </div>

      <!-- Users Table -->
      <div class="table-container">
        <table id="usersTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $conn->query("SELECT * FROM users");
            while ($row = $stmt->fetch()) {
              echo "<tr>";
              echo "<td>" . $row['user_id'] . "</td>";
              echo "<td>" . $row['username'] . "</td>";
              echo "<td>" . $row['email'] . "</td>";
              echo "<td>" . $row['role'] . "</td>";
              echo "<td>" . $row['status'] . "</td>";
              echo "<td>";
              echo "<div class='button-container'>
                      <button class='edit-btn' onclick=\"editUser(" . $row['user_id'] . ")\"><i class='ri-pencil-line'></i></button>
                      <button class='delete-btn' onclick=\"deleteUser(" . $row['user_id'] . ")\"><i class='ri-delete-bin-line'></i></button>
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
  <script src="assets/js/usermangement.js"></script>
</body>

</html>