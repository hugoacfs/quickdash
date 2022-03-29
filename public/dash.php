<?php

header("Access-Control-Allow-Origin: *");

require_once('../config.php');

$referrer = $_GET['referrer'] ?? '';
$tags = $_GET['tags'] ?? '';

echo renderdash($referrer, $tags);