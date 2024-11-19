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

/*=============== TOGGLE DROPDOWN MENU ===============*/
const inventoryLink = document.getElementById("inventory-link");
const inventorySubmenu = document.getElementById("inventory-submenu");

if (inventoryLink && inventorySubmenu) {
  inventoryLink.addEventListener("click", (event) => {
    // Prevent the default link behavior to stay on the same page
    event.preventDefault();
    // Toggle the visibility of the submenu
    inventorySubmenu.classList.toggle("show-submenu");
  });
}

// Open modal to create a new supplier
function openCreateSupplierModal() {
  document.getElementById("createSupplierModal").style.display = "block";
}

// Close the create supplier modal
function closeCreateSupplierModal() {
  document.getElementById("createSupplierModal").style.display = "none";
}

// Open edit supplier modal with existing supplier data
function editSupplier(supplierId) {
  fetch(
    `../functions/managesupplier_function.php?action=get_supplier&id=${supplierId}`
  )
    .then((response) => response.json())
    .then((supplier) => {
      // Populate the edit form
      document.getElementById("editSupplierId").value = supplier.supplier_id;
      document.getElementById("editSupplierName").value =
        supplier.supplier_name;
      document.getElementById("editContactName").value = supplier.contact_name;
      document.getElementById("editPhone").value = supplier.phone;
      document.getElementById("editEmail").value = supplier.email;
      document.getElementById("editAddress").value = supplier.address;
      document.getElementById("editSupplierModal").style.display = "block";
    });
}

// Close the modal
function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none";
}

// Function to open the delete modal
function deleteSupplier(supplierId) {
  document.getElementById("deleteSupplierId").value = supplierId; // Set the supplier ID to the hidden field
  document.getElementById("deleteSupplierModal").style.display = "block"; // Show the modal
}
