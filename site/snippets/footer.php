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

</body>

</html>