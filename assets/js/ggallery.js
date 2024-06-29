document.addEventListener("DOMContentLoaded", function () {
    var lightbox = document.getElementById("lightbox");
    var lightboxImg = document.querySelector(".lightbox-content");
    var close = document.querySelector(".close");
    var allGalleryItems = Array.from(document.querySelectorAll(".ggallery-item img"));
    var galleryItems = allGalleryItems;
    var totalImages = galleryItems.length;
    var currentImageIndex = 0;

    function updateLightbox() {
        lightboxImg.src = galleryItems[currentImageIndex].src;
        document.getElementById("image-number").textContent = currentImageIndex + 1;
        document.getElementById("total-images").textContent = totalImages;
    }

    function showLightbox(index) {
        currentImageIndex = index;
        updateLightbox();
        lightbox.style.display = "block";
    }

    function attachClickEvents() {
        galleryItems.forEach(function (item, index) {
            item.addEventListener("click", function () {
                showLightbox(index);
            });
        });
    }

    attachClickEvents();

    close.addEventListener("click", function () {
        lightbox.style.display = "none";
    });

    lightbox.addEventListener("click", function (event) {
        if (event.target === lightbox) {
            lightbox.style.display = "none";
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            lightbox.style.display = "none";
        } else if (event.key === "ArrowLeft") {
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : totalImages - 1;
            updateLightbox();
        } else if (event.key === "ArrowRight") {
            currentImageIndex = currentImageIndex < totalImages - 1 ? currentImageIndex + 1 : 0;
            updateLightbox();
        }
    });

    document.getElementById("prev").addEventListener("click", function () {
        currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : totalImages - 1;
        updateLightbox();
    });

    document.getElementById("next").addEventListener("click", function () {
        currentImageIndex = currentImageIndex < totalImages - 1 ? currentImageIndex + 1 : 0;
        updateLightbox();
    });

    var filterItems = document.querySelectorAll(".ggallery-filters span");
    filterItems.forEach(function (filter) {
        filter.addEventListener("click", function () {
            var filterValue = this.getAttribute("data-filter");
            galleryItems =
                filterValue === "all"
                    ? allGalleryItems
                    : allGalleryItems.filter(function (item) {
                          return item.parentElement.getAttribute("data-category") === filterValue;
                      });
            totalImages = galleryItems.length;
            document.getElementById("total-images").textContent = totalImages;
            allGalleryItems.forEach(function (item) {
                if (
                    filterValue === "all" ||
                    item.parentElement.getAttribute("data-category") === filterValue
                ) {
                    item.parentElement.style.display = "block";
                } else {
                    item.parentElement.style.display = "none";
                }
            });
            attachClickEvents(); // Reattach click events after filtering
        });
    });
});
