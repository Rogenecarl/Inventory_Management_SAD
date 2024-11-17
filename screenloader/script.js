// Wait for the document to fully load
document.addEventListener("DOMContentLoaded", function () {
    const screenloader = document.querySelector(".screenloader");

    // Show the page load loader for 1 second
    screenloader.style.display = "flex";  // Show the page loader
    setTimeout(function () {
        screenloader.style.display = "none";  // Hide the page loader after 1 second
    }, 1000);
});
