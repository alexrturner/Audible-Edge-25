// time handling (boorloo)
function updateTime() {
  const now = new Date();
  const localTime = new Date(
    now.toLocaleString("en-US", { timeZone: "Australia/Perth" })
  );

  const hour = localTime.getHours().toString().padStart(2, "0");
  const minute = localTime.getMinutes().toString().padStart(2, "0");

  document.querySelector(".hour").textContent = hour;
  document.querySelector(".minute").textContent = minute;

  const msTillNextMinute =
    60000 - (localTime.getSeconds() * 1000 + localTime.getMilliseconds());

  // schedule next update for start of next minute
  setTimeout(updateTime, msTillNextMinute);
}
const timeContainer = document.getElementById("time-is-now");
if (timeContainer) {
  updateTime();
}

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
    // if (playButton && desktopContainer) {
    //   desktopContainer.appendChild(playButton);
    // }
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

///////////
// prompt handling

// scroll content into view
const prompts = Array.from(document.querySelectorAll(".prompt-icon"));
let availablePrompts = [...prompts];
let currentPromptIndex = 0;

const getPrompt = () => {
  if (availablePrompts.length === 0) {
    // reset the prompts when all are used
    availablePrompts = [...prompts];
    currentPromptIndex = 0;
  }
  const prompt = availablePrompts[currentPromptIndex];
  return {
    text: prompt.dataset.prompt,
    icon: prompt.dataset.icon,
  };
};

const updatePromptDisplay = () => {
  const prompt = getPrompt();

  // update prompt text
  document.querySelectorAll(".prompt--input").forEach((promptElement) => {
    promptElement.textContent = prompt.text;
  });

  // update visible prompt icon
  document.querySelectorAll(".prompt-icon").forEach((icon) => {
    icon.style.display = icon.dataset.icon === prompt.icon ? "flex" : "none";
  });

  // get filename w/o extension ("01.svg" -> "01")
  const promptNumber = prompt.icon.split(".")[0];

  // update hidden inputs
  document.querySelectorAll(".current_prompt").forEach((input) => {
    input.value = promptNumber;
  });
  document.querySelectorAll(".current_prompt_text").forEach((input) => {
    input.value = prompt.text;
  });
};

const userUpload = () => {
  if (availablePrompts.length > 0) {
    // rm current prompt
    availablePrompts.splice(currentPromptIndex, 1);

    // adjust index
    if (currentPromptIndex >= availablePrompts.length) {
      currentPromptIndex = 0;
    }

    updatePromptDisplay();
  }
};

const nextPrompt = () => {
  // cycle through ALL prompts without removing any
  currentPromptIndex = (currentPromptIndex + 1) % availablePrompts.length;
  updatePromptDisplay();
};

// listen for next prompt
document.querySelectorAll(".prompt--next").forEach((button) => {
  button.addEventListener("click", nextPrompt);
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

  // only add extra height if the column isn't scrollable
  if (currentMode === "high contrast") {
    const columns = document.querySelectorAll(".column");
    columns.forEach((column) => {
      const scrollHeight = column.scrollHeight;
      const clientHeight = column.clientHeight;

      if (scrollHeight <= clientHeight) {
        column.classList.remove("min-height");
      }
    });
  } else {
    const columns = document.querySelectorAll(".column");
    columns.forEach((column) => {
      column.classList.add("min-height");
    });
  }

  if (currentMode === "high contrast") {
    modeElements.forEach((element) => {
      element.textContent = "burrowing";
    });

    const timeOfDay = document.body.dataset.timeOfDay;
    document.body.classList.toggle(timeOfDay + "-background");
    document.body.classList.toggle(timeOfDay + "-foreground");
    document.body.classList.toggle("mode-high-contrast");
    // Save mode to localStorage
    localStorage.setItem("viewMode", "burrowing");
  } else {
    modeElements.forEach((element) => {
      element.textContent = "high contrast";
    });

    // reset classes, then add high contrast
    document.body.className = "";
    checkMobile();
    document.body.classList.toggle("mode-high-contrast");
    // Save mode to localStorage
    localStorage.setItem("viewMode", "high-contrast");
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

function applySavedMode() {
  const savedMode = localStorage.getItem("viewMode");
  if (savedMode === "burrowing") {
    const modeButton = document.querySelector(".mode");
    changeMode(modeButton);

    // Ensure checkbox is checked
    const checkboxes = document.querySelectorAll(
      'input[type="checkbox"][id^="toggle-mode"]'
    );
    checkboxes.forEach((checkbox) => {
      checkbox.checked = true;
    });
  }
}

addEventListener("DOMContentLoaded", () => {
  applySavedMode();

  let changeModeButtons = document.querySelectorAll(".mode");
  changeModeButtons.forEach((button) => {
    button.addEventListener("click", () => {
      changeMode(button);
    });
  });
});

const promptContainer = document.querySelector(".audio-container");
if (promptContainer) {
  updatePromptDisplay();
}

// tooltip
document.addEventListener("DOMContentLoaded", function () {
  const descriptors = document.querySelectorAll(".descriptor");

  if (descriptors.length > 0) {
    const tooltip = document.createElement("div");
    tooltip.className = "tooltip";
    document.body.appendChild(tooltip);

    // event listeners to all descriptors
    descriptors.forEach((img) => {
      img.addEventListener("mousemove", (e) => {
        tooltip.style.display = "block";
        tooltip.textContent = img.dataset.tooltip;

        tooltip.style.left = e.pageX + 10 + "px";
        tooltip.style.top = e.pageY + 10 + "px";
      });

      img.addEventListener("mouseleave", () => {
        tooltip.style.display = "none";
      });
    });
  }
});

function initSingleColumnScrollAnimation() {
  const swampIcons = document.querySelectorAll(".icon__swamp");
  if (swampIcons.length === 0) return;

  // check if single column page (events listings)
  const columns = document.querySelectorAll(".column");
  if (columns.length > 0) return;

  const pageHeight = document.documentElement.scrollHeight;
  const maxHorizontalOffset = 400;

  swampIcons.forEach((img) => {
    const newPos = {
      x: Math.random() * maxHorizontalOffset - maxHorizontalOffset / 2,
      y: Math.random() * pageHeight * 0.9, // use 90% of page height
    };
    img.style.transform = `translate(${newPos.x}px, ${newPos.y}px)`;
  });
}

// init on load
document.addEventListener("DOMContentLoaded", initSingleColumnScrollAnimation);
