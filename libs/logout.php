<?php
require_once __DIR__ . '/header.php';
require "/OpenServer/domains/TaskTestPhp/dbConfig/db.php";

unset($_SESSION['logged_user']);

header('Location: index.php');

require_once __DIR__ . '/footer.php';
