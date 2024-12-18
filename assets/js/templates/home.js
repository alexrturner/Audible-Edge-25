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

  // noise floor by distance
  if (isNoiseEnabled) {
    const scrollDistance = Math.abs(column.scrollTop);
    const maxScroll = column.scrollHeight - column.clientHeight;
    const noiseIntensity = Math.min(scrollDistance / maxScroll, 1); // cap it at 1
    img.style.filter = `grayscale(${noiseIntensity}) contrast(${
      1 + noiseIntensity
    })`;
  } else {
    img.style.filter = "none";
  }
}

// on/off burrow
document.getElementById("scrollMode").addEventListener("click", () => {
  document.querySelectorAll(".column").forEach((column) => {
    const img = column.querySelector(".img");
    if (!img) return;

    // current scroll position
    const transformWeight = document.getElementById("transformWeight").value;
    const scrollTop = column.scrollTop / transformWeight;
    const scrollTopWeighted = column.scrollTop / 80;

    // 1. enable transition
    img.style.transition = "transform 1s ease-out";

    // 2. toggle mode w delay
    setTimeout(() => {
      isParallaxScroll = !isParallaxScroll;

      // Apply the transform based on new mode
      img.style.transform = isParallaxScroll
        ? `translateY(${scrollTop}px) skew(${scrollTopWeighted}deg)`
        : "none";

      // 3. reset
      img.style.filter = "none";
      currentPositions.delete(img);
    }, 50);
  });

  scrollTimeouts.clear();
  document.getElementById("scrollMode").textContent = isParallaxScroll
    ? "burrow scroll"
    : "parallax scroll";
});

// on/off noise
document.getElementById("noiseMode").addEventListener("click", () => {
  isNoiseEnabled = !isNoiseEnabled;
  document.querySelectorAll(".column .img").forEach((img) => {
    img.style.filter = "none";
  });
  //change text
  document.getElementById("noiseMode").textContent = isNoiseEnabled
    ? "++ noise"
    : "no noise";
});

document.addEventListener("DOMContentLoaded", function () {
  const columns = document.querySelectorAll(".column");
  columns.forEach((column) => {
    column.addEventListener("scroll", () => handleScroll(column));
  });
});

// scroll content into view

document.getElementById("content--info").addEventListener("click", () => {
  const subtitles = [
    {
      element: document.getElementById("btn-about"),
      delay: 0, // immediate
      duration: 400, // fast scroll
    },
    {
      element: document.getElementById("btn-accessibility"),
      delay: 100, // wait a bit
      duration: 400, // medium scroll
    },
    {
      element: document.getElementById("btn-acknowledgements"),
      delay: 200, // wait longer
      duration: 400, // slow scroll
    },
  ];

  subtitles.forEach(({ element, delay, duration }) => {
    setTimeout(() => {
      element.scrollIntoView({
        behavior: "smooth",
        block: "start", // or center
      });

      setTimeout(() => {
        element.style.transition = "background-color 0.3s";
        element.style.backgroundColor = "yellow";

        setTimeout(() => {
          element.style.backgroundColor = "";
        }, 400);
      }, duration);
    }, delay);
  });
});

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

// burrowing
function changeMode(button) {
  const modeElement = document.querySelector(".mode");
  if (modeElement.textContent === "high contrast") {
    modeElement.textContent = "onion skin";
  } else {
    modeElement.textContent = "high contrast";
  }

  const icons = document.querySelectorAll(".img svg");
  icons.forEach((icon) => {
    icon.style.display = icon.style.display === "block" ? "none" : "block";
  });
  document.body.classList.toggle("burrowing");
}

// init first prompt
updatePromptDisplay();
