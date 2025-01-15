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

function handleScroll(column) {
  const transformWeight = document.getElementById("transformWeight").value;
  const maxOffset = 1600;

  console.log(column);
  const img = column.querySelector(".img");
  if (!img) return;

  // clear current timeout (for this column)
  if (scrollTimeouts.has(column)) {
    clearTimeout(scrollTimeouts.get(column));
  }

  if (isParallaxScroll) {
    const scrollTop = column.scrollTop / transformWeight;
    const scrollTopWeighted = column.scrollTop / 80;
    img.style.transform = `translateY(${scrollTop}px) skew(${scrollTopWeighted}deg)`;
  } else {
    const timeout = setTimeout(() => {
      const newPos = getRandomPosition(maxOffset);
      currentPositions.set(img, newPos);
      img.style.transition =
        "transform 2s cubic-bezier(.19,1,.22,1), filter 3s ease-in-out";
      img.style.transform = `translate(${newPos.x}px, ${newPos.y}px)`;
    }, 30);
    scrollTimeouts.set(column, timeout);
  }
}

// on/off layering
// document.getElementById("scrollMode").addEventListener("click", () => {
//   document.querySelectorAll(".column").forEach((column) => {
//     const img = column.querySelector(".img");
//     if (!img) return;

//     // current scroll position
//     const transformWeight = document.getElementById("transformWeight").value;
//     const scrollTop = column.scrollTop / transformWeight;
//     const scrollTopWeighted = column.scrollTop / 80;

//     // 1. enable transition
//     img.style.transition = "transform 1s ease-out";

//     // 2. toggle mode w delay
//     setTimeout(() => {
//       isParallaxScroll = !isParallaxScroll;

//       // Apply the transform based on new mode
//       img.style.transform = isParallaxScroll
//         ? `translateY(${scrollTop}px) skew(${scrollTopWeighted}deg)`
//         : "none";

//       // 3. reset
//       img.style.filter = "none";
//       currentPositions.delete(img);
//     }, 50);
//   });

//   scrollTimeouts.clear();
//   document.getElementById("scrollMode").textContent = isParallaxScroll
//     ? "roaming"
//     : "parallax";
// });

function checkMobile() {
  if (window.innerWidth <= 768) {
    document.body.classList.add("mobile");
  } else {
    document.body.classList.remove("mobile");
  }
}

// Add event listeners for document load and window resize
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
    const mobileIcon = document.querySelector(".mobile-icon");

    if (mobileIcon) {
      window.addEventListener("scroll", () => {
        const scrollTop = window.scrollY;
        const transformWeight = 20;
        const scrollTopWeighted = scrollTop / transformWeight;

        mobileIcon.style.transform = `translateY(${scrollTopWeighted}px) translateX(${scrollTopWeighted}px)`;
      });
    }
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
  document.querySelectorAll(".prompt--input").forEach((promptElement) => {
    promptElement.textContent = prompt.text;
  });

  document.querySelectorAll(".prompt-icon").forEach((icon) => {
    icon.style.display = icon.dataset.icon === prompt.icon ? "flex" : "none";
  });

  // set hidden input value (zero-padded index)
  const currentPromptTitle =
    "p-" + currentPromptIndex.toString().padStart(2, "0");

  document.querySelectorAll(".current_prompt").forEach((input) => {
    input.value = currentPromptTitle;
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
// document.getElementById("prompt--next").addEventListener("click", nextPrompt);
document.querySelectorAll(".prompt--next").forEach((button) => {
  button.addEventListener("click", nextPrompt);
});

function getTimeOfDay() {
  const now = new Date();
  const hour = now.getHours();
  if (hour < 6) return "night";
  if (hour < 12) return "day";
  if (hour < 18) return "dusk";
  return "dawn";
}

function changeMode(button) {
  const modeElements = document.querySelectorAll(".mode");

  // use first element to check current state
  const currentMode = modeElements[0].textContent;

  if (currentMode === "high contrast") {
    modeElements.forEach((element) => {
      element.textContent = "burrowing";
    });

    // document.getElementById("timeOfDay").style.display = "block";

    const timeOfDay = getTimeOfDay();
    document.body.classList.toggle(timeOfDay + "-background");
    document.body.classList.toggle(timeOfDay + "-foreground");
    document.body.classList.toggle("mode-high-contrast");
  } else {
    modeElements.forEach((element) => {
      element.textContent = "high contrast";
    });

    // document.getElementById("timeOfDay").style.display = "none";
    document.body.className = "";
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
    icon.style.display = icon.style.display === "block" ? "none" : "block";
  });
}

// document.getElementById("timeOfDay").addEventListener("change", function () {
//   // rm old classes, then add time-based classes
//   const classes = document.body.classList;
//   const classArray = Array.from(classes);
//   classArray.forEach((className) => {
//     if (className !== "burrowing") {
//       classes.remove(className);
//     }
//   });
//   classes.add(this.value + "-background");
//   classes.add(this.value + "-foreground");
// });

// init first prompt
updatePromptDisplay();
