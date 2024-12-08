<?php snippet('header') ?>

<main class="content-container index">

    <div class="section satellite" id="events">
        <ul class="events-container">
            <li class="satellite-item first-item">
                <button class="satellite-toggle toggle" aria-expanded="true" aria-controls="satellite-items" aria-label="Toggle satellite program listings">
                    <h2 class="section-title">Program</h2>
                </button>
                <br><br>
                <?php snippet('listings', ['parentPageSlug' => 'satellite', 'className' => 'events']); ?>
            </li>
        </ul>
    </div>

    <?php snippet('artists-filtered', ['filter' => 'satellite']) ?>

    <?php snippet('description') ?>

</main>

<?php snippet('footer') ?>