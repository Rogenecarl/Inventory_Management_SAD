// Function to show toast notification
function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = 'toast ' + type; // Add class based on type (success/error)
    toast.style.visibility = 'visible';
    toast.style.opacity = 1;

    // Hide toast after 5 seconds
    setTimeout(function() {
        toast.style.visibility = 'hidden';
        toast.style.opacity = 0;
    }, 5000);
}

// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", function () {
    // Check if the toast message is available in the data attributes
    const toastMessage = document.getElementById('toast').dataset.message;
    const toastType = document.getElementById('toast').dataset.type;

    if (toastMessage && toastType) {
        // Show the toast if there is a message and type
        showToast(toastMessage, toastType);

        // Clear the data attributes after displaying the toast
        document.getElementById('toast').removeAttribute('data-message');
        document.getElementById('toast').removeAttribute('data-type');
    }
});
