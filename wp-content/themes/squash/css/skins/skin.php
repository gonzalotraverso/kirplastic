<?php

$skin = $_GET['skin'];

header("Content-type: text/css; charset: UTF-8");

if (empty($skin))
    $skin = 'default';

$output = <<<HTML

a.more-link { background-image: url({$skin}/arrow-more.png); }

.toggle-label { background-image: url("{$skin}/toggle-button-plus.png"); }

.active-toggle .toggle-label { background-image: url("{$skin}/toggle-button-minus.png"); }


HTML;

echo $output;
?>