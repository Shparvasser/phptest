<?php
session_start();
$login = $_POST['login'];
$email = $_POST['email'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$day = $_POST['birthDate_d'];
$month = $_POST['birthDate_m'];
$year = $_POST['birthDate_y'];
$countryId = $_POST['country_id'];
$privacy = $_POST['privacy'];
$password = md5($_POST['password']);
$password2 = md5($_POST['password_2']);
$registrationTime = strtotime("now");

$server = "localhost";
$username = "root";
$passwordUserDb = "";
$database = "register";

$mysqli = new MySQLi($server, $username, $passwordUserDb, $database);

if ($mysqli->connect_errno) {
	die("<p><strong>Ошибка подключения к БД</strong></p><p><strong>Код ошибки: </strong> " . $mysqli->connect_errno . " </p><p><strong>Описание ошибки:</strong> " . $mysqli->connect_error . "</p>");
}

$mysqli->set_charset('utf8');

$resultSet = $mysqli->query("SELECT * FROM country");


function Is_email($a)
{
	if (filter_var($a, FILTER_VALIDATE_EMAIL)) {
		return true;
	} else {
		return false;
	}
}
