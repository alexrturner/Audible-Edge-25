document.addEventListener("DOMContentLoaded", function () {
  // non-home pages - toggle overlay on menu click
  const toggleButton = document.querySelector(".menu-toggle");
  const overlay = document.querySelector(".overlay");
  const menu = document.getElementById("menu-items");

  toggleButton.addEventListener("click", function () {
    const isOpen = overlay.style.visibility === "visible";
    overlay.style.opacity = isOpen ? "0" : "1";
    overlay.style.visibility = isOpen ? "hidden" : "visible";
    menu.classList.toggle("hidden");
    // toggle body scroll

    if (window.innerWidth <= 768) {
      if (!document.body.classList.contains("plain-text")) {
        if (!isOpen) {
          document.body.style.overflowY = "hidden";
        } else {
          document.body.style.overflowY = "scroll";
        }
      }
    }
  });
});
