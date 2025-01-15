<?php

$activeVisitors = countActiveVisitors();

?>

<?php snippet('header') ?>

<body class="mode-high-contrast">
  <div id="mobile">
    <section class="mobile header">
      <div class="row viewing">
        <div class="space"></div>
        <div class="settings ancillary">
          <span class="grey">you are viewing this website in</span>
          <span id="mode-desktop" class="gap mode">high contrast</span>
          <span class="grey">mode</span>

          <label class="switch">
            <input
              type="checkbox"
              id="toggle-mode-mobile"
              onclick="changeMode(this)" />
            <span class="slider round"></span>
          </label>
        </div>

      </div>
      <div class="row lighten">
        <div class="title col flex-end">
          <h1>Audible Edge</h1>
        </div>
        <div class="col">
          <div class="when">
            <div class="ae relative lighten">
              <?php
              $logoFiles = $site->files()->template('ae_logo');
              $logo = $logoFiles->first();
              ?>
              <?= $logo->read() ?>
              <span class="year">'25</span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="subtitle">
            <h3>
              <span class="lighten">Tone List Presents</span>
            </h3>
          </div>
        </div>
        <div class="col flex">
          <span class="lighten">a Festival of</span>
          <span class="lighten">Exploratory Music</span>
          <span class="lighten">Happening April 3–6</span>
          <span class="lighten">in Boorloo and Walyalup</span>
        </div>
      </div>
      <div class="mobile-swamp-container column">

        <div class="img mobile-icon">
          <?= svg('assets/img/Swamp Icons/Swampy Icons-01.svg') ?>
        </div>

      </div>
    </section>
    <section class="audio">

      <?php snippet('home-form', ['device' => 'mobile']) ?>

    </section>
  </div>

  <div id="container" class="container">
    <?php snippet('audio-mix') ?>
    <section class="column a">
      <div class="row title subtitle details flex-end desktop lighten">
        <h1>
          <?= svg('assets/img/logo-audible.svg') ?>
        </h1>
      </div>

      <div class="row subtitle details desktop">
        <h3>
          <span class="lighten">Tone List Presents</span>


          <!-- <button id="content--info" class="btn--info lighten" aria-label="Go to information about Audible Edge Festival">i</button> -->

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
      <div class="row title desktop">
        <div class="ae lighten">
          <?php
          $logoFiles = $site->files()->template('ae_logo');
          $logo = $logoFiles->first();
          ?>
          <?= $logo->read() ?>
        </div>
        <h1>
          <?= svg('assets/img/logo-edge.svg') ?>
        </h1>
        <span class="year lighten">'25</span>
      </div>

      <!-- <div class="row space desktop"> -->
      <div class="row subtitle details desktop">
        <h3>
          <span class="lighten">A Festival of </span>
          <span class="lighten">Exploratory Music</span>
          <span class="lighten">Happening April 3–6</span>
          <span class="lighten">in Boorloo and Walyalup</span>
        </h3>
      </div>
      <div class="row">
        <h2 id="accessibility" class="title lighten"><a href="#accessibility">Accessibility</a></h2>
        <div class="content lighten">
          <?= kirby()->page('accessibility')->description()->kirbytext() ?>
        </div>
        <h2 id="contact" class="title lighten"><a href="#contact">Contact</a></h2>
        <ul class="reviews lighten">

          <?php
          $socials = $site->socials()->toStructure();
          foreach ($socials as $social): ?>
            <li><a href="<?= $social->link() ?>"><?= $social->text() ?></a></li>
          <?php endforeach ?>
        </ul>
      </div>
      <div class="img" id="icon-saturation">
        <?= svg('assets/img/Swamp Icons/Swampy Icons-02.svg') ?>
      </div>
    </section>

    <section class="column c">
      <div class="row desktop settings ancillary">

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
          <span class="lighten">and you are viewing this website in</span><span id="mode-mobile" class="mode gap">high contrast</span><span class="lighten">mode</span>

          <label class="switch">
            <input
              type="checkbox"
              id="toggle-mode-desktop"
              onclick="changeMode(this)" />
            <span class="slider round"></span>
          </label>

          <button id="toggle-mix" class="btn--play switch" aria-label="Play/Stop the audio mix">
            <span class="play-icon">&#9658;</span>

          </button>
        </div>



        <!-- settings -->

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

      const playButton = document.getElementById('toggle-mix');
      const mixContainer = document.querySelector('.audible-edge-mix');

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



      playButton.addEventListener('click', function() {
        const isPlaying = mixContainer.classList.contains('active');

        if (isPlaying) {
          // Stop and hide
          player.pause();
          mixContainer.classList.remove('active');
          playButton.innerHTML = '&#9658;'; // Play icon
        } else {
          // Show and play
          mixContainer.classList.add('active');
          player.play();
          playButton.innerHTML = '&#9632;'; // Stop icon
        }
      });

      // Optional: Stop playback when audio ends
      player.on('ended', function() {
        mixContainer.classList.remove('active');
        playButton.innerHTML = '&#9658;';
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
    // setInterval(fetchVisitorCount, 30000);
    fetchVisitorCount();
  </script>
  <!-- <div>icons are living</div> -->
  <?= js('assets/js/templates/home.js') ?>
</body>

</html>