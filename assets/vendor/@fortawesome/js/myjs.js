
document.addEventListener("DOMContentLoaded", function () {
    // Get a reference to the cancel button
    var cancelButton = document.getElementById("cancel-button");

    // Get a reference to the modal
    var modal = document.getElementById("modal-form");

    // Add a click event listener to the cancel button
    cancelButton.addEventListener("click", function () {
        // Use Bootstrap's modal function to close the modal
        $(modal).modal("hide");
    });
});
		
