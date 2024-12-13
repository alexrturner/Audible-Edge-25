// get time in perth
const getTime = () => {
  const date = new Date();
  return date.toLocaleTimeString("en-US", {
    hour: "2-digit",
    minute: "2-digit",
  });
};
function updateTime() {
  const time = getTime();
  document.querySelector(".hour").textContent = time.split(":")[0];
  document.querySelector(".minute").textContent = time.split(":")[1];
}
updateTime();

// scrolls
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

// const prompts = Array.from(document.querySelectorAll(".prompt-icon")).map(
//   (icon) => ({
//     text: icon.dataset.prompt,
//     icon: icon.dataset.icon,
//   })
// );
// // track remaining prompts
// let availablePrompts = [...prompts];
// let currentPromptIndex = 0;

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
  const promptElement = document.getElementById("prompt--input");

  document.querySelectorAll(".prompt-icon").forEach((icon) => {
    icon.style.display = icon.dataset.icon === prompt.icon ? "block" : "none";
  });

  promptElement.textContent = prompt.text;
  // set hidden input value

  // zero-padded index
  const currentPromptTitle =
    "p-" + currentPromptIndex.toString().padStart(2, "0");
  document.getElementById("current_prompt").value = currentPromptTitle;
  document.getElementById("current_prompt_text").value = prompt.text;
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
document.getElementById("prompt--next").addEventListener("click", nextPrompt);

// burrowing
function changeMode(button) {
  const modeSpan = document.getElementById("mode");
  if (modeSpan.textContent === "high contrast") {
    modeSpan.textContent = "onion skin";
  } else {
    modeSpan.textContent = "high contrast";
  }

  const images = document.querySelectorAll(".img img");
  images.forEach((img) => {
    img.style.display = img.style.display === "block" ? "none" : "block";
  });
  document.body.classList.toggle("burrowing");
}

// init first prompt
updatePromptDisplay();

// document
//   .getElementById("audioUploadForm")
//   .addEventListener("submit", async (e) => {
//     // e.preventDefault();

//     const formData = new FormData(e.target);
//     console.log(formData);
//     try {
//       const response = await fetch(e.target.action, {
//         method: "POST",
//         body: formData,
//       });

//       const result = await response.text();

//       // If successful, move to next prompt AND remove current one
//       if (result.includes("success")) {
//         userUpload(); // This removes current prompt and shows next available one
//       }
//     } catch (error) {
//       console.error("Upload failed:", error);
//     }
//   });
