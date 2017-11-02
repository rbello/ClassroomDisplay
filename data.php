<?php

include 'inc/init.php';

// Check request
if ($_SERVER['REQUEST_METHOD'] != 'GET') error(400, 'json');
if (!array_key_exists('etablissement', $_GET)) error(400, 'json');

// Extract request parameters
$codeEtablissement = substr($_GET['etablissement'], 0, 2);
$date = date('d/m/Y');

// Send response as JSON
header('Content-type: application/json');
$data = $_CAD->getClassRoomsBookings($codeEtablissement, $date);
echo json_encode(array('rsp' => 'ok', 'data' => $data));