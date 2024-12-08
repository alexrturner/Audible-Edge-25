<div id="lineCanvas-container" style="display: none;">
  <svg id="lineCanvas">
    <!-- squig -->
  </svg>
</div>

<?php
// load relations SVG on home page and nightschool index
if ($page->isHomePage() || $page->uid() === "program" || $page->uid() === "nightschool" || $page->uid() === "satellite") : ?>
  <?= js([
    'assets/js/ae24-squig.js',
    '@auto',
  ]) ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // not .events-item.first-item
      const eventItems = document.querySelectorAll('.events-item:not(.first-item)');
      const timesContainer = document.getElementById('dates-event-times');
      eventItems.forEach(function(item) {
        item.addEventListener('mouseover', function() {
          const startTime = this.getAttribute('data-start-time');
          const endTime = this.getAttribute('data-end-time');
          if (startTime && endTime) {
            timesContainer.textContent = `Start: ${startTime}, End: ${endTime}`;
          }
        });


        item.addEventListener('mouseout', function() {
          timesContainer.textContent = '';
        });
      });
    });
  </script>

<?php else : ?>
  <?= js([
    '@auto',
  ]) ?>
<?php endif ?>

<?php $parent = $page->parent();
// check if the parent UID matches one of the specific pages
// and if the current page's template matches one of the specified templates
if ($parent && in_array($parent->uid(), ['program', 'satellite', 'nightschool'])) :
  js([
    'assets/js/event-svg.js'
  ]);
endif; ?>

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