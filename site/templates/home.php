<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AE25 STD</title>

  <?= css([
    'assets/css/normalize.v8.0.1.css',
    // 'assets/css/index.css',
    '@auto',
  ]) ?>

  <?= js([
    // 'assets/js/script.js'
  ]) ?>
  <!-- <link rel="stylesheet" href="assets/css/style.css" /> -->
  <!-- <script src="assets/js/script.js" defer></script> -->


  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />
</head>

<body>
  <div id="mobile">
    <section class="mobile header">
      <div class="row">
        <div class="col">
          <div class="ae opacity-75 relative">
            <?php
            $logoFiles = $site->files()->template('ae_logo');
            $logo = $logoFiles->first();
            ?>
            <?= $logo->read() ?>
            <span class="year opacity-75">'25</span>

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
              <span>Audible Edge</span>
              <span>Festival of</span><br />
              <span>Exploratory Music</span>
              <a href="#about"><button class="btn--info">i</button></a>
            </h3>
          </div>
        </div>
        <div class="col flex-end">
          <div class="settings">
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
        <div class="ae opacity-75">
          <?php
          $logoFiles = $site->files()->template('ae_logo');
          $logo = $logoFiles->first();
          ?>
          <?= $logo->read() ?>
        </div>
        <span class="year opacity-75">'25</span>
      </div>

      <div class="row subtitle details desktop">
        <h3>
          <span>Audible Edge</span>
          <span>Festival of</span><br />
          <span>Exploratory Music</span>
          <button id="content--info" class="btn--info">i</button>
        </h3>
      </div>

      <div class="row">
        <button id="btn-about">
          <h2>About</h2>
        </button>
        <div class="info content" id="about">
          <?= kirby()->page('about')->description()->kirbytext() ?>
        </div>
        <ul class="reviews">
          <?= kirby()->page('about')->reviews()->kirbytext() ?>
        </ul>
      </div>

      <div class="img" id="icon-a">
        <?= svg('assets/img/Swamp Icons/Swampy Icons-01.svg') ?>
      </div>
    </section>

    <section class="column b">
      <div class="row when details flex-end desktop">
        <h3><span class="grey">Happening</span><br /><span class="grey">April 3–6</span></h3>
      </div>
      <div class="row space"></div>
      <div class="row">
        <button id="btn-accessibility">
          <h2>Accessibility</h2>
        </button>
        <div class="content" id="accessibility">
          <?= kirby()->page('accessibility')->description()->kirbytext() ?>
        </div>
      </div>
      <div class="img" id="icon-b">
        <?= svg('assets/img/Swamp Icons/Swampy Icons-02.svg') ?>
      </div>
    </section>

    <section class="column c">
      <div class="row desktop" id="settings">
        <p>
          <span class="grey">you are sharing this website with</span>
          <span id="sharing" class="gap">2</span>
          <span class="grey">other people,</span>
        </p>

        <div>
          <span class="grey">it is currently</span>
          <div class="time gap">
            <span class="hour"></span>:<span class="minute"></span>
          </div>
          <span class="grey">in boorloo,</span>
        </div>

        <p>
          <span class="grey">and you are viewing this website in</span>
          <span id="mode" class="gap">high contrast</span>
          <span class="grey">mode</span>

          <label class="switch">
            <input
              type="checkbox"
              id="toggle_switch"
              onclick="changeMode(this)" />
            <span class="slider round"></span>
          </label>
        </p>

        <div
          class="temp"
          style="position: relative; background-color: yellow">
          <div
            class="control"
            style="display: flex; flex-direction: row; flex-wrap: wrap">
            <input
              id="transformWeight"
              type="range"
              min="1"
              max="10"
              value="5"
              step="1" />
          </div>
          <button id="scrollMode">burrow scroll</button>
          <button id="noiseMode">no noise</button>
        </div>
      </div>
      <div class="row audio">
        <?php snippet('home-form', ['device' => 'desktop']) ?>

        <div class="img" id="icon-c">
          <?= svg('assets/img/Swamp Icons/Swampy Icons-03.svg') ?>
        </div>
      </div>

      <div class="row">
        <button id="btn-acknowledgements">
          <h2>Acknowledgements</h2>
        </button>
        <div class="content" id="acknowledgements">
          <?= kirby()->page('supporters')->description()->kirbytext() ?>
        </div>
        <div class="logos">
          <?=
          $logos = kirby()->page('supporters')->smalllogos()->toFiles();
          if ($logos->count() > 0): ?>
            <?php foreach ($logos as $logo): ?>
              <img src="<?= $logo->url() ?>" alt="<?= $logo->filename() ?>" />
            <?php endforeach ?>
          <?php endif ?>
        </div>
      </div>
      <footer>
        <ul class="footer-links">
          <li>
            <a href="#" class="footer-link">Instagram</a>
          </li>
          <li>
            <a href="#" class="footer-link">Facebook</a>
          </li>
          <li>
            <a href="#" class="footer-link">eMail Newsletter</a>
          </li>
          <li>
            <a href="#" class="footer-link">SMS Newsletter</a>
          </li>
          <li>
            <a href="#" class="footer-link">eMail</a>
          </li>
        </ul>
        <div class="space"></div>
        <div class="legal">
          <p>© Audible Edge 2025 brought to you by Tone List.</p>
          <p>
            Read the event
            <a href="#">Privacy Statement and Terms & Conditions</a>.
          </p>
          <p>Site by Alex Turner and Oliva Rawlings.</p>
        </div>
      </footer>
    </section>
  </div>
  <script>
    function handleFileSelect(input) {
      const submitButton = input.closest('.form-field').querySelector('.submit-button');
      if (input.files.length > 0) {
        submitButton.style.display = 'block';
        // ? show the filename
        const fileName = input.files[0].name;
        input.nextElementSibling.textContent = `${fileName}`;
      } else {
        submitButton.style.display = 'none';
        input.nextElementSibling.textContent = 'Upload';
      }
    }
  </script>
  <!-- <div>icons are living</div> -->
  <?= js('assets/js/templates/home.js') ?>
</body>

</html>