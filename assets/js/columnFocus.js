//handle column focus
document.addEventListener("DOMContentLoaded", () => {
  const columns = document.querySelectorAll(".column");
  const scrollAmount = 100; // larger speeedy

  // focusable
  columns.forEach((column) => {
    column.setAttribute("tabindex", "0");
  });

  // track current
  let focusedColumnIdx = 0;

  // keyboard navigation
  document.addEventListener("keydown", (e) => {
    const focusedColumn = document.activeElement.closest(".column");
    if (!focusedColumn) return;

    switch (e.key) {
      case "ArrowUp":
        e.preventDefault();
        focusedColumn.scrollBy({
          top: -scrollAmount,
          behavior: "smooth",
        });
        break;

      case "ArrowDown":
        e.preventDefault();
        focusedColumn.scrollBy({
          top: scrollAmount,
          behavior: "smooth",
        });
        break;

      case "ArrowLeft":
        e.preventDefault();
        // find & focus prev column
        const prevColumn = focusedColumn.previousElementSibling;
        if (prevColumn && prevColumn.classList.contains("column")) {
          prevColumn.focus();
        }
        break;

      case "ArrowRight":
        e.preventDefault();
        // Find and focus next column
        const nextColumn = focusedColumn.nextElementSibling;
        if (nextColumn && nextColumn.classList.contains("column")) {
          nextColumn.focus();
        }
        break;
    }
  });

  // first col
  columns[0].focus();
});
