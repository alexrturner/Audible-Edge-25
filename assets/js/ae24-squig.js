// init global line attributes
let noiseIntensity = 80;
let subdivisionFactor = 3;

// squig controls
// document.addEventListener("DOMContentLoaded", function () {
document.getElementById("toggleSquig").addEventListener("click", function () {
  const svgContainer = document.getElementById("lineCanvas");
  const button = document.getElementById("toggleSquig");
  const buttonText = document.getElementById("setting__button-text");

  if (svgContainer.style.display !== "none") {
    svgContainer.style.display = "none";
    buttonText.innerHTML = "off";
    button.classList.toggle("inactive");
  } else {
    svgContainer.style.display = "block";
    buttonText.innerHTML = "on";
    button.classList.toggle("inactive");
  }
});

// update global variables based on input
function updateParameters() {
  noiseIntensity = parseFloat(document.getElementById("noiseIntensity").value);
  subdivisionFactor = parseInt(
    document.getElementById("subdivisionFactor").value
  );

  // update displayed values
  document.getElementById("noiseIntensityValue").textContent = noiseIntensity;
  document.getElementById("subdivisionFactorValue").textContent =
    subdivisionFactor;
}

// event listeners for the parameter controls
document
  .getElementById("noiseIntensity")

  .addEventListener("input", updateParameters);
document
  .getElementById("subdivisionFactor")

  .addEventListener("input", updateParameters);

function addNoiseToLine(points, noiseIntensity = 2, subdivisionFactor = 5) {
  let noisyPoints = [];

  points.forEach((point, i) => {
    // add original point
    noisyPoints.push(point);
    // for each segment, add midpoints with noise
    if (i < points.length - 1) {
      const nextPoint = points[i + 1];
      // subdivide segment and add noise
      for (let j = 1; j <= subdivisionFactor; j++) {
        const t = j / (subdivisionFactor + 1);
        const midX = point.x + (nextPoint.x - point.x) * t;
        const midY = point.y + (nextPoint.y - point.y) * t;
        const noisyMidPoint = addRandomness(
          { x: midX, y: midY },
          noiseIntensity
        );
        noisyPoints.push(noisyMidPoint);
      }
    }
  });

  return noisyPoints;
}

function addRandomness(point, intensity = 100) {
  // add random displacement to x and y, controlled by intensity
  return {
    x: point.x + (Math.random() - 0.5) * intensity,
    y: point.y + (Math.random() - 0.5) * intensity,
  };
}

function calculateMidpointWithRandomness(pointA, pointB, intensity = 100) {
  // get midpoint
  const midpoint = {
    x: (pointA.x + pointB.x) / 2,
    y: (pointA.y + pointB.y) / 2,
  };

  // apply random offset to midpoint
  return addRandomness(midpoint, intensity);
}
function addPointsWithMidpoints(points, intensity) {
  let newPoints = [];
  points.forEach((point, i) => {
    // add the original point
    newPoints.push(point);
    // for each pair of points, calculate and add a new point slightly offset from their midpoint
    if (i < points.length - 1) {
      const midpoint = calculateMidpointWithRandomness(
        point,
        points[i + 1],
        intensity
      );
      newPoints.push(midpoint);
    }
  });
  return newPoints;
}

document.addEventListener("DOMContentLoaded", function () {
  fetch("/assets/data/relations.json")
    .then((response) => response.json())
    .then((data) => {
      setupHoverInteractions(data);
    });
});
const lineGenerator = d3
  .line()
  .x((d) => d.x)
  .y((d) => d.y)
  // apply smooth curve
  // alpha controls the tension
  .curve(d3.curveCatmullRom.alpha(0.5));

function setupHoverInteractions(data) {
  const svg = d3.select("#lineCanvas");
  const liOffsetX = 0;
  const liOffsetY = 10;

  d3.selectAll(
    ".dates li:not(.first-item), .events-container li:not(.first-item), .artists-container li:not(.first-item)"
  )
    .on("mouseover", function (event, d) {
      const element = d3.select(this);
      const elementId = element.attr("data-id");
      const elementType = element.attr("data-type");

      // path points
      let points = [];
      // console.log(elementType, elementId);

      if (elementType === "events") {
        const eventElement = this.getBoundingClientRect();
        // start path at event
        points.push({
          x: eventElement.left - liOffsetX,
          y: eventElement.top + liOffsetY,
        });

        // line from event to date
        const dateId = data.events[elementId].date;
        const dateElement = document
          .querySelector(`[data-id="${dateId}"][data-type="date"]`)
          .getBoundingClientRect();
        points.push({
          x: dateElement.left - liOffsetX,
          y: dateElement.top + liOffsetY,
        });

        // lines from event to each artist
        data.events[elementId].artists.forEach((artistId) => {
          const artistElement = document
            .querySelector(`[data-id="${artistId}"][data-type="artists"]`)
            .getBoundingClientRect();
          points.push({
            x: eventElement.left - liOffsetX,
            y: eventElement.top + liOffsetY,
          });
          points.push({
            x: artistElement.left - liOffsetX,
            y: artistElement.top + liOffsetY,
          });
        });
      } else if (elementType === "artists") {
        // fetch related events, draw line from artist to each event, then to event's date
        const artistElement = this.getBoundingClientRect();
        points.push({
          x: artistElement.left - liOffsetX,
          y: artistElement.top + liOffsetY,
        });

        data.artists[elementId].events.forEach((eventId) => {
          const eventElement = document.querySelector(
            `[data-id="${eventId}"][data-type="events"]`
          );

          if (eventElement) {
            const rect = eventElement.getBoundingClientRect();
            points.push({
              x: rect.left - liOffsetX,
              y: rect.top + liOffsetY,
            });
            const dateId = data.events[eventId].date;
            const dateElement = document
              .querySelector(`[data-id="${dateId}"][data-type="date"]`)
              .getBoundingClientRect();
            points.push({
              x: dateElement.left - liOffsetX,
              y: dateElement.top + liOffsetY,
            });
          } else {
            // Handle the case where the event is not on the current page
            // Determine if the event belongs to 'satellite' or 'nightschool' by checking the eventId
            if (eventId.startsWith("satellite")) {
              const satelliteElement = document
                .getElementById("page__satellite")
                .getBoundingClientRect();
              points.push({
                x: satelliteElement.left - liOffsetX,
                y: satelliteElement.top + liOffsetY,
              });
            } else if (eventId.startsWith("nightschool")) {
              const nightschoolElement = document
                .getElementById("page__nightschool")
                .getBoundingClientRect();
              points.push({
                x: nightschoolElement.left - liOffsetX,
                y: nightschoolElement.top + liOffsetY,
              });
            }
          }
        });
      } else if (elementType === "date") {
        // fetch related events, draw line from date to each event, then to event's artists
        const dateElement = this.getBoundingClientRect();
        points.push({
          x: dateElement.left - liOffsetX,
          y: dateElement.top + liOffsetY,
        });

        data.dates[elementId].events.forEach((eventId) => {
          const eventElement = document
            .querySelector(`[data-id="${eventId}"][data-type="events"]`)
            .getBoundingClientRect();
          // line to event
          points.push({
            x: eventElement.left - liOffsetX,
            y: eventElement.top + liOffsetY,
          });

          // for each event, draw lines to its artists
          data.events[eventId].artists.forEach((artistId) => {
            const artistElement = document
              .querySelector(`[data-id="${artistId}"][data-type="artists"]`)
              .getBoundingClientRect();
            // move to event first, then draw line to artist
            points.push({
              x: artistElement.left - liOffsetX,
              y: artistElement.top + liOffsetY,
            });
          });
        });
      }

      // points = addPointsWithMidpoints(points, 1000); // Adjust intensity as needed
      // const pathData = lineGenerator(points);

      // noiseIntensity = how much the points deviate from the original line
      // subdivisionFactor = how many additional points are added between each pair of original points to increase the roughness
      let pointsWithNoise = addNoiseToLine(
        points,
        noiseIntensity,
        subdivisionFactor
      );
      const pathData = lineGenerator(pointsWithNoise);

      // draw new path
      svg
        .append("path")
        .attr("d", pathData)
        .style("stroke", "var(--cc-squig-colour)")
        .style("stroke-width", 6)
        .style("fill", "none");
    })
    .on("mouseout", function () {
      // clear existing paths
      svg.selectAll("path").remove();
    });
}
// });
