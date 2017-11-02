<?php

include 'inc/init.php';

// Check request
if ($_SERVER['REQUEST_METHOD'] != 'GET') error(400, 'json');
if (!array_key_exists('profile', $_GET)) error(400, 'json');

// Extract request parameters
$profile = $_GET['profile'];
$date = date('d/m/Y');

// Extract profile name
$profileFile = 'config/' . str_replace('.', '', $profile) . '.profile.php';
if (!file_exists($profileFile)) {
	error(404, 'json');
}

// Setup profile
$_PROFILE = include $profileFile;
$_PROFILE['name'] = str_replace('.', '', $_GET['profile']);

// Send response as JSON
header('Content-type: application/json');
$data = $_CAD->getProfileBookings($_PROFILE, $date);
echo json_encode(array('rsp' => 'ok', 'data' => $data));
