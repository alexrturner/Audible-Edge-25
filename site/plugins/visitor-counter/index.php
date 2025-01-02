<?php

function countActiveVisitors()
{
    $kirby = kirby();
    $visitor = $kirby->visitor();
    $ip = $visitor->ip();

    $cache = $kirby->cache('visitorCounter');

    // 5m timeout period
    $timeout = 300;

    // get current visitors from cache
    $visitors = $cache->get('visitors') ?? [];

    // update current visitor's timestamp
    $visitors[$ip] = time();

    // get & update current total count (JSON)
    $currentData = json_decode(file_get_contents($kirby->root('assets') . '/visitor.json'), true);
    $totalVisitors = $currentData['totalVisitors'] ?? 0;
    $totalVisitors++;


    // rm visitors who have timed out
    foreach ($visitors as $visitorIP => $lastActive) {
        if ($lastActive + $timeout < time()) {
            unset($visitors[$visitorIP]);
        }
    }

    // save to json & cache
    $jsonData = json_encode([
        'currentVisitors' => count($visitors),
        'totalVisitors' => $totalVisitors
    ], JSON_PRETTY_PRINT);
    file_put_contents($kirby->root('assets') . '/visitor.json', $jsonData);

    $cache->set('visitors', $visitors, $timeout);
    return count($visitors);
}
