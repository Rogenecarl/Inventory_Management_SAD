/*=============== SHOW SIDEBAR ===============*/
const showSidebar = (toggleId, sidebarId, headerId, mainId) => {
  const toggle = document.getElementById(toggleId),
    sidebar = document.getElementById(sidebarId),
    header = document.getElementById(headerId),
    main = document.getElementById(mainId);

  if (toggle && sidebar && header && main) {
    toggle.addEventListener("click", () => {
      /* Show sidebar */
      sidebar.classList.toggle("show-sidebar");
      /* Add padding header */
      header.classList.toggle("left-pd");
      /* Add padding main */
      main.classList.toggle("left-pd");
    });
  }
};
showSidebar("header-toggle", "sidebar", "header", "main");

/*=============== LINK ACTIVE ===============*/
const sidebarLink = document.querySelectorAll(".sidebar__list a");

function linkColor() {
  sidebarLink.forEach((l) => l.classList.remove("active-link"));
  this.classList.add("active-link");
}

sidebarLink.forEach((l) => l.addEventListener("click", linkColor));

/*=============== DARK LIGHT THEME ===============*/
const themeButton = document.getElementById("theme-button");
const darkTheme = "dark-theme";
const iconTheme = "ri-sun-fill";

// Previously selected topic (if user selected)
const selectedTheme = localStorage.getItem("selected-theme");
const selectedIcon = localStorage.getItem("selected-icon");

// We obtain the current theme that the interface has by validating the dark-theme class
const getCurrentTheme = () =>
  document.body.classList.contains(darkTheme) ? "dark" : "light";
const getCurrentIcon = () =>
  themeButton.classList.contains(iconTheme)
    ? "ri-moon-clear-fill"
    : "ri-sun-fill";

// We validate if the user previously chose a topic
if (selectedTheme) {
  // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
  document.body.classList[selectedTheme === "dark" ? "add" : "remove"](
    darkTheme
  );
  themeButton.classList[
    selectedIcon === "ri-moon-clear-fill" ? "add" : "remove"
  ](iconTheme);
}

// Activate / deactivate the theme manually with the button
themeButton.addEventListener("click", () => {
  // Add or remove the dark / icon theme
  document.body.classList.toggle(darkTheme);
  themeButton.classList.toggle(iconTheme);
  // We save the theme and the current icon that the user chose
  localStorage.setItem("selected-theme", getCurrentTheme());
  localStorage.setItem("selected-icon", getCurrentIcon());
});

const editButtons = document.querySelectorAll(".btn-warning");
editButtons.forEach((button) => {
  button.addEventListener("click", function () {
    const productId = this.getAttribute("data-id");
    const productName = this.getAttribute("data-name");
    // Populate the modal fields with existing product data for editing
  });
});

// Open Create Product Modal
function openCreateProductModal() {
  document.getElementById('createProductModal').style.display = 'block';
}

// Close Create Product Modal
function closeCreateProductModal() {
  document.getElementById('createProductModal').style.display = 'none';
}


// Open edit product modal with existing product data
function editProduct(productId) {
  fetch(
    `../functions/manageproduct_function.php?action=get_product&id=${productId}`
  )
    .then((response) => response.json())
    .then((product) => {
      // Populate the edit form with product data
      document.getElementById("editProductId").value = product.product_id;
      document.getElementById("editProductName").value = product.name;
      document.getElementById("editCategoryId").value = product.category_id;
      document.getElementById("editSupplierId").value = product.supplier_id;
      document.getElementById("editBrand").value = product.brand;
      document.getElementById("editModel").value = product.model;
      document.getElementById("editPrice").value = product.price;
      document.getElementById("editQuantity").value = product.quantity;

      // Open the edit modal
      document.getElementById("editProductModal").style.display = "block";
    });
}

// Open the delete product modal
function deleteProduct(productId) {
  document.getElementById("deleteProductId").value = productId; // Set product ID
  document.getElementById("deleteProductModal").style.display = "block"; // Show modal
}

// Close any modal
function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none"; // Hide modal
}

// Function to load categories and suppliers dynamically for the modals
function loadCategoriesAndSuppliers() {
  // Load categories
  fetch("../functions/manageproduct_function.php?action=get_categories")
    .then((response) => response.json())
    .then((categories) => {
      const categorySelect = document.getElementById("category_id");
      categorySelect.innerHTML = categories
        .map(
          (category) =>
            `<option value="${category.category_id}">${category.category_name}</option>`
        )
        .join("");
    });

  // Load suppliers
  fetch("../functions/manageproduct_function.php?action=get_suppliers")
    .then((response) => response.json())
    .then((suppliers) => {
      const supplierSelect = document.getElementById("supplier_id");
      supplierSelect.innerHTML = suppliers
        .map(
          (supplier) =>
            `<option value="${supplier.supplier_id}">${supplier.supplier_name}</option>`
        )
        .join("");
    });
}
