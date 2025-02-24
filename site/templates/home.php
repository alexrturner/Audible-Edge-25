<?php

$activeVisitors = countActiveVisitors();
$timeOfDay = getTimeOfDayBoorloo();

$swamps = $site->files()->filterBy('template', 'ae_swamp_svg');
date_default_timezone_set('Australia/Perth');
?>

<?php snippet('header') ?>


<div id="mobile">
  <section class="mobile header">
    <div class="row viewing">
      <div class="settings ancillary">
        <span class="grey">you are viewing this website in</span>
        <span id="mode-mobile" class="gap mode">high contrast</span>
        <span class="grey">mode</span>

        <label class="switch">
          <input
            type="checkbox"
            id="toggle-mode-mobile"
            onclick="changeMode(this)" />
          <span class="slider round"></span>
        </label>
      </div>
      <div class="space">
        <?php $expanded = "false"; ?>
        <div class="menu-header-container">
          <nav class="menu-items-container">
            <button class="menu-toggle toggle pseudo-list-item" aria-expanded="<?= $expanded ?>" aria-controls="menu-items" aria-label="Toggle Menu">
              Menu
            </button>
            <ul class="menu-items items <?php e($expanded === "true", "", "hidden__visibility"); ?>" id="menu-items">

              <?php if (strtotime('now') < strtotime('2025-02-26 18:00:00')): ?>

                <li><a href="/program/program-launch" class="lighten">Program Launch</a></li>
                <li><a href="/donate" class="lighten">Donate</a></li>

              <?php else: ?>

                <?php foreach ($site->children()->listed() as $p) : ?>
                  <li class="lighten menu-item">
                    <a <?php e($p->isOpen(), 'aria-current="page"') ?> href="<?= $p->url() ?>" class="lighten menu-link<?php e($p->isOpen(), ' active') ?>">
                      <?= $p->title()->esc() ?>
                    </a>
                  </li>

                <?php endforeach ?>

              <?php endif ?>
            </ul>
          </nav>
        </div>
      </div>

    </div>
    <div class="row lighten">
      <div class="title col flex-end">
        <div class="logo-container lighten" title="Audible">
          <?= svg('assets/img/logo-audible.svg') ?>
        </div>
      </div>
      <div class="col">
        <div class="when">
          <div class="ae relative">
            <?php
            $logoFiles = $site->files()->template('ae_logo');
            $logo = $logoFiles->first();
            ?>
            <?= $logo->read() ?>
            <span class="year">'25</span>
          </div>
          <div class="logo-container lighten" title="Edge">
            <?= svg('assets/img/logo-edge.svg') ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="subtitle">
          <h3>
            <span class="lighten">Tone List</span>
            <span class="lighten">Presents</span>
          </h3>
        </div>
      </div>
      <div class="col flex">
        <span class="lighten">a Festival of</span>
        <span class="lighten">Exploratory</span>
        <span class="lighten">Music</span>
        <span>Happening</span>
        <span>April 3–6</span>
        <span>in Boorloo and Walyalup</span>
      </div>
    </div>
    <div class="mobile-swamp-container column">

      <div id="icon-mobile" class="icon__swamp">
        <?= svg('assets/img/Swamp Icons/Swampy Icons-01.svg') ?>
      </div>

    </div>
  </section>
  <section class="audio">

    <?php snippet('home--prompt-form', ['device' => 'mobile']) ?>

  </section>
</div>

<div id="container" class="container">
  <?php if ($site->files()->template('audio_ae_mix')->count()): ?>
    <?php snippet('audio-mix') ?>
  <?php endif ?>
  <section class="column a">
    <div class="row title subtitle details flex-end desktop lighten">
      <div class="logo-container" title="Audible">
        <?= svg('assets/img/logo-audible.svg') ?>
      </div>
    </div>

    <div class="row subtitle details desktop">
      <h3>
        <span class="lighten">Tone List Presents</span>
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

    <div class="icon__swamp" id="icon-hue">
      <?= svg($swamps->filterBy('position', 'left')->first()) ?>
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
      <div title="Edge" class="logo-container">
        <?= svg('assets/img/logo-edge.svg') ?>
      </div>
      <span class="year lighten">'25</span>
    </div>

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
      <div>
        <ul class="reviews lighten">
          <li><a href="mailto:<?= $site->email() ?>">Email</a></li>
          <?php
          $socials = $site->socials()->toStructure();
          foreach ($socials as $social): ?>
            <li><a href="<?= $social->link() ?>"><?= $social->text() ?></a></li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
    <div class="icon__swamp" id="icon-saturation" style="rotate: 20deg;">
      <?=
      svg($swamps->filterBy('position', 'middle')->first())
      ?>
    </div>
  </section>

  <section class="column c">
    <div class="row desktop settings ancillary">




      <div class="home__menu">

        <nav class="">


          <ul class="menu-items items <?php e($expanded === "true", "", "hidden__visibility"); ?>" id="menu-items-desktop">



            <?php if (strtotime('now') < strtotime('2025-02-26 18:00:00')): ?>
              <li><a href="/program/program-launch" class="lighten">Program Launch</a></li>
              <li><a href="/donate" class="lighten">Donate</a></li>

            <?php else: ?>

              <?php foreach ($site->children()->listed() as $p) : ?>
                <li class="lighten menu-item">
                  <a <?php e($p->isOpen(), 'aria-current="page"') ?> href="<?= $p->url() ?>" class="lighten menu-link<?php e($p->isOpen(), ' active') ?>">
                    <?= $p->title()->esc() ?>
                  </a>
                </li>

              <?php endforeach ?>

            <?php endif ?>

          </ul>
        </nav>
      </div>

      <div class="extra">
        <div id="btn--play-container">
          <?php if ($site->files()->template('audio_ae_mix')->count()): ?>
            <button id="toggle-mix" class="btn--play switch interact" aria-label="Play/Stop the audio mix">
              <span class="play-icon">&#9658;</span>
            </button>
          <?php endif ?>
        </div>
        <div>
          <span class="lighten">you have shared this <span id="time-of-day" class="gap"><?= $timeOfDay ?></span> on this website with</span><span id="sharing" class="gap"><?= $activeVisitors ?></span><span class="lighten">other people,</span>
        </div>

        <div>
          <span class="lighten">it is currently</span>
          <span id="time-is-now" class="time gap">
            <span class="hour"></span>:<span class="minute"></span>
          </span>
          <span class="lighten">in Boorloo,</span>
        </div>

        <div>
          <span class="lighten">and you are viewing this website in</span><span id="mode-desktop" class="mode gap">high contrast</span><span class="lighten">mode</span>

          <label class="switch">
            <input
              type="checkbox"
              id="toggle-mode-desktop"
              onclick="changeMode(this)" />
            <span class="slider round interact inverted"></span>
          </label>


        </div>

        <div class="icon__swamp" id="icon-color">
          <?=
          svg($swamps->filterBy('position', 'right')->first())
          ?>
        </div>

      </div>


      <!-- settings -->

    </div>
    <div class="row audio">
      <?php snippet('home--prompt-form', ['device' => 'desktop']) ?>
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
            <div class="logo" role="img" aria-label="<?= $logo->alt() ?>">

              <?= $logo->read() ?>
            </div>
          <?php endforeach ?>
        <?php endif ?>
      </div>

    </div>

  </section>
</div>
<script>
  // prompting
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
  // ~~~~~~
  // mix player
  document.addEventListener('DOMContentLoaded', function() {

    const playButton = document.getElementById('toggle-mix');
    if (playButton) {
      const mixContainer = document.querySelector('.audible-edge-mix');
      const desktopColumnC = document.querySelector('.row.desktop.settings.ancillary');

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
          desktopColumnC.classList.remove('pt-5');
          playButton.innerHTML = '&#9658;'; // Play icon
        } else {
          // Show and play
          mixContainer.classList.add('active');
          desktopColumnC.classList.add('pt-5');
          player.play();
          playButton.innerHTML = '&#9632;'; // Stop icon
        }
      });

      // stop when audio ends
      player.on('ended', function() {
        mixContainer.classList.remove('active');
        playButton.innerHTML = '&#9658;';
      });
    }

  });
</script>
<!-- <div>icons are living</div> -->

<?= snippet('footer') ?>