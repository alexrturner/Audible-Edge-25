<?php

return function ($kirby, $page) {
    $alerts  = [];
    $success = '';

    if ($kirby->request()->is('post') === true && get('submit')) {
        // check the honeypot
        if (empty(get('website')) === false) {
            go($page->url());
            exit();
        }

        $uploads = $kirby->request()->files()->get('file');

        $promptNumber = get('current_prompt');
        $promptText = get('current_prompt_text');

        if (!$promptNumber) {
            $alerts['promptError'] = 'No prompt selected';
            return compact('alerts', 'success');
        }

        // we only want 1 file
        if (count($uploads) > 1) {
            $alerts['exceedMax'] = 'You may only upload 1 file.';
            return compact('alerts', 'success');
        }

        // authenticate as almighty
        $kirby->impersonate('kirby');

        foreach ($uploads as $upload) {
            // check for duplicate
            $files      = page('storage')->files();
            $duplicates = $files->filter(function ($file) use ($upload) {
                // get original safename without prefix
                $pos              = strpos($file->filename(), '_');
                $originalSafename = substr($file->filename(), $pos + 1);

                return $originalSafename === F::safeName($upload['name']) &&
                    $file->mime() === $upload['type'] &&
                    $file->size() === $upload['size'];
            });

            if ($duplicates->count() > 0) {
                $alerts[$upload['name']] = "The file already exists";
                continue;
            }

            try {

                // new filename with prompt number prefix
                $name = $promptNumber . '_' . crc32($upload['name'] . microtime()) . '_' . $upload['name'];

                $file = page('storage')->createFile([
                    'source'   => $upload['tmp_name'],
                    'filename' => $name,
                    'template' => 'upload',
                    'content' => [
                        'date' => date('Y-m-d h:m'),
                        'promptNumber' => $promptNumber,
                        'prompt' => $promptText

                    ]
                ]);
                // success mssg here ? 
                $success = '';
            } catch (Exception $e) {
                $alerts[$upload['name']] = $e->getMessage();
            }
        }
    }

    return [
        'alerts' => $alerts,
        'success' => $success
    ];
};
