<?php

$activeVisitors = countActiveVisitors();

?>

<?php snippet('header') ?>

<body class="mode-high-contrast">
  <div id="mobile">
    <section class="mobile header">
      <div class="row">
        <div class="col">
          <div class="ae relative lighten">
            <?php
            $logoFiles = $site->files()->template('ae_logo');
            $logo = $logoFiles->first();
            ?>
            <?= $logo->read() ?>
            <span class="year">'25</span>

          </div>
        </div>
        <div class="col">
          <div class="when flex-end">
            <h3><span>Happening</span><br /><span>April 3–6</span></h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="subtitle">
            <h3>
              <span class="lighten">Audible Edge</span>
              <span class="lighten">Festival of</span>
              <span class="lighten">Exploratory</span>
              <span class="lighten">Music</span>
              <a href="#about"><button class="btn--info lighten" aria-label="Go to information about Audible Edge Festival">i</button></a>
            </h3>
          </div>
        </div>
        <div class="col flex-end">
          <div class="settings ancillary">
            <span class="grey">you are viewing this website in</span>
            <span id="mode" class="gap mode">high contrast</span>
            <span class="grey">mode</span>

            <label class="switch">
              <input
                type="checkbox"
                id="toggle_switch"
                onclick="changeMode(this)" />
              <span class="slider round"></span>
            </label>
          </div>
        </div>
      </div>

    </section>
    <section class="audio">

      <?php snippet('home-form', ['device' => 'mobile']) ?>

    </section>
  </div>

  <div id="container" class="container">
    <section class="column a">
      <div class="row title desktop">
        <div class="ae lighten">
          <?php
          $logoFiles = $site->files()->template('ae_logo');
          $logo = $logoFiles->first();
          ?>
          <?= $logo->read() ?>
        </div>
        <span class="year lighten">'25</span>
      </div>

      <div class="row subtitle details desktop">
        <h3>
          <span class="lighten">Audible Edge</span>
          <span class="lighten">Festival of</span><br />
          <span class="lighten">Exploratory</span>
          <span class="lighten">Music</span>

          <button id="content--info" class="btn--info lighten" aria-label="Go to information about Audible Edge Festival">i</button>

        </h3>
      </div>

      <div class="row">

        <h2 id="about" class="title lighten"><a href="#about">About</a></h2>

        <div class="info content lighten">
          <?= kirby()->page('about')->description()->kirbytext() ?>
        </div>
        <ul class="reviews lighten">
          <?php
          $reviews = kirby()->page('about')->reviews()->toStructure();
          foreach ($reviews as $review): ?>
            <li>
              <p><?= $review->review() ?></p>
              <p class="small"><?= $review->reviewer() ?></p>
            </li>
          <?php endforeach ?>
        </ul>
      </div>

      <div class="img" id="icon-hue">
        <?= svg('assets/img/Swamp Icons/Swampy Icons-01.svg') ?>
      </div>
    </section>

    <section class="column b">
      <div class="row when subtitle details flex-end desktop">
        <h3><span class="lighten">Happening</span><br /><span class="lighten">April 3–6</span></h3>


      </div>
      <div class="row space desktop">

      </div>
      <div class="row">
        <h2 id="accessibility" class="title lighten"><a href="#accessibility">Accessibility</a></h2>
        <div class="content lighten">
          <?= kirby()->page('accessibility')->description()->kirbytext() ?>
        </div>
        <h2 id="contact" class="title lighten"><a href="#contact">Contact</a></h2>
        <div class="content lighten">

        </div>
      </div>
      <div class="img" id="icon-saturation">
        <?= svg('assets/img/Swamp Icons/Swampy Icons-02.svg') ?>
      </div>
    </section>

    <section class="column c">
      <div class="row desktop settings ancillary">
        <?php snippet('audio-mix') ?>
        <div>
          <span class="lighten">you are sharing this website with</span><span id="sharing" class="gap"><?= $activeVisitors ?></span><span class="lighten">other people,</span>
        </div>

        <div>
          <span class="lighten">it is currently</span>
          <span class="time gap">
            <span class="hour"></span>:<span class="minute"></span>
          </span>
          <span class="lighten">in Boorloo,</span>
        </div>

        <div>
          <span class="lighten">and you are viewing this website in</span><span id="mode" class="mode gap">high contrast</span><span class="lighten">mode</span>

          <label class="switch">
            <input
              type="checkbox"
              id="toggle_switch"
              onclick="changeMode(this)" />
            <span class="slider round"></span>
          </label>
        </div>

        <button id="toggleTemp" class="btn--temp" style="padding: 0.5em;  background-color: yellow;">temp settings</button>
        <script>
          document.getElementById('toggleTemp').addEventListener('click', function() {
            const tempContainer = document.querySelector('.temporary');
            tempContainer.style.display = tempContainer.style.display === 'none' ? 'block' : 'none';
          });
        </script>

        <div
          class="temporary"
          style="position: relative; background-color: yellow; display: none;">
          <p>These are to demo potential interactions & behaviours. They will not be visible on the live site.</p>
          <br>

          <div
            class="control"
            style="display: flex; flex-direction: row; flex-wrap: wrap">

            <span>weight for icon movement (effect more noticable in parallax scroll mode): <input
                id="transformWeight"
                type="range"
                min="1"
                max="10"
                value="5"
                step="1" /></span>

          </div>
          <span>current scroll mode (affects icon position): </span><button id="scrollMode">roaming</button><br />
          <!-- <span>current svg filter (affected by scroll): </span><button id="noiseMode">no noise</button><br /> -->
          <span>emulate change of time (affects colour): </span>
          <div class="time-of-day">

            <select id="timeOfDay" style="display: none;">
              <option value="currentTime">current time</option>
              <option value="dawn">dawn</option>
              <option value="day">day</option>
              <option value="dusk">dusk</option>
              <option value="night">night</option>
            </select>
          </div>

        </div>
      </div>
      <div class="row audio">
        <?php snippet('home-form', ['device' => 'desktop']) ?>

        <div class="img" id="icon-color">
          <?= svg('assets/img/Swamp Icons/Swampy Icons-03.svg') ?>
        </div>
      </div>

      <div class="row">

        <h2 id="acknowledgements" class="title lighten"><a href="#acknowledgements">Acknowledgements</a></h2>

        <div class="content lighten">
          <?= kirby()->page('supporters')->description()->kirbytext() ?>
        </div>
        <div class="logos">
          <?php
          $logos = kirby()->page('supporters')->smalllogos()->toFiles();
          if ($logos->count() > 0): ?>
            <?php foreach ($logos as $logo): ?>
              <img src="<?= $logo->url() ?>" alt="<?= $logo->alt()->escape() ?>">
            <?php endforeach ?>
          <?php endif ?>
        </div>
        <footer class="lighten">

          <div class="legal">
            <p>Audible Edge 2025 brought to you by <a href="https://www.tonelist.com.au/">Tone List</a>.</p>

            <p>Site by Oliva Rawlings and Alex Turner.</p>
          </div>
        </footer>
      </div>

    </section>
  </div>
  <script>
    function handleFileSelect(input) {
      const formField = input.closest('.form-field');
      const submitButton = formField.querySelector('.submit-button');
      const nextPromptButton = document.getElementById(`prompt--next-${input.id.split('-')[1]}`);
      const fileInfo = formField.querySelector('.file-info');
      const fileNameSpan = fileInfo.querySelector('.filename');


      if (input.files.length > 0) {
        // show submit, hide next prompt, show filename
        submitButton.style.display = 'block';
        nextPromptButton.style.display = 'none';
        const fileName = input.files[0].name;
        fileNameSpan.textContent = fileName;
        fileInfo.style.display = 'block';
      } else {
        // hide submit, show next prompt, hide filename
        submitButton.style.display = 'none';
        nextPromptButton.style.display = 'block';
        fileInfo.style.display = 'none';
      }
    }

    function toggleInfo(button) {
      const actionsContainer = button.closest('.actions');
      const infoText = actionsContainer.querySelector('.prompt--info-text');
      const promptIcons = actionsContainer.querySelectorAll('.prompt-icon');
      const elementsToToggle = actionsContainer.querySelectorAll('.action-buttons > *:not(.prompt--container):not(.audio-container), .prompt--container > *:not(.btn--info)');

      if (infoText.style.display === 'none') {
        // show info text, hide other e
        infoText.style.display = 'block';
        elementsToToggle.forEach(el => el.style.display = 'none');
        promptIcons.forEach(icon => {
          icon.classList.add('no-bg');
          icon.style.minHeight = '0px';
          icon.querySelector('svg').classList.add('hidden');
        });
        button.textContent = 'x';
      } else {
        // hide info text, show other e
        infoText.style.display = 'none';
        elementsToToggle.forEach(el => el.style.display = '');
        promptIcons.forEach(icon => {
          icon.classList.remove('no-bg');
          icon.style.minHeight = ''; // default
          icon.querySelector('svg').classList.remove('hidden');
        });
        button.textContent = 'i';
      }
    }

    // mix player
    document.addEventListener('DOMContentLoaded', function() {
      const player = new Plyr('#player', {
        controls: [
          'play',
          'current-time',
          'duration',
          'progress',
          'volume'
        ],
        tooltips: {
          controls: true
        },
        keyboard: {
          focused: true,
          global: true
        }
      });
    });

    // fetch active visitor count
    async function fetchVisitorCount() {
      try {
        const response = await fetch('<?= url('assets/visitor.json') ?>');
        const data = await response.json();
        const currentVisitors = data.currentVisitors - 1;
        document.getElementById('sharing').textContent = currentVisitors;

        // console.log(data);
      } catch (error) {
        console.error('Error fetching visitor count:', error);
      }
    }

    // 30s fetch
    setInterval(fetchVisitorCount, 30000);
    fetchVisitorCount();
  </script>
  <!-- <div>icons are living</div> -->
  <?= js('assets/js/templates/home.js') ?>
</body>

</html>