<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">


  <title>
    <?= $page->isHomePage() ? $site->title()->esc() : 'Audible Edge &#x25cf; ' . $page->title()->esc() ?>
  </title>

  <?= css([
    'assets/css/normalize.v8.0.1.css',
    '@auto',
  ]) ?>

  <?= js([
    'assets/js/columnFocus.js'
  ]) ?>

  <link rel="shortcut icon" type="image/x-icon" href="<?= url('/assets/favicon.ico') ?>">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">

  <meta name="description" content="<?= strip_tags($site->metaDescription()->value()) ?>">
  <meta name="keywords" content="<?= strip_tags($site->metaKeywords()->value()) ?>">
  <meta name="author" content="Tone List">
  <meta property="og:image" content="<?= url('/assets/img/AudibleEdge24.jpg') ?>">

  <!-- STD placeholder font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
  <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

  <!-- grotesk -->
  <link rel="stylesheet" href="https://use.typekit.net/chf4zka.css">
</head>