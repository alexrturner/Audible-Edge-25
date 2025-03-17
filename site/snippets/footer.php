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

<?php if ($page->uid() === "program" || $page->uid() === "nightschool") : ?>
  <style>
    .icons__swamp {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      overflow: hidden;
    }

    .mobile .icon__swamp {
      opacity: 1;
    }
  </style>
  <?php $swamps = $site->files()->filterBy('template', 'ae_swamp_svg'); ?>
  <div class="icons__swamp">
    <div class="icon__swamp" id="icon-hue">
      <?= svg($swamps->filterBy('position', 'left')->first()) ?>
    </div>
    <div class="icon__swamp" id="icon-saturation">
      <?= svg($swamps->filterBy('position', 'middle')->first()) ?>
    </div>
    <div class="icon__swamp" id="icon-color">
      <?= svg($swamps->filterBy('position', 'right')->first()) ?>
    </div>
  </div>
<?php endif; ?>
</body>

</html>