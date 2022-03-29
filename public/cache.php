<?php

require_once('../config.php');

$css = '<style>';
$css .= file_get_contents('css/dash.css');
$css .= file_get_contents('css/polyfill.css');
$css .= '</style>';
$js = <<<EOF
function quickdash_opentab(event, tagname) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("quickdash-links tags");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("quickdash-tab-button");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    activetab = document.getElementsByClassName("quickdash-links tags tag-"+tagname);
    for (i = 0; i < activetab.length; i++) { 
        activetab[i].style.display = "inherit";
    }
    event.currentTarget.className += " active";
}
EOF;
$js = '<script>' . $js . '</script>';

$referrer = $_GET['referrer'] ?? '';
$tags = $_GET['tags'] ?? '';
$tags = explode(',', $tags);
$html = rendertabs($referrer, $tags);

$html = $css . $js . $html;

echo $html;

$out = strtr($html,Array("<"=>"&lt;","&"=>"&amp;"));

echo "<br>";
echo "<h1>Code:</h1>";
echo '<pre>';
print_r($out);
echo '</pre>';