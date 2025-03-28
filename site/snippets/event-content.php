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
$swamps = $site->files()->filterBy('template', 'ae_swamp_svg');


// time
$multi_day = $page->start_date()->toDate('Y-m-d') !== $page->end_date()->toDate('Y-m-d');
$start_time = $page->start_time()->toDate('g' . (substr($page->start_time()->toDate('i'), 0, 2) === '00' ? '' : ':i') . 'a');
$end_time = $page->end_time()->toDate('g' . (substr($page->end_time()->toDate('i'), 0, 2) === '00' ? '' : ':i') . 'a');
?>
<section class="section column a" id="col1">

    <div class="row">
        <h1 class="section-title lighten"><?= $page->title()->html() ?></h1>

        <div class="subtitle">
            <?php if ($subtitle->isNotEmpty()) : ?>
                <span><?= kt($subtitle) ?></span>
            <?php endif; ?>
        </div>

        <?php if ($page->prompts()->isNotEmpty()): ?>
            <div class="description lighten">
                <span class="prefix sml">a</span>
                <div class="descriptors">
                    <?php
                    $prompts = $page->prompts()->toFiles();
                    $index = 0;
                    foreach ($prompts as $prompt): ?>
                        <div
                            class="descriptor"
                            data-sound="<?= $prompt->promptnumber() ?>"
                            data-tooltip="<?= $prompt->icon_label() ?>"
                            aria-label="<?= $prompt->prompt() ?>">
                            <?= svg($prompt) ?>
                        </div><?= ++$index < $prompts->count() ? ',' : '&nbsp;' ?>
                    <?php endforeach ?>
                </div>
                <?= $sectionSubtitle === 'Nightschool' ? 'Night School event' : 'show' ?>
            </div>
        <?php endif ?>

    </div>

    <div class="row content event__details">
        <!-- artists -->
        <div class="col-2">
            <h2 class="section-header prefix sml">with</h2>
            <ul class="artists" id="artists-items">
                <?php
                $artists =  $page->artist_link()->toPages();
                foreach ($artists as $artist) : ?>
                    <li class="artists-item lighten" data-type="artists" data-id="<?= $artist->id() ?>">
                        <a href="<?= $artist->url() ?>">
                            <?php
                            foreach ($artist->display_title()->toStructure() as $display):
                                echo $display->name();
                                $context = [];
                                if ($display->place()->isNotEmpty()) {
                                    $context[] = $display->place();
                                }
                                if ($display->context()->isNotEmpty()) {
                                    $context[] = $display->context();
                                }
                            ?>

                                <?php if (!empty($context)) : ?>
                                    <sub class="artist__context ancillary">
                                        [<?= implode(', ', $context) ?>]
                                    </sub>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>

        <!-- date -->
        <div class="col-2">
            <h2 class="section-header prefix sml">on</h2>
            <div class="datetime">
                <div class="date">
                    <?= $page->start_date()->toDate('l, F j') ?> <?= $multi_day ? ', <span class="time">' . $start_time . '</span>' : '' ?>
                </div>
                <?php if ($multi_day): ?>
                    <div class="time">
                        till
                        <?= $page->end_date()->toDate('l, F j') ?>, <?= $end_time ?>
                    </div>
                <?php else: ?>
                    <div class="time">
                        <?= $start_time ?>–<?= $end_time ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>



        <?php
        // tickets
        if ($page->ticketed()->toBool()) : ?>
            <div class="col-2 ">
                <h2 class="section-header prefix sml">book</h2>
                <div class="ticket__container">
                    <?php if ($ticket_link) : ?>
                        <?php if ($ticket_link->isNotEmpty()) : ?>
                            <a href="<?= $ticket_link ?>" class="button__link lighten" aria-label="Visit to purchase tickets" aria-type="link">Bookings</a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="ticket__details">
                        <?php if ($ticket_price) : ?>
                            <span class="ticket__price">$<?= $ticket_price ?></span>
                        <?php endif; ?>
                        <?php if ($ticket_price_text) : ?>
                            <span class="ticket__price-text"><?= $ticket_price_text ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>




        <!-- location -->
        <div class="col-2">

            <h2 class="section-header prefix sml">at</h2>
            <div class="venue">

                <?php if ($location && $location->isNotEmpty()) : ?>
                    <p class="venue__location"><?= kt($location) ?></p>
                <?php endif; ?>

                <?php // venue 

                $venue =  $page->venues()->toPages();
                $venue = $venue->first();

                if ($venue) : ?>
                    <?php if ($venue->website()->isNotEmpty()) : ?>
                        <a href="<?= $venue->website()->value() ?>" target="_blank">
                            <?= $venue->title() ?>
                        </a>
                    <?php else : ?>
                        <p class="venue__name">
                            <?= $venue->title() ?>
                        </p>
                    <?php endif; ?>
                    <p class="venue__address">
                        <?= $venue->location()->html() ?>
                    </p>

                    <?php // land acknowledgement
                    if ($venue->land()->isNotEmpty()) : ?>
                        <p class="venue__land">
                            <?= $venue->land()->html() ?>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <div class="icon__swamp" id="icon-hue">
        <?= svg($swamps->filterBy('position', 'left')->first()) ?>
    </div>
</section>

<style>
    .title {
        scroll-margin-top: 10rem;
    }
</style>

<!-- img, accessibility -->
<section class="section column b" id="col2">

    <?php snippet('gallery', ['images' => $page->images()]); ?>

    <div class="row">
        <?php
        // event accessibility
        if ($accessibility = kt($page->accessibility())) : ?>
            <h2 id="accessibility" class="title lighten"><a href="#accessibility">Accessibility</a></h2>
            <div class="accessibility-info content lighten"><?= $accessibility ?></div>
        <?php endif; ?>
    </div>

    <div class="icon__swamp" id="icon-saturation" style="rotate: 20deg;">
        <?=
        svg($swamps->filterBy('position', 'middle')->first())
        ?>
    </div>
</section>


<section class="section column c" id="col3">


    <?php
    // event schedule
    $eventSchedules = $page->eventSchedule()->toStructure();
    ?>

    <ul class="event-schedules">
        <?php foreach ($page->eventSchedule()->toStructure() as $schedule) : ?>
            <li class="event-schedule">
                <div class="details sml">
                    <?php
                    $is_multi_day_event = $schedule->scheduleType()->value() === 'multi-day event';
                    $is_set_time = $schedule->scheduleType()->value() === 'set time';
                    // set time
                    if ($is_set_time && $schedule->setTime()->isNotEmpty()) : ?>
                        <p class="set-time"><?= $schedule->setTime()->toDate('g' . (substr($schedule->setTime()->toDate('i'), 0, 2) === '00' ? '' : ':i') . 'a') ?></p>
                    <?php endif; ?>

                    <?php
                    // multi-day event
                    if ($is_multi_day_event) : ?>
                        <?php if ($schedule->startDate()->isNotEmpty()) : ?>
                            <p class="start-date"><?= $schedule->startDate()->toDate('D jS, ga') ?></p>
                        <?php endif; ?>
                        <?php if ($schedule->endDate()->isNotEmpty()) : ?>
                            <p class="end-date"><?= $schedule->endDate()->toDate('D jS, ga') ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="description">
                    <?= kt($schedule->description()) ?>
                    <?php if ($schedule->location()->isNotEmpty()) : ?>
                        <span class="location">at <?= $schedule->location()->html() ?></span>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="space"></div>

    <?php
    // description
    if ($description = kt($page->description())) : ?>
        <div class="event-details row">
            <h2 id="description" class="title lighten"><a href="#description">Details</a></h2>
            <div class="content lighten">
                <?= $description ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="icon__swamp" id="icon-color">
        <?=
        svg($swamps->filterBy('position', 'right')->first())
        ?>
    </div>
</section>

<?= js([
    'assets/js/gallery.js'
    // 'assets/js/scroll.js',
]) ?>