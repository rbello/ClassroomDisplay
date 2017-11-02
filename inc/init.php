<?php

$_CONFIG = include('inc/config.php');

error_reporting($_CONFIG['debug'] ? E_ALL : 0);

require_once('inc/cad.php');

$_CAD = $_CONFIG['debug'] ? new CSVDataReader() : new FNG();

function error($code, $output = 'html') {
    $status_codes = array (
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended'
    );
    // Select error status message
    if (array_key_exists($code, $status_codes)) {
        $msg = $status_codes[$code];
    }
    else {
        $code = 500;
        $msg = 'Internal Error';
    }
    // Send error code using HTTP protocol
    header($_SERVER['SERVER_PROTOCOL'] . ' ' . $code . ' ' . $msg, true, $code);
    // Display a message
    switch ($output) {
        case 'html' :
            header('Content-type: text/html');
            echo '<h1>Error ' . $code . ' : ' . $msg . '</h1>';
            break;
        case 'json' :
            header('Content-type: application/json');
            echo '{"rsp":"error","error_code":' . $code . ',"error_msg":"' . $msg . '"}';
            break;
        case 'text' :
            header('Content-type: text/plain');
            echo 'Error ' . $code . ' : ' . $msg;
            break;
    }
    exit();
}