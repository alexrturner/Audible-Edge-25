<?php
// arguments: filter (event type)
$filter = $filter ?? null;

$jsonPath = kirby()->root('assets') . '/data/relations.json';
$jsonData = json_decode(file_get_contents($jsonPath), true);

$filteredArtistIDs = [];

foreach ($jsonData['events'] as $eventUUID => $eventData) {
    if (in_array($filter, $eventData['event_type'])) {
        // if event is of an event type, collect all artist IDs
        foreach ($eventData['artists'] as $artistID) {
            $filteredArtistIDs[$artistID] = true; // use keys to avoid duplicates
        }
    }
}
?>

<div class="section artists filtered" id="artists">
    <ul class="artists-container">
        <li class="artists-item first-item">
            <button class="artists-toggle toggle" aria-expanded="true" aria-label="Toggle lineup list" aria-controls="artists-items">
                <h2 class="section-title">Lineup</h2>
            </button>
            <br><br>
            <div class="artists-content">
                <ul class="items" id="artists-items">
                    <?php foreach (array_keys($filteredArtistIDs) as $artistID) : ?>
                        <?php if (isset($jsonData['artists'][$artistID])) : ?>
                            <?php $artistData = $jsonData['artists'][$artistID]; ?>
                            <li class="artists-item" data-type="artists" data-id="<?= htmlspecialchars($artistID) ?>">
                                <a href="/<?= htmlspecialchars($artistID) ?>" class="artists-link">
                                    <?= htmlspecialchars($artistData['title']) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </li>
    </ul>
</div>