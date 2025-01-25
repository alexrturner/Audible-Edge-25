<?php

function getTimeOfDayBoorloo()
{
    date_default_timezone_set('Australia/Perth');
    $hour = (int)date('H');
    if ($hour >= 3 && $hour < 9) return "dawn";
    if ($hour >= 9 && $hour < 15) return "day";
    if ($hour >= 15 && $hour < 21) return "dusk";
    return "night";
}

function countActiveVisitors()
{
    $kirby = kirby();
    // $visitor = $kirby->visitor();
    // $ip = $visitor->ip();
    $currentPeriod = getTimeOfDayBoorloo();

    $cache = $kirby->cache('visitorCounter');
    // handle total visitor
    $visitorFile = $kirby->root('assets') . '/visitor.json';

    if (!file_exists($visitorFile)) {
        $initData = [
            'periods' => [
                'day' => 0,
                'dusk' => 0,
                'night' => 0,
                'dawn' => 0
            ],
            'currentVisitors' => 0,
            'totalVisitors' => 0
        ];
        file_put_contents($visitorFile, json_encode($initData, JSON_PRETTY_PRINT));
    }

    // read & update current data with file locking
    $fileHandle = fopen($visitorFile, 'r+');
    if (flock($fileHandle, LOCK_EX)) {
        $fileSize = filesize($visitorFile);
        $currentData = $fileSize > 0 ? json_decode(fread($fileHandle, $fileSize), true) : [];


        // set all periods to 0, except current period
        $currentData['periods'] = [
            'day' => ($currentPeriod === 'day') ? $currentData['periods']['day'] : 0,
            'dusk' => ($currentPeriod === 'dusk') ? $currentData['periods']['dusk'] : 0,
            'night' => ($currentPeriod === 'night') ? $currentData['periods']['night'] : 0,
            'dawn' => ($currentPeriod === 'dawn') ? $currentData['periods']['dawn'] : 0
        ];

        // increment current period & total
        $currentData['periods'][$currentPeriod]++;
        $currentData['totalVisitors']++;

        // rewind and write updated data
        ftruncate($fileHandle, 0);
        rewind($fileHandle);
        fwrite($fileHandle, json_encode($currentData, JSON_PRETTY_PRINT));

        flock($fileHandle, LOCK_UN);
    }
    fclose($fileHandle);

    // Return the count for the current period
    return $currentData['periods'][$currentPeriod];
}
