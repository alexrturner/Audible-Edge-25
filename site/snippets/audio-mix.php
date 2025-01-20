<div class="audible-edge-mix interact">
    <?php
    $mixFile = $site->files()->template('audio_ae_mix')->first();
    if ($mixFile): ?>
        <div class="mix-player grid">
            <div class="plyr__audio lighten player-wrapper">
                <audio id="player" controls>
                    <source src="<?= $mixFile->url() ?>" type="<?= $mixFile->mime() ?>" />
                    Your browser does not support the audio element.
                </audio>
            </div>
            <div class="mix-info">
                <?php if ($mixFile->description()->isNotEmpty()): ?>
                    <p class="mix-description"><?= $mixFile->description() ?></p>
                <?php endif ?>
            </div>
        </div>
    <?php endif ?>
</div>