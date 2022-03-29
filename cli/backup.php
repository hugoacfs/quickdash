<?php

if (php_sapi_name() != "cli") {
    echo 'cli script can only be run command line.';
    die();
}

require_once('../config.php');
/**
 * This script makes a backup of the MongoDB 'links' collection, timestamped.
 *
 */
$json = json_encode(fetch_prepared_data([], '', 'none'));
$filename = $CFG->dirroot . $CFG->dirsept . 'backup' . $CFG->dirsept . 'data-' . time() . '.json';

file_put_contents($filename, $json);

echo 'Backed up.';