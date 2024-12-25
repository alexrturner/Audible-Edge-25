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


    // remove visitors who have timed out
    foreach ($visitors as $visitorIP => $lastActive) {
        if ($lastActive + $timeout < time()) {
            unset($visitors[$visitorIP]);
        }
    }

    // save updated visitors to JSON
    $jsonData = json_encode([
        'currentVisitors' => count($visitors),
        'totalVisitors' => $totalVisitors
    ], JSON_PRETTY_PRINT);
    file_put_contents($kirby->root('assets') . '/visitor.json', $jsonData);

    // save updated visitors to cache
    $cache->set('visitors', $visitors, $timeout);

    // return current visitor count
    return count($visitors);
}
