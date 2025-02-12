<?php
// Get all events and sort them by start date/time
$events = page('program')->children()
    ->listed()
    ->sortBy('start_date', 'asc', 'start_time', 'asc');

// Group events by date
$eventsByDate = [];
foreach ($events as $event) {
    $date = $event->start_date()->toDate('l, F j');
    $eventsByDate[$date][] = $event;
}
?>

<div class="program-item-container">
    <?php
    $previousDate = null;
    foreach ($eventsByDate as $date => $dayEvents):
        foreach ($dayEvents as $event):
    ?>
            <div class="program-item">
                <div>
                    <?php if ($date !== $previousDate): ?>
                        <div class="date lighten"><?= $date ?></div>
                        <?php $previousDate = $date; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <div class="time lighten">

                        <?php
                        // format time
                        $start = $event->start_time()->toDate('g' . (substr($event->start_time()->toDate('i'), 0, 2) === '00' ? '' : ':i') . 'a');
                        $end = $event->end_time()->toDate('g' . (substr($event->end_time()->toDate('i'), 0, 2) === '00' ? '' : ':i') . 'a');
                        ?>
                        <?= $start ?>–<?= $end ?>


                    </div>
                </div>
                <div class="event">
                    <h2 class="event-title lighten">
                        <a href="<?= $event->url() ?>"><?= $event->title() ?></a>
                    </h2>
                    <div class="description lighten">
                        <span class="prefix sml">a</span>
                        <div class="descriptors">
                            <?php foreach ($event->prompts()->toFiles() as $prompt): ?>
                                <!-- TODO: comma is still showing on last prompt -->
                                <img
                                    class="descriptor"
                                    data-sound="<?= $prompt->promptnumber() ?>"
                                    data-tooltip="<?= $prompt->prompt() ?>"
                                    alt="<?= $prompt->prompt() ?>"
                                    src="<?= $prompt->url() ?>" /><?= !$prompt->isLast() ? ',' : '' ?>
                            <?php endforeach ?>
                        </div>
                        show
                    </div>
                    <div class="venue lighten">
                        <span class="prefix sml">at</span>
                        <?php if ($event->venues()->isNotEmpty()): ?>
                            <span><?= $event->venues()->toPages()->first()->title() ?></span>
                        <?php else: ?>
                            <span><?= $event->location() ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="artists">
                    <?php foreach ($event->artist_link()->toPages() as $artist): ?>
                        <div class="artist lighten">
                            <a href="<?= $artist->url() ?>"><?= $artist->title() ?></a>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
    <?php
        endforeach;
    endforeach
    ?>
</div>