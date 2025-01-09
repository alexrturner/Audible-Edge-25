<div class="actions <?= $device ?>">

    <div class="action-buttons">
        <div class="audio-container">
            <?php
            $prompts = site()->files()->filterBy('template', 'ae_swamp_svg')->filterBy('is_prompt', true);
            if ($prompts->count() > 0): ?>
                <?php foreach ($prompts as $prompt): ?>
                    <?php $promptText = $prompt->prompt()->html();
                    // replace " character with &quot;
                    $promptText = str_replace('"', '&quot;', $promptText);

                    ?>
                    <div class="prompt-icon lighten" data-icon="<?= $prompt->filename() ?>" data-prompt='<?= $promptText ?>' style="display: none;">
                        <?= svg($prompt) ?>

                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>

        <div class="prompt--container">
            <button id="prompt--info-<?= $device ?>" class="btn--info lighten" aria-label="Show information about Audio Upload"
                onclick="toggleInfo(this)">i</button>
            <button class="prompt--input lighten" id="prompt--input-<?= $device ?>" onclick="userUpload()" aria-label="Next audio prompt">
                <!-- Prompt Me -->
            </button>
        </div>
    </div>

    <div class="action-buttons">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="honeypot" style="position: absolute; left: -9999px;">
                <label for="website">Website <abbr title="required">*</abbr></label>
                <input type="website" id="website" name="website">
            </div>

            <!-- <div class="action-buttons"> -->
            <div class="btns--upload form-field">

                <label for="fileInput">
                    <!-- select files -->
                    <input
                        name="file[]"
                        type="file"
                        accept="audio/*"
                        id="fileInput-<?= $device ?>"
                        style="display: none;"
                        onchange="handleFileSelect(this)">
                    <button class="prompt--upload lighten" id="prompt--upload-<?= $device ?>" type="button" onclick="document.getElementById('fileInput-<?= $device ?>').click()" aria-label="Browse for audio">
                        Upload
                    </button>
                </label>

                <div class="file-info" style="display: none;">
                    <span class="filename ancillary"></span>
                </div>


                <input
                    type="submit"
                    name="submit"
                    value="Submit"
                    class="button submit-button"
                    style="display: none;"
                    aria-label="Submit audio">

                <input type="hidden" name="current_prompt" class="current_prompt" id="current_prompt-<?= $device ?>" value="">
                <input type="hidden" name="current_prompt_text" class="current_prompt_text" id="current_prompt_text-<?= $device ?>" value="">
                <?php if ($success): ?>
                    <div class="alert success">
                        <?= $success ?>
                    </div>
                <?php endif ?>

                <?php if (!empty($alerts)): ?>
                    <div class="alert error">
                        <?php foreach ($alerts as $alert): ?>
                            <div><?= $alert ?></div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

            </div>
        </form>
        <button class="prompt--next lighten" id="prompt--next-<?= $device ?>">Next Prompt</button>
    </div>
    <div class="prompt--info-text" style="display: none;">

        <?php $prompt_info = $site->prompt_info(); ?>
        <?php if ($prompt_info): ?>
            <?= $prompt_info->kt() ?>
        <?php endif ?>

    </div>
</div>