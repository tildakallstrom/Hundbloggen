<?php
//Tilda Källström 2021 Webbutveckling 2 Mittuniversitetet
include_once('config.php');
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hunddagboken</title> <!-- titel på sidan -->
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="icon" 
      type="image/png" 
      href="bilder/favicon.png">
</head>

<body>
    <header>
        <div class='headerdesktop'> <!-- olika headers för olika storlekar på skärm -->
            <a href="index.php"><img src='bilder/logo2.png' alt='logo' class='logodesktop'></a>
            <div class="headermenu">
                <div>
                    <nav id="nav">
                        <ul id="navigation">

                            <li class='meny'>
                                <a href="about.php">Om</a>
                            </li>
                            <li class='meny'>
                                <a href="blog.php">Senaste</a>
                            </li>
                            <?php
                            //följande menyval finns bara för inloggade användare
                            if (isset($_SESSION['username'])) {
                            ?>
                                <li class='meny'><a href="follower.php">Favoriter</a></li>

                            <?php
                            }
                            ?>

                        </ul>
                    </nav>
                </div>
            </div>
            <div class='rightheader'>
                <nav class='rightnav'>
                    <ul>
                        <?php
                        //följande menyval finns bara för icke inloggade användare
                        if (!isset($_SESSION['username'])) {
                        ?>
                            <li class='meny'><a href="login.php">Logga in</a></li>
                        <?php
                        }
                        ?>

                    
                    <?php
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        echo "<span class='loggedin'>Hej $username!</span>";
                    ?>
                        
                            <li class='meny'><a href="profile.php">Min profil</a></li>
                            <li class='meny'><a href="logout.php">Logga ut</a></li>
                        <?php
                    }
                        ?>
                        </ul>
                </nav>
            </div>

        </div>

        <div class='headermobile'>
            <div class="mobile">
                <div class="ham" id="hamburger" onclick="hamburgermenu(this)">
                    <div class="lineone"></div>
                    <div class="linetwo"></div>
                    <div class="linethree"></div>
                </div>
                <!-- mobilmenyns navigering -->
            </div>

            <nav class="navbar">
                <ul>
                    <li>
                        <a href="about.php">Om</a>
                    </li>
                    <li>
                        <a href="blog.php">Senaste</a>
                    </li>
                    <?php
                    //följande menyval finns bara för inloggade användare
                    if (isset($_SESSION['username'])) {
                    ?>
                        <li class='meny'><a href="follower.php">Favoriter</a></li>
                        <li class='meny'><a href="logout.php">Logga ut</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
            <div>
                <a href="index.php"><img src='bilder/logo1.png' alt='logo' class='logomobile'></a>
            </div>
            <div class='rightheader'>
                <nav class='rightnav'>
                    <ul>
                        <?php
                        //följande menyval finns bara för icke inloggade användare
                        if (!isset($_SESSION['username'])) {
                        ?>
                            <li class='meny'><a href="login.php">Logga in</a></li>
                        <?php
                        }
                        ?>
                    
                    <?php
                    //följande menyval finns bara för inloggade användare
                    if (isset($_SESSION['username'])) {
                        echo "<span class='loggedin'>Hej $username!</span>";
                    ?>
                       
                            <li class='meny'><a href="profile.php">Profil</a></li>
                        <?php
                    }
                        ?>
                        </ul>
                </nav>
            </div>
        </div>
        <script>
            // sätter styling på den länk man befinner sig på
            let navElement = document.getElementById("navigation");

            for (let i = 0; i < navElement.childElementCount; i++) {
                if (window.location.href.split("?")[0] === navElement.children[i].children[0].href.split("?")[0]) {
                    navElement.children[i].children[0].classList.add("current");
                }
            }
        </script>
    </header>