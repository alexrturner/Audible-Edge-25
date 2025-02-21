<?= js([
  '@auto',
]); ?>

<?= js('assets/js/script.js') ?>
<?php if (!$page->isHomePage()) : ?>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const modeDesktop = document.getElementById("toggle-mode");
      modeDesktop.addEventListener("click", () => {
        changeMode(modeDesktop);
      });
    });
  </script>

<?php endif; ?>

<div class="overlay" style="display: none;">
  <div class="overlay-svg-container">
    <?php
    $logoFiles = $site->files()->template('ae_logo_menu');
    $index = 0;
    foreach ($logoFiles as $file) :
    ?>
      <div class="logo-menu" id="logo-menu-<?= $index ?>" style="<?= $index > 0 ? 'display: none;' : '' ?>">
        <?= $file->read() ?>
      </div>
    <?php
      $index++;
    endforeach;
    ?>
  </div>
</div>

</body>

</html>