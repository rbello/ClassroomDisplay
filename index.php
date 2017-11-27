<?php

include 'inc/init.php';

// No profile, display an information page
if (!array_key_exists('profile', $_GET)) {
	include 'inc/welcome.html';
	return;
}

// Extract profile name
$profileFile = 'config/' . str_replace('.', '', $_GET['profile']) . '.profile.php';
if (!file_exists($profileFile)) {
	$_ERROR = 'Profile non configuré';
	include 'inc/error.html';
	return;
}

// Setup profile
$_PROFILE = include $profileFile;
$_PROFILE['name'] = str_replace('.', '', $_GET['profile']);

// Include theme index
include 'themes/' . $_CONFIG['theme'] . '/index.php';