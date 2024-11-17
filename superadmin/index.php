<?php
include '../functions/login_function.php'; // Include the login function
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet" href="screenloader/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Inventory Management</title>
    <style>
        .toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            right: 30px;
            /* Position the toast from the left */
            top: 90px;
            /* Position the toast from the top */
            font-size: 17px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .toast.success {
            background-color: #4CAF50;
        }

        .toast.error {
            background-color: #f44336;
        }

        #analyticsChart1,
        #analyticsChart2 {
            height: 50px;
            /* Change the height to 400px */
        }
    </style>
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
                        <a href="#" class="sidebar__link active-link">
                            <i class="ri-dashboard-line"></i>
                            <span>Dashboard</span>
                        </a>

                        <a href="usermanagement.php" class="sidebar__link">
                            <i class="ri-user-settings-fill"></i>
                            <span>User Management</span>
                        </a>

                        <a href="inventory.php" class="sidebar__link">
                            <i class="ri-git-repository-fill"></i>
                            <span>Inventory</span>
                        </a>

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
        <h1 class="dash-fix">Dashboard</h1>
        <div class="main__container">
            <!-- Column 1: Dashboard Cards -->
            <div class="dashboard-cards">
                <div class="card total-users">
                    <h3>Users</h3>
                    <p>10</p>
                </div>
                <div class="card total-products">
                    <h3>Products</h3>
                    <p>15</p>
                </div>
                <div class="card total-categories">
                    <h3>Categories</h3>
                    <p>5</p>
                </div>
                <div class="card low-stock">
                    <h3>Low Stock Items</h3>
                    <p>20</p>
                </div>
                <div class="card added-items">
                    <h3>New Added Items</h3>
                    <p>12</p>
                </div>
            </div>

            <!-- Column 2: Analytics with Two Charts -->
            <div class="analytics">
                <div class="analytics-card">
                    <h3>Inventory Analytics - Pie Chart</h3>
                    <canvas id="analyticsChart1" class="analytics-chart"></canvas>
                </div>
                <div class="analytics-card">
                    <h3>Inventory Analytics - Bar Chart</h3>
                    <canvas id="analyticsChart2" class="analytics-chart"></canvas>
                </div>
            </div>

            <!-- Column 3: Products Table -->
            <div class="products">
                <h3>Products Table</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Guitar</td>
                            <td>Strings</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Piano</td>
                            <td>Keyboard</td>
                            <td>5</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Column 4: Users Table -->
            <div class="users">
                <h3>Users Table</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>jane@example.com</td>
                            <td>Staff</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!--=============== MAIN JS ===============-->

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

    <!-- screen loader -->
    <div class="screenloader">
        <div class="loading-wave">
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
        </div>
    </div>

    <?php
    // Check if there is any message to show
    if (isset($_SESSION['toast_message'])) {
        $toast_message = $_SESSION['toast_message'];
        $toast_type = $_SESSION['toast_type'];

        echo "<script>
        // Set toast message content
        document.getElementById('toast').textContent = '$toast_message';
        // Add the toast type class (success/error)
        document.getElementById('toast').classList.add('$toast_type');
        // Show the toast
        document.getElementById('toast').style.visibility = 'visible';
        document.getElementById('toast').style.opacity = 1;
        
        // Hide the toast after 5 seconds
        setTimeout(function() {
            document.getElementById('toast').style.visibility = 'hidden';
            document.getElementById('toast').style.opacity = 0;
        }, 5000);
    </script>";

        // Clear the session variables after showing the message
        unset($_SESSION['toast_message']);
        unset($_SESSION['toast_type']);
    }
    ?>
    <script src="assets/js/main.js"></script>
    <script src="screenloader/script.js"></script>
    <script src="screenloader/script.js"></script>
</body>

</html>