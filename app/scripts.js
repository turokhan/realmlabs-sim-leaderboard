document.addEventListener("DOMContentLoaded", function () {
    const popupForm = document.getElementById("popupForm");

    window.openForm = function () {
        if (!popupForm) {
            console.error("popupForm element not found.");
            return;
        }

        popupForm.style.display = "flex";
        document.body.style.overflow = "hidden";
    };

    window.closeForm = function () {
        if (!popupForm) {
            return;
        }

        popupForm.style.display = "none";
        document.body.style.overflow = "";
    };

    // Close popup when clicking the dark background
    if (popupForm) {
        popupForm.addEventListener("click", function (event) {
            if (event.target === popupForm) {
                closeForm();
            }
        });
    }

    // Close popup with Escape key
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && popupForm) {
            closeForm();
        }
    });
});