// document.addEventListener("DOMContentLoaded", function () {
//   // non-home pages - toggle overlay on menu click
//   const toggleButton = document.querySelector(".menu-toggle");
//   const overlay = document.querySelector(".overlay");
//   const menu = document.getElementById("menu-items");

//   console.log(toggleButton);
//   toggleButton.addEventListener("click", function () {
//     const isOpen = overlay.style.visibility === "visible";
//     overlay.style.opacity = isOpen ? "0" : "1";
//     overlay.style.visibility = isOpen ? "hidden" : "visible";
//     menu.classList.toggle("hidden");
//     // toggle body scroll
//   });
// });

document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.querySelector(".menu-toggle");
  const menuItems = document.querySelector(".items");

  menuToggle.addEventListener("click", function () {
    const isExpanded = menuToggle.getAttribute("aria-expanded") === "true";
    menuToggle.setAttribute("aria-expanded", !isExpanded);
    menuItems.classList.toggle("hidden__visibility");
  });
});
