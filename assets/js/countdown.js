document.addEventListener("DOMContentLoaded", function () {
  // countdown till 6pm program launch (home page)
  const countdown = document.getElementById("countdown");
  const targetDate = new Date("March 13, 2024 18:00:00").getTime();
  const countdownContainer = document.getElementById("countdown-container");

  let interval;

  const updateCountdown = function () {
    const now = new Date().getTime();
    // convert timezone offset to milliseconds, then adjust for UTC+8
    const timezoneOffset = new Date().getTimezoneOffset() * 60000;
    const UTC8time = now + timezoneOffset + 8 * 3600000;
    const distance = targetDate - UTC8time;

    // if the countdown is over, display message
    if (distance < 0) {
      countdownContainer.innerHTML = "Program has launched!";
      clearInterval(interval); // stop updating the countdown
      return;
    }

    // calculate days remaining & display
    const daysFraction = (distance / (1000 * 60 * 60 * 24)).toFixed(5);
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
      (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

    if (days === 1) {
      countdown.innerHTML = daysFraction + " days";
      countdown.innerHTML += `<br>[${days} day, ${hours} hour${
        hours > 1 ? "s" : ""
      }, ${minutes} minute${minutes > 1 ? "s" : ""}]`;
    } else if (days === 0) {
      countdown.innerHTML = daysFraction + " days";
      countdown.innerHTML += `<br>[${hours} hour${
        hours > 1 ? "s" : ""
      }, ${minutes} minute${minutes > 1 ? "s" : ""}]`;
    } else {
      countdown.innerHTML = daysFraction + " days";
      countdown.innerHTML += `<br>[${hours} hour${
        hours > 1 ? "s" : ""
      }, ${minutes} minute${minutes > 1 ? "s" : ""}]`;
    }
  };

  // run once on load, then update countdown every five mins
  updateCountdown();
  interval = setInterval(updateCountdown, 300000);
});
