<?php
$status = $_REQUEST["status"];
$raumnr = $_REQUEST["raumnr"];
file_put_contents( "raum" . $raumnr . ".txt", $status);
echo file_get_contents( "raum" . $raumnr . ".txt");


//LOG File lox.txt in the same folder
$log = file_get_contents( "log.txt" );
$log .= date('d.m.Y H:i:s') . " Raum: " . $raumnr . " | " . $status . "\n";
file_put_contents( "log.txt", $log );
?>
