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
updateTime();

// not the early morning transitions, full daylight, evening transitions, darkness
function getTimeOfDayLabel() {
  const now = new Date();
  const hour = now.getHours();
  if (hour < 6) return "night";
  if (hour < 12) return "day";
  if (hour < 18) return "dusk";
  return "dawn";
}

// scroll behaviours
// default: burrow scroll, no noise floor
let isParallaxScroll = false;
let isNoiseEnabled = false;
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
  if (column.scrollRAF) {
    cancelAnimationFrame(column.scrollRAF);
  }

  column.scrollRAF = requestAnimationFrame(() => {
    const transformWeight = 5;
    const maxOffset = 1600;

    const img = column.querySelector(".img");
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

        const imgs = document.querySelectorAll(".img");
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

  const icons = document.querySelectorAll(".img svg");
  icons.forEach((icon) => {
    // icon.style.display = icon.style.display === "block" ? "none" : "block";
    icon.style.opacity = icon.style.opacity === "1" ? "0" : "1";
  });
}

// init first prompt
updatePromptDisplay();
