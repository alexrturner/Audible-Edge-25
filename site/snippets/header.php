<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">


  <title>
    <?= $page->isHomePage() ? $site->title()->esc() : 'Audible Edge &#x25cf; ' . $page->title()->esc() ?>
  </title>

  <script>
    // plain text view: disable styles on page load
    document.addEventListener('DOMContentLoaded', () => {
      const isDisabled = localStorage.getItem('stylesDisabled') === 'true';
      for (let i = 0; i < document.styleSheets.length; i++) {
        document.styleSheets[i].disabled = isDisabled;
      }
    });
  </script>

  <?= css([
    'assets/css/normalize.v8.0.1.css',
    'assets/css/index.css',
    '@auto',
  ]) ?>

  <?= js([
    'assets/js/script.js'
  ]) ?>

  <script src="https://d3js.org/d3.v7.js"></script>


  <?=
  // Load countdown on home page, menu-overlay on all other pages
  js($page->isHomePage() ? 'assets/js/countdown.js' : 'assets/js/menu-overlay.js')
  ?>

  <link rel="shortcut icon" type="image/x-icon" href="<?= url('/assets/favicon.ico') ?>">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">

  <meta name="description" content="<?= strip_tags($site->metaDescription()->value()) ?>">
  <meta name="keywords" content="<?= strip_tags($site->metaKeywords()->value()) ?>">
  <meta name="author" content="Tone List">
  <meta property="og:image" content="<?= url('/assets/img/AudibleEdge24.jpg') ?>">

</head>

<body class="<?= e($page->isHomePage(), "home", ""); ?>">

  <div class="header-container">
    <header class="header">
      <?php if ($page->isHomePage()) : ?>
        <h1 class="ae-title pseudo-list-item">
          <?= $site->titleDisplay() ?>
        </h1>

      <?php else : ?>
        <a class="ae-title" href="<?= $site->url() ?>" title="<?= $site->title() ?>" aria-label="<?= $site->title() ?> Homepage">
          <h1>
            <?php if ($page->uid() === 'nightschool' || ($page->parent() && $page->parent()->uid() === 'nightschool')) : ?>
              Night School
            <?php else : ?>
              <?= $site->titleDisplay() ?>
            <?php endif ?>
          </h1>
          <div class="svg-banner" style="display: none;">
            <?php if ($page->uid() === 'nightschool' || ($page->parent() && $page->parent()->uid() === 'nightschool')) : ?>
              <?= svg('assets/img/banner/AE24-banner-05.svg') ?>
            <?php else : ?>
              <?= svg('assets/img/banner/AE24-banner-01.svg') ?>
            <?php endif ?>
          </div>
        </a>
        <div class="anchor-point"></div>
      <?php endif ?>


      <?php if ($page->isHomePage() || $page->uid() === 'program') : ?>
        <?php if ($page->isHomePage()) : ?>
          <div class="countdown-container" id="countdown-container">
            Full program announced in <span id="countdown"></span>
          </div>
        <?php endif ?>
      <?php else : ?>

      <?php endif ?>


      <?php
      $snippetArgs = [];
      if ($page->uid() === 'program') {
        snippet('dates-global');
      } elseif (in_array($page->uid(), ['nightschool', 'satellite'])) {
        snippet('dates-global', ['parentPage' => $page->uid()]);
      } elseif (!$page->isHomePage()) {
        snippet('dates-local');
      }
      ?>

    </header>
    <?php if (!$page->isHomePage()) : ?>

      <div class="menu-header-container menu-header-container-global">
        <?php $expanded = "false"; ?>

        <button class="menu-toggle toggle pseudo-list-item" aria-expanded="<?= $expanded ?>" aria-controls="menu-items" aria-label="Toggle Menu">
          Menu
        </button>

        <?php if ($page->uid() === 'program') : ?>
          <div class="desktop__section fixed" id="desktop-menu">
            <ul>
              <li><a href="/satellite" id="page__satellite">Satellite</a></li>
              <li><a href="/nightschool" id="page__nightschool">Night School</a></li>
            </ul>
          </div>
        <?php endif ?>

        <ul class="menu-items <?php e($expanded === "true", "", "hidden"); ?>" id="menu-items">
          <?php foreach ($site->children()->listed() as $p) : ?>
            <li class="menu-item">
              <a <?php e($p->isOpen(), 'aria-current="page"') ?> href="<?= $p->url() ?>" class="menu-link<?php e($p->isOpen(), ' active') ?>">
                <?= $p->title()->esc() ?>
              </a>
            </li>
          <?php endforeach ?>
        </ul>

        <?php
        if ($page->parent()) :
          snippet('pagination-event');
        endif ?>
      </div>
    <?php endif ?>
    <div id="plainTextContainer" class="plain-text-container">
      <button id="togglePlainTextView" class="pseudo-list-item">Plain Text View</button>

      <?php
      // visual settings on home, program, satellite, nightschool
      if ($page->isHomePage() || in_array($page->uid(), ['program', 'satellite', 'nightschool'])) : ?>
        <?php snippet('settings') ?>
      <?php endif ?>

      <?php if ($page->uid() === 'program' && $site->ae_program()) : ?>
        <div class="ae-program-links">
          <?php foreach ($site->files()->template('ae_program') as $ae_program) : ?>
            <a class="pseudo-list-item" href="<?= $ae_program->url() ?>">
              <?= $ae_program->filename() ?>
            </a>
          <?php endforeach ?>
        </div>
      <?php endif ?>
    </div>
  </div>