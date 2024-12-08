<?php
$sectionSubtitle = $sectionSubtitle ?? '';

// central initialisation
$ticket_link = $page->ticket_link()->url() ?? null;
$ticket_price = $page->ticket_price()->value() ?? null;
$ticket_price_text = $page->ticket_price_text()->html() ?? null;
$subtitle = $page->subtitle() ?? '';
$location = $page->location() ?? '';
$venue = $page->venues()->toPages()->first() ?? null;
$eventSchedules = $page->eventSchedule()->toStructure() ?? [];
$description = kt($page->description()) ?? '';
$accessibility = kt($page->accessibility()) ?? '';
$artists = $page->artist_link()->toPages() ?? [];
?>
<section class="section" id="col1">
    <ul class="events" id="events-items">
        <h2 class="section-header mobile__section-subtitle"><?= $sectionSubtitle ?> Event</h2>
        <li class="events-item" data-type="events" data-id="<?= $page->id() ?>">
            <h2 class="section-title"><?= $page->title()->html() ?></h2>
        </li>
    </ul>

    <?php
    // tickets
    if ($page->ticketed()->toBool()) : ?>
        <div class="ticket-info">
            <?php if ($ticket_link) : ?>
                <?php if ($ticket_link->isNotEmpty()) : ?>
                    <a href="<?= $ticket_link ?>" class="button__link" aria-label="Visit to purchase tickets" aria-type="link">Tickets</a>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($ticket_price) : ?>
                <span class="ticket-price">$<?= $ticket_price ?></span>
            <?php endif; ?>
            <?php if ($ticket_price_text) : ?>
                <span class="ticket-price-text"><?= $ticket_price_text ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="subtitle">
        <?php if ($subtitle->isNotEmpty()) : ?>
            <span><?= kt($subtitle) ?></span>
        <?php endif; ?>
    </div>

    <?php if ($location) : ?>
        <p class="location"><?= kt($location) ?></p>
    <?php endif; ?>

    <div class="venue">
        <?php
        $venue =  $page->venues()->toPages();
        $venue = $venue->first();
        ?>

        <?php // check page has a venue 
        if ($venue) : ?>
            <?php if ($venue->website()->isNotEmpty()) : ?>
                <a href="<?= $venue->website()->value() ?>" target="_blank">
                    <?= $venue->title() ?>
                </a>
            <?php else : ?>
                <p>
                    <?= $venue->title() ?>
                </p>
            <?php endif; ?>
            <p>
                <?= $venue->location()->html() ?>
            </p>

            <!-- land acknowledgement -->
            <?php if ($venue->land()->isNotEmpty()) : ?>
                <p>
                    <?= $venue->land()->html() ?>
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- artists, image -->
<section class="section" id="col2">
    <ul class="artists" id="artists-items">
        <h2 class="section-header mobile__section-subtitle">Artists</h2>
        <?php
        $artists =  $page->artist_link()->toPages();
        foreach ($artists as $artist) : ?>
            <li class="artists-item" data-type="artists" data-id="<?= $artist->id() ?>">
                <a href="<?= $artist->url() ?>">
                    <?= $artist->title() ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>

    <?php snippet('gallery', ['images' => $page->images()]); ?>

</section>


<section class="section" id="col3">
    <?php
    // event schedule
    $eventSchedules = $page->eventSchedule()->toStructure();
    ?>

    <ul class="event-schedules">
        <?php foreach ($page->eventSchedule()->toStructure() as $schedule) : ?>
            <li class="event-schedule pseudo-list-item">
                <div class="column description">
                    <?= kt($schedule->description()) ?>
                </div>
                <div class="column details">
                    <?php if ($schedule->location()->isNotEmpty()) : ?>
                        <p class="location"><?= $schedule->location()->html() ?></p>
                    <?php endif; ?>

                    <?php if ($schedule->scheduleType()->value() === 'set time' && $schedule->setTime()->isNotEmpty()) : ?>
                        <p class="set-time"><?= $schedule->setTime()->toDate('H:i') ?></p>
                    <?php endif; ?>

                    <?php if ($schedule->scheduleType()->value() === 'multi-day event') : ?>
                        <?php if ($schedule->startDate()->isNotEmpty()) : ?>
                            <p class="start-date"><?= $schedule->startDate()->toDate('d/m/Y H:i') ?></p>
                        <?php endif; ?>
                        <?php if ($schedule->endDate()->isNotEmpty()) : ?>
                            <p class="end-date"><?= $schedule->endDate()->toDate('d/m/Y H:i') ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>



    <?php
    // description
    if ($description = kt($page->description())) : ?>
        <div class="event-details" style="max-width: 60ch;">
            <?= $description ?>
        </div>
    <?php endif; ?>


    <?php
    // event accessibility
    if ($accessibility = kt($page->accessibility())) : ?>
        <h3 class="section__subtitle pseudo-list-item">Accessibility:</h3>
        <div class="accessibility-info" style="max-width: 60ch;"><?= $accessibility ?></div>
    <?php endif; ?>



    <?php
    // venue map
    if ($venue && $venue->map()->isNotEmpty()) : ?>
        <!-- <a>
                            <div class="map map-open" onclick="toggleMap()">
                                <img src="<= $venue -> map() ?>">
                            </div>
                        </a> -->
    <?php endif; ?>

</section>

<?= js([
    'assets/js/gallery.js'
    // 'assets/js/scroll.js',
]) ?>