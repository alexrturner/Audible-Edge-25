<?php snippet('header') ?>

<main>
    <div class="content-container all-listings">
        <div class="section events" id="events">
            <ul class="events-container">
                <li class="events-item first-item">
                    <button class="events-toggle toggle" aria-expanded="true" aria-controls="events-items" aria-label="Toggle program">Program</button>
                    <br><br>
                    <?php snippet('listings', ['parentPageSlug' => 'program', 'className' => 'events']); ?>
                </li>
            </ul>
        </div>

        <div class="section artists" id="artists">
            <ul class="artists-container">
                <li class="artists-item first-item">
                    <button class="artists-toggle toggle" aria-expanded="true" aria-controls="artists-items" aria-label="Toggle lineup">Lineup</button>
                    <br><br>
                    <div class="artists-content">
                        <?php snippet('listings', ['parentPageSlug' => 'artists', 'className' => 'artists']); ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</main>

<?php snippet('footer') ?>