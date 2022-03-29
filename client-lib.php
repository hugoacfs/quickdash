<?php

/**
 * Renders some html for dashboard in a simplified way.
 */
function renderdash(string $referrer = '', string $tags = '') {
    $params = [];
    if ($referrer != '') {
        $params[] = "referrer=$referrer";
    }
    if ($tags != '') {
        $params[] = "tags=$tags";
    }
    if (!empty($params)) {
        $params = implode('&', $params);
        $params = "?$params";
    } else {
        $params = '';
    }
    global $MST, $CFG;
    $json = file_get_contents($CFG->apipath . "/index.php$params");
    $links = (array) json_decode($json);

    $arraylinks = [];
    foreach ($links as $link) {
        $link = (array) $link;
        $arraylinks[] = (array) $link;
    }

    $dash = $MST->render('dash', ['links' => $arraylinks]);
    return $dash;
}

function rendertabs(string $referrer = '', array $tags = []) {
    if (count($tags) == 1) {
        return renderdash($referrer, $tags[0]);
    }
    $tabs = [];
    foreach ($tags as $tag) {
        $params = [];
        $links = [];
        $json = null;
        if ($referrer != '') {
            $params[] = "referrer=$referrer";
        }
        # Unlike the previous function, we only query one tag at a time.
        if ($tag != '' && $tag != 'all') {
            $params[] = "tags=$tag";
        } elseif ($tag == 'all') {
            # By not providing a tag to the api, we get all links anyway.
            $tag = 'all';
        }
        if (!empty($params)) {
            $params = implode('&', $params);
            $params = "?$params";
        } else {
            $params = '';
        }
        global $MST, $CFG;
        $json = file_get_contents($CFG->apipath . "/index.php$params");
        $links = (array) json_decode($json);
        $arraylinks = [];
        foreach ($links as $link) {
            $link = (array) $link;
            $arraylinks[] = (array) $link;
        }
        $tabs[] = ['links' => $arraylinks, 'tag' => ['raw' => $tag, 'human' => ucfirst($tag)]];
    }
    $tabs[0]['tag']['active'] = 'active';
    $dash = $MST->render('tabs', ['tabs' => $tabs]);
    return $dash;
}