<ul class="venue">
    <?php
    $venues =  $page->venues()->toPages();
    foreach ($venues as $venue) : ?>
        <li>
            <a href="<?= $venue->url() ?>"><?= $venue->title() ?></a>

            <p>
                <?= $venue->location()->html() ?>
            </p>

            <!-- land acknowledgement -->
            <?php if ($venue->land()->isNotEmpty()) : ?>
                <p>
                    <?= $venue->land()->html() ?>
                </p>
            <?php endif; ?>

            <!-- custom accessibility details -->
            <?php if ($venue->accessibility_text()->isNotEmpty()) : ?>
                <p>Accessibility:
                    <?= $venue->accessibility_text()->kirbytextinline() ?>
                </p>
            <?php endif; ?>



            <?php if ($venue->accessibility()->isNotEmpty()) : ?>
                <p>Accessibility Features: <?= $venue->accessibility()->html() ?></p>
            <?php endif; ?>




            <!-- Display location features as tags -->
            <?php if ($venue->location_features()->isNotEmpty()) : ?>
                <p>Location Features: <?= $venue->location_features()->html() ?></p>
            <?php endif; ?>

            <!-- Display map -->
            <?php if ($venue->map()->isNotEmpty()) : ?>
                <!-- <a>
                            <div class="map map-open" onclick="toggleMap()">
                                <img src="img/map-transparent.png">
                            </div>
                        </a> -->

            <?php endif; ?>


            <!-- Display website -->
            <?php if ($venue->website()->isNotEmpty()) : ?>
                <p>Website: <a href="<?= $venue->website()->value() ?>" target="_blank"><?= $venue->website()->value() ?></a></p>
            <?php endif; ?>



        </li>
    <?php endforeach ?>
</ul>