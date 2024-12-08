document.addEventListener("DOMContentLoaded", function () {
  const galleryContainer = document.querySelector(".gallery-container");
  if (galleryContainer) {
    const images = galleryContainer.querySelectorAll("figure");
    let currentIndex = 0;
    const countElem = galleryContainer.querySelector(".current");
    const totalImages = images.length;

    const updateGalleryCount = () => {
      if (countElem) countElem.textContent = `${currentIndex + 1}`;
    };

    const showImage = (index) => {
      images.forEach((img, i) => {
        img.style.display = i === index ? "flex" : "none";
      });
      updateGalleryCount();
    };

    if (totalImages > 1) {
      galleryContainer
        .querySelector(".gallery-prev")
        .addEventListener("click", () => {
          currentIndex = (currentIndex - 1 + totalImages) % totalImages;
          showImage(currentIndex);
        });

      galleryContainer
        .querySelector(".gallery-next")
        .addEventListener("click", () => {
          currentIndex = (currentIndex + 1) % totalImages;
          showImage(currentIndex);
        });
    }
    // show the first image and update count
    showImage(currentIndex);
  }
});
