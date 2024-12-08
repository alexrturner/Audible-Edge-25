const liOffsetX = 3;
const liOffsetY = 10;

let noiseIntensity2 = 80;
let subdivisionFactor2 = 3;

function addNoiseToLine(points, noiseIntensity2 = 2, subdivisionFactor2 = 5) {
  let noisyPoints = [];

  points.forEach((point, i) => {
    // add original point
    noisyPoints.push(point);
    // for each segment, add midpoints with noise
    if (i < points.length - 1) {
      const nextPoint = points[i + 1];
      // subdivide segment and add noise
      for (let j = 1; j <= subdivisionFactor2; j++) {
        const t = j / (subdivisionFactor2 + 1);
        const midX = point.x + (nextPoint.x - point.x) * t;
        const midY = point.y + (nextPoint.y - point.y) * t;
        const noisyMidPoint = addRandomness(
          {
            x: midX,
            y: midY,
          },
          noiseIntensity2
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

function getElementPosition(element) {
  const rect = element.getBoundingClientRect();
  return {
    x: rect.left + window.scrollX + liOffsetX,
    y: rect.top + window.scrollY + liOffsetY,
  };
}
const lineGenerator2 = d3
  .line()
  .x((d) => d.x)
  .y((d) => d.y)
  // apply smooth curve
  // alpha controls the tension
  .curve(d3.curveCatmullRom.alpha(0.5));

const svg = d3.select("#lineCanvas");
const eventItem = document.querySelector(".events-item");
const anchorItem = document.querySelector(".anchor-point");
const dateItem = document.querySelector(".date");

document.addEventListener("DOMContentLoaded", function () {
  const eventPosition = getElementPosition(eventItem);
  const anchorPosition = getElementPosition(anchorItem);
  const datePosition = getElementPosition(dateItem);

  let points = [eventPosition, anchorPosition, datePosition];

  // add noise
  let pointsWithNoise = addNoiseToLine(
    points,
    noiseIntensity2,
    subdivisionFactor2
  );

  // gen path
  const pathData = lineGenerator2(pointsWithNoise);
  // console.log(pathData);
  svg
    .append("path")
    .attr("d", pathData)
    .style("stroke", "var(--cc-squig-colour)")
    .style("stroke-width", 6)
    .style("fill", "none");
});
