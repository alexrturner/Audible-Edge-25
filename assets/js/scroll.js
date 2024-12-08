const handleTouchStart = function (e) {
  this.touchStartY = e.touches[0].clientY;
};

const touchContext = { touchStartY: 0 };

const handleTouchMove = function (e) {
  e.preventDefault();
  const touchEndY = e.touches[0].clientY;
  const deltaY = this.touchStartY - touchEndY;
  const col3 = document.getElementById("col3");
  col3.scrollTop += deltaY;
  this.touchStartY = touchEndY;
}.bind(touchContext);

const handleWheel = function (e) {
  e.preventDefault();
  const col3 = document.getElementById("col3");
  col3.scrollTop += e.deltaY;
};

let customScrollHandlingAdded = false;

// add custom scroll handling
function addCustomScrollHandling() {
  // early exit
  if (customScrollHandlingAdded) return;

  window.addEventListener("touchstart", handleTouchStart.bind(touchContext), {
    passive: false,
  });
  window.addEventListener("touchmove", handleTouchMove, { passive: false });
  window.addEventListener("wheel", handleWheel, { passive: false });

  customScrollHandlingAdded = true;
}

function removeCustomScrollHandling() {
  if (!customScrollHandlingAdded) return;

  window.removeEventListener(
    "touchstart",
    handleTouchStart.bind(touchContext),
    { passive: false }
  );
  window.removeEventListener("touchmove", handleTouchMove, { passive: false });
  window.removeEventListener("wheel", handleWheel, { passive: false });

  customScrollHandlingAdded = false;
}

// desktop check
if (window.innerWidth >= 768) {
  addCustomScrollHandling();
}

// handle window resizing
window.addEventListener("resize", function () {
  if (window.innerWidth >= 768 && !customScrollHandlingAdded) {
    addCustomScrollHandling();
  } else if (window.innerWidth < 768 && customScrollHandlingAdded) {
    removeCustomScrollHandling();
  }
});
