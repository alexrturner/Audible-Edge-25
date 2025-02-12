<?php
// all listed events sorted by 'start_date' and 'start_time'
if ($page->parent()->uid() === 'program') {
    $allEvents = page('program')->children()->listed()->sortBy('start_date', 'asc', 'start_time', 'asc');
} elseif ($page->parent()->uid() === 'nightschool') {
    $allEvents = page('nightschool')->children()->listed()->sortBy('start_date', 'asc', 'start_time', 'asc');
} else {
    return;
}

// current event's position
$currentEventIndex = $allEvents->indexOf($page);

$prevEvent = null;
$nextEvent = null;

if ($currentEventIndex !== false) {
    $prevEvent = ($currentEventIndex > 0) ? $allEvents->nth($currentEventIndex - 1) : null;
    $nextEvent = ($currentEventIndex < $allEvents->count() - 1) ? $allEvents->nth($currentEventIndex + 1) : null;
}
?>

<style>
    .pagination-arrow {
        position: relative;
        display: inline-block;
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
        background-color: var(--cc-highlight-background);
        border-radius: 1rem;
        transition: background-color 1000ms linear;
        color: var(--cc-highlight-foreground);
        text-align: center;
        align-content: center;
    }

    /* Hover */
    .pagination-arrow:hover {
        background-color: var(--cc-light);
    }

    .pagination-arrow:hover:before {
        background-color: white;
    }
</style>
<?php if ($currentEventIndex !== false) : ?>
    <nav class="pagination">
        <?php if ($prevEvent) : ?>
            <a class="pagination-arrow pseudo-list-item" href="<?= $prevEvent->url() ?>" title="<?= $prevEvent->title() ?>" rel="prev">&larr;<span class="hidden"> Previous Event</span></a>
        <?php endif; ?>


        <?php if ($nextEvent) : ?>
            <a class="pagination-arrow pseudo-list-item" href="<?= $nextEvent->url() ?>" title="<?= $nextEvent->title() ?>" rel="next"><span class="hidden">Next Event </span>&rarr;</a>
        <?php endif; ?>
    </nav>
<?php endif; ?>