<?php

$dbHost = 'mysql';
$dbUser = 'reporting';
$dbPassword = 'reporting_password';
$dbDatabase = 'cpp_interview';

return new mysqli($dbHost, $dbUser, $dbPassword, $dbDatabase);
