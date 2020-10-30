<?php
require_once realpath("vendor/autoload.php");
require_once realpath("src/database.php");
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use MyApp\Data\userDAO;

$user = new userDAO('https://jsonplaceholder.typicode.com/users/1');
$data = $user->getPersonData();
$json = json_decode($data);
print "zadanie 1:";

print '<pre>' . json_encode($user->getAll(), JSON_PRETTY_PRINT) . '</pre>'; 

print "zadanie 2:</br></br>";

print $user->getDomain();

print "</br></br>zadanie 3:";
print '<pre>' . json_encode($json, JSON_PRETTY_PRINT) . '</pre>'; 

$options = new QROptions([
	'version'      => 7,
	'outputType'   => QRCode::OUTPUT_MARKUP_SVG,
	'svgViewBoxSize' => 530,
]);


$qrcode = (new QRCode($options))->render($data);
print $qrcode;

// ZADANIE 5 

print insert_email($dbh, $user->getAll()['email'], substr_count(json_encode($user->getAll()), $user->getDomain() ) );
