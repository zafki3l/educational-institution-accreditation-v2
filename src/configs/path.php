<?php
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

$host = $_SERVER['HTTP_HOST']; 

$rootUrl = $scheme . '://' . $host;

define('ROOT_URL', $rootUrl);
