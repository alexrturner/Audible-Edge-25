<?php snippet('header') ?>

<main class="content-container filtered-listings">

    <div class="section filtered" id="events">
        <ul class="events-container">
            <li class="nightschool-item first-item">
                <button class="events-toggle toggle" aria-expanded="true" aria-controls="events-items" aria-label="Toggle night school program listings">
                    <h2 class="section-title">Program</h2>
                </button>
                <br><br>
                <?php snippet('listings', ['parentPageSlug' => 'nightschool', 'className' => 'events']); ?>
            </li>
        </ul>
    </div>

    <?php snippet('artists-filtered', ['filter' => 'nightschool']) ?>

    <?php snippet('description') ?>

</main>

<?php snippet('footer') ?>