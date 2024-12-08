document.addEventListener("DOMContentLoaded", function () {
  let noiseIntensity = 160;
  let subdivisionFactor = 6;

  document.getElementById("noiseIntensity").value = noiseIntensity;
  document.getElementById("subdivisionFactor").value = subdivisionFactor;

  document.getElementById("noiseIntensityValue").textContent = noiseIntensity;
  document.getElementById("subdivisionFactorValue").textContent =
    subdivisionFactor;

  const svg = d3.select("#lineCanvas");

  function drawLinesFromButton(clickedButton) {
    const clickedButtonPosition = clickedButton.getBoundingClientRect();

    let points = [
      {
        x: clickedButtonPosition.left + clickedButtonPosition.width / 2,
        y: clickedButtonPosition.top + clickedButtonPosition.height / 2,
      },
    ];

    function shuffleOrder(array) {
      for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
      }
      return array;
    }

    const targetSelectors = [".ae-title", ".homepage__dates", ".homepage__tag"];

    const targetSelectorsOrdered = shuffleOrder(targetSelectors.slice());

    // add center point to the points array
    targetSelectorsOrdered.forEach((selector) => {
      const targetElements = document.querySelectorAll(selector);

      targetElements.forEach((targetElement) => {
        const targetPosition = targetElement.getBoundingClientRect();

        points.push({
          x: targetPosition.left + targetPosition.width / 2,
          y: targetPosition.top + targetPosition.height / 2,
        });
      });
    });
    // console.log(noiseIntensity, subdivisionFactor, points);

    let pointsWithNoise = addNoiseToLine(
      points,
      noiseIntensity,
      subdivisionFactor
    );
    const pathData = lineGenerator(pointsWithNoise);

    // single path
    svg
      .append("path")
      .attr("d", pathData)
      .style("stroke", "var(--cc-squig-colour)")
      .style("stroke-width", 6)
      .style("fill", "none");
  }

  // draw on audio button click
  document.querySelectorAll(".audio-button").forEach((button) => {
    button.addEventListener("click", function () {
      // clear existing paths
      svg.selectAll("path").remove();
      drawLinesFromButton(this);
    });
  });
});
