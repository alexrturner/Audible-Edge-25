<button id="settingsButton" class="pseudo-list-item" style="visibility:hidden;" aria-hidden="true" aria-controls="settingsContainer">Settings</button>
<div id="settingsContainer" class="hidden" style="visibility:hidden;" aria-hidden="true">
    <div><label for="noiseIntensity">Noise Intensity: </label><span id="noiseIntensityValue">80</span></div>
    <input type="range" id="noiseIntensity" name="noiseIntensity" min="0" max="1000" step="10" value="80">

    <div><label for="subdivisionFactor">Subdivision Factor: </label><span id="subdivisionFactorValue">3</span></div>
    <input type="range" id="subdivisionFactor" name="subdivisionFactor" min="1" max="20" value="3">

    <button class="button circle-button" id="toggleSquig" aria-label="Toggle visual element">
        <div id="setting__button-text">
            on
        </div>
    </button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var settingsButton = document.getElementById("settingsButton");
        var settingsContainer = document.getElementById("settingsContainer");

        settingsButton.addEventListener("click", function() {
            settingsContainer.classList.toggle("hidden");
            settingsButton.classList.toggle("inactive");

            var isVisible = settingsContainer.style.visibility === 'visible';
            settingsContainer.style.visibility = isVisible ? 'hidden' : 'visible';
            settingsContainer.setAttribute('aria-hidden', isVisible);
            document.getElementById('settingsButton').setAttribute('aria-hidden', !isVisible);
        });
    });
</script>