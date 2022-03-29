<?php

function loaddata_json() {
    global $CFG;
    if ($CFG->configok != true) {
        return false;
    }
    $filepath = $CFG->dirroot . $CFG->dirsept . 'data.json';
    $data = json_decode(file_get_contents($filepath), true);
    return $data;
}

function loadsvgraw(string $name = 'bootstrap', string $type = 'bootstrap') : string {
    global $CFG;
    $path = $CFG->dirroot .
            $CFG->dirsept .
            'api' .
            $CFG->dirsept .
            'icons' .
            $CFG->dirsept .
            $type .
            $CFG->dirsept .
            $name . '.svg';
    if (!file_exists($path)) {
        // If file does not exist, load something default.
        return loadsvgraw('link-45deg');
    }
    // We must remove any set sizes, so we can control this in CSS.
    $svg = file_get_contents($path);
    $xml = simplexml_load_string($svg);
    $width = 'width';
    $height = 'height';
    $class = 'class';
    $fill = 'fill';
    unset($xml->attributes()->$width);
    unset($xml->attributes()->$height);
    unset($xml->attributes()->$fill);
    $xml->attributes()->$class = "svg-$type-$name dash-svg";
    return $xml->asXML();
}

function fetch_prepared_data(array $tags = [], string $referrer = '', string $svgmode = 'raw') {
    $data = [];
    $data = loaddata_json();
    $links = [];
    $positionlinks = [];
    foreach ($data['links'] as $key => $item) {
        if (!is_array($item)) {
            $item = (array) $item;
        }
        $item['idstring'] = $key;
        if (array_key_exists('hide', $item) && $item['hide'] == 'true') {
            continue;
        }
        // We do not want to show link to self in dashboard.
        if ($key == $referrer) {
            continue;
        }
        if (!empty($tags)) {
            $intersect = array_intersect($tags, $item['tags']) ?? [];
            $counttags = count($intersect);
            if ($counttags < 1) {
                continue;
            }
        }
        if (isset($item['origin']) && $item['origin'] != $referrer) {
            $item['target'] = 'new';
        }
        if ($svgmode == 'raw') {
            $item['svg'] = loadsvgraw($item['icon']['name'], $item['icon']['type']);
        }
        if (array_key_exists('position', $item)) {
            $positionlinks[$item['position']] = $item;
        } else {
            $links[$key] = $item;
        }
    }
    // Joining both arrays
    $links = array_merge($positionlinks, $links);
    return $links;
}

function input_to_data (array $input) {
    // This is the outter array, to mimic the rest of the data.
    $links = [];
    $idstring = $input['idstring'];
    $tags = explode(',', $input['tags']) ?? [];
    $links[$idstring] = [
        'idstring' => $input['idstring'],
        'name' => $input['name'],
        'description' => $input['description'],
        'icon' => [
            'name' => $input['iname'],
            'type' => $input['itype']
        ],
        'url' => $input['url'],
        'source' => $input['source'],
        'tags' => $tags
    ];
    return $links;
}