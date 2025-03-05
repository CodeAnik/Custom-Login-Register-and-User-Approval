document.addEventListener("DOMContentLoaded", function () {
    let profileUpdated = new URLSearchParams(window.location.search).get("updated");
    if (profileUpdated) {
        alert("Your profile has been updated successfully!");
    }
});
