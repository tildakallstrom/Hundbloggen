<?php
//Tilda Källström 2021 Webbutveckling 2 Mittuniversitetet
//startar session så vi vet vilken som ska destroy
session_start();
//radera session, logga ut
session_destroy();
//skicka vidare användare till index
header("Location: index.php");