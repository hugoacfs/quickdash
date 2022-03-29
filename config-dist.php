<?php
// Config global.
$CFG = new stdClass;

// Directory vars.
$CFG->dirroot = __DIR__;
$CFG->dirsept = DIRECTORY_SEPARATOR;
$CFG->publicpath = 'http://|https://path-to-your-domain/'; // This domain should point to the public folder.
$CFG->apipath = 'http://|https://path-to-your-domain/'; // This domain should point to the api folder.
$CFG->jspath = $CFG->publicpath . 'dash.js';
$CFG->bootstrapcss = 'https://bootstrap.min.css'; // Points to your bootstrap.min.css.

// Settings.
$CFG->corereferrer = 'core';
$CFG->standardtags = 'student,staff,all';
$CFG->faviconurl = $CFG->publicpath . 'favicon.ico'; // Change to anything you want.
$CFG->logourl = $CFG->publicpath . 'logo.png'; // Change to anything you want.
$CFG->logohref = $CFG->publicpath; // Change to anything you want.
$CFG->logoalt = 'Logo alt text'; // Change to anything you want.

// Add configuration items here.

$CFG->debug = false;
if ($CFG->debug) {
    ini_set('error_logs', 1);
    ini_set('display_error', 1);
    error_log("[QUICKDASH] DEBUG ON!");
}
// Loading external libs.
$CFG->composerok = false;
$CFG->vendordir = $CFG->dirroot .
                $CFG->dirsept .
                'vendor' .
                $CFG->dirsept .
                'autoload.php';

try {
    require_once($CFG->vendordir);
    $CFG->composerok = true;
} catch(Exception $ex) {
    $CFG->composerok = false;
    error_log("[QUICKDASH] Cannot load Mustache.");
}

$CFG->mstok = false;
if ($CFG->composerok) {
    try {
        // Loading Mustache.
        Mustache_Autoloader::register();
        $MST = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader(
                $CFG->dirroot .
                $CFG->dirsept .
                'public'.
                $CFG->dirsept .
                'templates')
            ]
        );
        $CFG->mstok = true;
    } catch (Exception $ex) {
        $CFG->mstok = false;
        error_log("[QUICKDASH] Cannot load Mustache.");
    }
}
// Loading lib.
$CFG->libok = false;
$CFG->apilib = $CFG->dirroot .
                $CFG->dirsept .
                'api-lib.php';
$CFG->clientlib = $CFG->dirroot .
                $CFG->dirsept .
                'client-lib.php';
try{
    require_once($CFG->apilib);
    require_once($CFG->clientlib);
    $CFG->libok = true;
}catch (Exception $ex) {
    $CFG->libok = false;
    error_log("[QUICKDASH] Cannot load lib files.");
}
   

// This shows config is okay.
$CFG->configok = true;

if ($CFG->libok == false || $CFG->mstok == false) {
    $CFG->configok = false;
    error_log("[QUICKDASH] Issues with config, lib files or composer not loading.");
    die;
}

