<div class="audible-edge-mix">
    <?php
    $mixFile = $site->files()->template('audio_ae_mix')->first();
    if ($mixFile): ?>
        <div class="mix-player">
            <audio id="player" controls>
                <source src="<?= $mixFile->url() ?>" type="<?= $mixFile->mime() ?>" />
                Your browser does not support the audio element.
            </audio>
            <div class="mix-info">
                <?php if ($mixFile->description()->isNotEmpty()): ?>
                    <p class="mix-description"><?= $mixFile->description() ?></p>
                <?php endif ?>
            </div>
        </div>
    <?php endif ?>
</div>