function changeMode(button) {
  const modeElements = document.querySelectorAll(".mode");

  // use first element to check current state
  const currentMode = modeElements[0].textContent;

  console.log(currentMode);
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
