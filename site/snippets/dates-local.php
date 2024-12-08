<?php
// fetch and format dates and times
$start_date = $page->start_date()->toDate('F jS');
$end_date = $page->end_date()->toDate('F jS');

$start_time = $page->start_time();
$end_time = $page->end_time();

// format times
function formatEventTime($startTime, $endTime)
{
    // Check if both start and end times are empty
    if (empty($startTime) && empty($endTime)) {
        return '';
    }

    // Helper function to format a single time
    $formatTime = function ($time) {
        if (empty($time)) {
            return '';
        }

        // convert time to 12-hour format with AM/PM
        $formattedTime = date("g:iA", strtotime($time));

        // rm leading zeros and ':00' for whole hours
        $formattedTime = ltrim($formattedTime, '0');
        $formattedTime = str_replace(':00', '', $formattedTime);

        return $formattedTime;
    };

    $formattedStartTime = $formatTime($startTime);
    $formattedEndTime = $formatTime($endTime);

    // if only start time is provided
    if (!empty($formattedStartTime) && empty($formattedEndTime)) {
        return $formattedStartTime;
    }

    // if both start and end times are provided
    if (!empty($formattedStartTime) && !empty($formattedEndTime)) {
        // if AM/PM are the same, rm from start time
        if (substr($formattedStartTime, -2) === substr($formattedEndTime, -2)) {
            $formattedStartTime = substr($formattedStartTime, 0, -2);
        }
        return $formattedStartTime . '–' . $formattedEndTime;
    }

    // default case
    return '';
}
?>
<div class="dates-container">
    <?php if ($start_date) : ?>
        <span class="mobile__section-subtitle">Date:</span>
        <ul class="dates items">
            <li id="date" class="date pseudo-list-item">
                <?= $start_date ?>
                <span class="time"><?= formatEventTime($start_time, $end_time); ?></span>
            </li>
        </ul>

    <?php endif; ?>
</div>