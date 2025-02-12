// not the early morning transitions, full daylight, evening transitions, darkness
function getTimeOfDayLabel() {
  const now = new Date();
  const hour = now.getHours();
  if (hour >= 3 && hour < 9) return "dawn";
  if (hour >= 9 && hour < 15) return "day";
  if (hour >= 15 && hour < 21) return "dusk";
  return "night";
}
// scroll behaviours
let scrollTimeouts = new Map();
let currentPositions = new Map();

function getRandomPosition(maxOffset) {
  return {
    x: Math.random() * maxOffset - maxOffset / 2,
    y: Math.random() * maxOffset - maxOffset / 2,
  };
}
const columnAnimationLocks = new Map();

function handleScroll(column) {
  // requestAnimationFrame
  if (column.scrollRAF) {
    cancelAnimationFrame(column.scrollRAF);
  }

  column.scrollRAF = requestAnimationFrame(() => {
    const transformWeight = 5;
    const maxOffset = 1600;

    const img = column.querySelector(".icon__swamp");
    // console.log(img);
    if (!img) return;

    // is this column is currently locked (animating)?
    if (columnAnimationLocks.get(column)) {
      return;
    }

    // clear pending timeouts
    if (scrollTimeouts.has(column)) {
      clearTimeout(scrollTimeouts.get(column));
    }

    const newPos = getRandomPosition(maxOffset);
    currentPositions.set(img, newPos);
    img.style.transform = `translate(${newPos.x}px, ${newPos.y}px)`;

    // lock column for animations
    columnAnimationLocks.set(column, true);

    const unlockTimeout = setTimeout(() => {
      columnAnimationLocks.set(column, false);
    }, 1000);

    scrollTimeouts.set(column, unlockTimeout);
  });
}

function checkMobile() {
  const playButton = document.getElementById("toggle-mix");
  const desktopContainer = document.querySelector(
    ".row.desktop.settings.ancillary"
  );
  const mobileContainer = document.querySelector(
    ".mobile.header .row.viewing .space"
  );

  if (window.innerWidth <= 768) {
    document.body.classList.add("mobile");
    // move play button to mobile container, if it exists
    if (playButton && mobileContainer) {
      mobileContainer.appendChild(playButton);
    }
  } else {
    document.body.classList.remove("mobile");
    if (playButton && desktopContainer) {
      desktopContainer.appendChild(playButton);
    }
  }
}

// check on load & resize window resize
document.addEventListener("DOMContentLoaded", checkMobile);
window.addEventListener("resize", checkMobile);

// desktop scroll logic
document.addEventListener("DOMContentLoaded", function () {
  const columns = document.querySelectorAll(".column");
  columns.forEach((column) => {
    column.addEventListener("scroll", () => handleScroll(column));
  });

  // mobile scroll logic
  // check mobile
  checkMobile();

  if (document.body.classList.contains("mobile")) {
    let isAnimating = false;

    window.addEventListener("scroll", () => {
      if (!isAnimating) {
        isAnimating = true;

        const imgs = document.querySelectorAll(".icon__swamp");
        imgs.forEach((img) => {
          const newPos = getRandomPosition(400);
          img.style.transform = `translate(${newPos.x}px, ${newPos.y}px)`;
        });

        // wait before next call
        setTimeout(() => {
          isAnimating = false;
        }, 500);
      }
    });
  }
});

// change mode
function setHighlightColors() {
  const timeOfDay = getTimeOfDayLabel();
  const root = document.documentElement;

  // set highlight colors based on time of day
  root.style.setProperty(
    "--cc-highlight-background",
    `var(--cc-${timeOfDay}-background)`
  );
  root.style.setProperty(
    "--cc-highlight-foreground",
    `var(--cc-${timeOfDay}-foreground)`
  );
}
document.body.dataset.timeOfDay = getTimeOfDayLabel();
setHighlightColors();

function changeMode(button) {
  const modeElements = document.querySelectorAll(".mode");

  // use first element to check current state
  const currentMode = modeElements[0].textContent;

  if (currentMode === "high contrast") {
    modeElements.forEach((element) => {
      element.textContent = "burrowing";
    });

    const timeOfDay = document.body.dataset.timeOfDay;
    document.body.classList.toggle(timeOfDay + "-background");
    document.body.classList.toggle(timeOfDay + "-foreground");
    document.body.classList.toggle("mode-high-contrast");
  } else {
    modeElements.forEach((element) => {
      element.textContent = "high contrast";
    });

    // reset classes, then add high contrast
    document.body.className = "";
    checkMobile();
    document.body.classList.toggle("mode-high-contrast");
  }

  // sync checkbox states
  const checkboxes = document.querySelectorAll(
    'input[type="checkbox"][id^="toggle-mode-"]'
  );
  checkboxes.forEach((checkbox) => {
    checkbox.checked = currentMode === "high contrast";
  });
  // show time of day selector

  const icons = document.querySelectorAll(".icon__swamp svg");
  // console.log(icons);
  icons.forEach((icon) => {
    // icon.style.display = icon.style.display === "block" ? "none" : "block";
    icon.style.opacity = icon.style.opacity === "1" ? "0" : "1";
  });
}

addEventListener("DOMContentLoaded", () => {
  let changeModeButtons = document.querySelectorAll(".mode");
  changeModeButtons.forEach((button) => {
    button.addEventListener("click", () => {
      changeMode(button);
    });
  });
});
