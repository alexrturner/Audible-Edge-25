<?php

$parentPageSlug = $parentPageSlug ?? 'program';

// get sorted events
$events = page($parentPageSlug)->children()
    ->listed()
    ->sortBy('start_date', 'asc', 'start_time', 'asc');

// group events by date
$eventsByDate = [];
$swamps = $site->files()->filterBy('template', 'ae_swamp_svg');

foreach ($events as $event) {
    $date = $event->start_date()->toDate('l, F j');
    $eventsByDate[$date][] = $event;
}

?>

<div class="program-item-container">

    <?php if ($page->description()->isNotEmpty()) : ?>
        <details>
            <summary>
                <span class="lighten"><?= $page->description_title() ?></span>
            </summary>
            <div class="lighten">
                <?= kt($page->description()) ?>
            </div>
        </details>
    <?php endif; ?>
    <style>
        .button {
            border: 1px solid var(--cc-highlight);
            padding: 0.5rem 0rem;
            border-radius: 0.25rem;
            text-decoration: none;
        }

        .button svg {
            width: 1em;
            height: 1em;
        }

        @media (max-width: 768px) {
            .button {
                width: 100%;
                display: inline-block;
                margin: 1em 0;
            }

            .button svg {
                height: auto;
                width: auto;
                position: absolute;
            }
        }
    </style>

    <?php if ($parentPageSlug === 'program'): ?>
        <?php $program = $site->files()->filterBy('template', 'ae_program')->first(); ?>
        <?php if ($program): ?>
            <a href="<?= $program->url() ?>" class="button lighten"><?= $program->caption()->html() ?><?= svg('assets/img/download.svg') ?></a>
        <?php endif; ?>
    <?php endif; ?>

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
                    <?php if ($event->prompts()->isNotEmpty()): ?>
                        <div class="description lighten">
                            <span class="prefix sml">a</span>
                            <div class="descriptors">
                                <?php
                                $prompts = $event->prompts()->toFiles();
                                $index = 0;

                                foreach ($prompts as $prompt):
                                    $promptNumber = substr($prompt->filename(), 0, 2);

                                ?>
                                    <div
                                        class="descriptor"
                                        data-sound="<?= $promptNumber ?>"
                                        data-tooltip="<?= $prompt->icon_label() ?>"
                                        aria-label="<?= $prompt->prompt() ?>">
                                        <?= svg($prompt) ?>


                                    </div><?= ++$index < $prompts->count() ? ',' : '&nbsp;' ?>
                                <?php endforeach ?>
                            </div>
                            show
                        </div>
                    <?php endif ?>
                    <div class="venue lighten">
                        <span class="prefix sml">at</span><?php if ($event->venues()->isNotEmpty()): ?><span><?= $event->venues()->toPages()->first()->title() ?></span>
                        <?php else: ?>
                            <span><?= $event->location() ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="artists">
                    <span class="prefix sml">with</span>
                    <div class="artists-list">
                        <?php foreach ($event->artist_link()->toPages() as $artist): ?>
                            <div class="artist lighten">
                                <a href="<?= $artist->url() ?>"><?= $artist->title() ?>
                                    <?php
                                    foreach ($artist->display_title()->toStructure() as $display):
                                        $context = [];
                                        if ($display->place()->isNotEmpty()) {
                                            $context[] = $display->place();
                                        }
                                        if ($display->context()->isNotEmpty()) {
                                            $context[] = $display->context();
                                        }
                                        if (!empty($context)):
                                    ?>
                                            <sub class="artist__context ancillary">
                                                [<?= implode(', ', $context) ?>]
                                            </sub>
                                    <?php
                                        endif;
                                    endforeach; ?>
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
    <?php
        endforeach;
    endforeach
    ?>

</div>