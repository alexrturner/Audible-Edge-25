<?php
// return project title to homepage
return function ($site, $pages, $page) {
    $projectTitle = '';

    if ($page->project()->isNotEmpty()) {
        $projectId = $page->project()->value();
        $projectPage = $site->find($projectId);

        if ($projectPage) {
            $projectTitle = $projectPage->title()->value();
        }
    }

    return [
        'projectTitle' => $projectTitle
    ];
};
