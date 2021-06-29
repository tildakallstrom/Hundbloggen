<?php
//Tilda Källström 2021 Webbutveckling 2 Mittuniversitetet
//Ladda in klasser
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php';
});

//$localhost = "localhost";
//$blog = "blog";
//$conn = mysqli_connect($localhost, $blog, $blog, $blog);
//DB settings localhost
//define("DBHOST", "localhost");
//define("DBUSER", "blog");
//define("DBPASS", "blog");
//define("DBDATABASE", "blog");


$host = "tildakallstrom.se.mysql";
$user = "tildakallstrom_seblog";
$pass = "pelle123";
$dbb = "tildakallstrom_seblog";
$conn = mysqli_connect($host, $user, $pass, $dbb);

// Db settings (remote - studenter.miun.se)
define("DBHOST", "tildakallstrom.se.mysql");
define("DBUSER", "tildakallstrom_seblog");
define("DBPASS", "pelle123");
define("DBDATABASE", "tildakallstrom_seblog");


// Start session
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}