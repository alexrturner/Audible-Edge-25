// - touch and scroll handling, specific to the col3 element
// - plain text view toggle functionality

document.addEventListener("DOMContentLoaded", function () {
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
    if (col3) {
      col3.scrollTop += e.deltaY;
    }
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
    window.removeEventListener("touchmove", handleTouchMove, {
      passive: false,
    });
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

  // function to toggle styles
  const togglePlainText = document.getElementById("togglePlainTextView");
  const settingsButton = document.getElementById("settingsButton");
  const settingsContainer = document.getElementById("settingsContainer");
  const plainTextContainer = document.getElementById("plainTextContainer");

  const body = document.body;
  const menuHeaderContainer = document.querySelector(
    ".menu-header-container-global"
  );
  const menuToggleButton = document.querySelector(".menu-toggle");
  const menuItems = document.getElementById("menu-items");
  const ulElements = document.querySelectorAll("ul");

  // update button text based on the new state
  const isDisabledStyles = localStorage.getItem("stylesDisabled") === "true";
  togglePlainText.textContent = !isDisabledStyles
    ? "Plain Text View"
    : "Styled Text View";

  function applyPlainTextStyles(enable) {
    if (enable) {
      body.classList.add("plain-text");
      // limit body width for ease of reading on large screens
      body.style.maxWidth = "60em";

      // add fixed position to menu header and plain text button
      if (menuHeaderContainer) {
        menuHeaderContainer.style.position = "fixed";
        menuHeaderContainer.style.right = "0.3rem";
        menuHeaderContainer.style.top = "2em";
      }
      if (plainTextContainer) {
        plainTextContainer.style.position = "fixed";
        plainTextContainer.style.right = "0.3rem";
        plainTextContainer.style.top = "0.5rem";
      }

      // if (menuToggleButton.attributes.expanded) {
      if (!body.classList.contains("home") && menuToggleButton) {
        menuToggleButton.setAttribute("expanded", "false");
        menuItems.style.visibility = "hidden";
        menuItems.style.opacity = "0";
        menuItems.style.pointerEvents = "none";
      }
      if (settingsContainer) {
        settingsButton.style.display = "none";
        settingsContainer.style.display = "none";
      }

      ulElements.forEach((ul) => {
        ul.style.margin = "0";
        ul.style.padding = "0";
      });

      // remove custom scroll handling in plain text mode
      removeCustomScrollHandling();
    } else {
      body.classList.remove("plain-text");
      body.style.maxWidth = "";
      if (menuHeaderContainer) {
        menuHeaderContainer.style.position = "";
        menuHeaderContainer.style.right = "";
        menuHeaderContainer.style.top = "";
      }
      if (settingsContainer) {
        settingsButton.style.display = "block";
        settingsContainer.style.display = "flex";
      }
      ulElements.forEach((ul) => {
        ul.style.margin = "";
        ul.style.padding = "";
      });
      // add custom scroll handling in styled text mode
      addCustomScrollHandling();
    }
  }

  if (isDisabledStyles) {
    applyPlainTextStyles(true);
  }

  togglePlainText.addEventListener("click", function () {
    const isDisabled = localStorage.getItem("stylesDisabled") === "true";
    // Toggle the disabled state based on the opposite of the current state
    for (let i = 0; i < document.styleSheets.length; i++) {
      document.styleSheets[i].disabled = !isDisabled;
    }
    // Save the new state in localStorage
    localStorage.setItem("stylesDisabled", !isDisabled);

    // Apply or remove plain text styles
    applyPlainTextStyles(!isDisabled);

    if (settingsButton) {
      settingsButton.style.display = !isDisabled
        ? "block !important"
        : "none !important";
    }
    // update button text based on the new state
    togglePlainText.textContent = isDisabled
      ? "Plain Text View"
      : "Styled Text View";
  });

  // function to toggle visibility of sections
  function toggleSection(button) {
    // toggle aria-expanded attribute of button
    const isExpanded = button.getAttribute("aria-expanded") === "true";
    button.setAttribute("aria-expanded", !isExpanded);

    // show/hide the related section content
    // toggle display on mobile, and visibility on desktop to avoid layout issues
    const sectionId = button.getAttribute("aria-controls");
    const sectionItems = document.getElementById(sectionId);

    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
      sectionItems.style.display = isExpanded ? "none" : "block";
    } else {
      if (isExpanded) {
        sectionItems.style.opacity = "0";
        sectionItems.style.visibility = "hidden";
        sectionItems.style.pointerEvents = "none";
      } else {
        sectionItems.style.opacity = "1";
        sectionItems.style.visibility = "visible";
        sectionItems.style.pointerEvents = "all";
      }
    }

    // update button list-style
    var parent = button.closest("li.first-item");
    if (parent) {
      parent.classList.toggle("list-style-circle", isExpanded);
    }
    var desktopMenu = document.getElementById("desktop-menu");
    if (desktopMenu) {
      if (button.classList.contains("menu-toggle")) {
        button.classList.toggle("list-style-circle");
        desktopMenu.classList.toggle("hidden");
      }
    }
  }

  // attach event listeners to all toggle buttons
  document.querySelectorAll(".toggle").forEach(function (toggle) {
    toggle.addEventListener("click", function () {
      toggleSection(this);
    });
  });

  // function to init sections
  function initSections() {
    const isMobile = window.innerWidth <= 768;
    const sections = document.querySelectorAll("[aria-controls]");

    sections.forEach((button) => {
      const sectionId = button.getAttribute("aria-controls");
      const sectionItems = document.getElementById(sectionId);

      // style collapsed sections for desktop
      const isExpanded = button.getAttribute("aria-expanded") === "true";
      const parent = button.closest("li.first-item");
      if (parent) {
        parent.classList.toggle("list-style-circle", !isExpanded);
      }
    });
  }
  // initialize sections on page load
  initSections();
});
