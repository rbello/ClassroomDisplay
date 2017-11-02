<?php

$base = dirname(__FILE__) . '/../config/';
$file = $base . 'default.config.php';

if (file_exists($base . 'production.config.php'))
    $file = $base . 'production.config.php';

return include($file);