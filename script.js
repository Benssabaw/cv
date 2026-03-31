document.addEventListener("DOMContentLoaded", () => {
    const fileInput = document.getElementById("profilePic");
    const imagePreview = document.getElementById("imagePreview");

    fileInput.addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener("load", function() {
                imagePreview.setAttribute("src", this.result);
                imagePreview.style.display = "block";
            });
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = "none";
        }
    });
});
