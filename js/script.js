function togglePostForm() {
    var formContainer = document.getElementById("post-form-container");
    var overlay = document.getElementById("overlay");

    if (formContainer.style.display === "none") {
        formContainer.style.display = "block";
        overlay.style.display = "block";
    } else {
        formContainer.style.display = "none";
        overlay.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("post-form").addEventListener("submit", function(event) {
        event.preventDefault();
        togglePostForm();
    });
});