<?php

$_CONFIG = include('inc/config.php');

error_reporting($_CONFIG['debug'] ? E_ALL : 0);

require_once('inc/cad.php');

$_CAD = $_CONFIG['debug'] ? new CSVDataReader() : new FNG();