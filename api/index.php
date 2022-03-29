<?php
require_once('../config.php');

$referrer = $_GET['referrer'] ?? '';
$tags = $_GET['tags'] ?? [];
if (!is_array($tags) && strlen($tags) > 1) {
    $tags = explode(',', $tags) ?? '';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode(fetch_prepared_data($tags, $referrer));