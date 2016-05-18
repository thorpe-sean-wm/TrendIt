<?php
$user = 'admin';
$password = 'password';

if (!isset($_SERVER['PHP_AUTH_USER'] ) || !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER'] != $user) || ($_SERVER['PHP_AUTH_PW'] != $password)) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm=TrendIt Admin Page');
    exit('<h2>TrendIt Admin - Error</h2><hr />A valid username and password to access this page.');
};